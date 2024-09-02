<?php

namespace controllers\todo;

use models\todo\Tag;
use models\todo\Task;
use models\todo\Category;
use models\todo\Client;

class TaskController {
    private $returnPath = '/crm/todo/tasks';
    private $user_id;
    private $tagModel;
    private $taskModel;
    private $categoryModel;
    private $clientModel;

    public function __construct()
    {
        $this->user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
        $this->tagModel = new Tag();
        $this->taskModel = new Task();
        $this->categoryModel = new Category();
        $this->clientModel = new Client();
    }

    public function displayIndex(){
        $newTasks = $this->taskModel->getAllNewTasksByUserId($this->user_id);
        $tasks = $this->taskModel->getAllTasksByUserId($this->user_id);
        $completedTasks = $this->taskModel->getAllCompletedTasksByUserId($this->user_id);
        
        foreach ($tasks as &$currentTask) {
            $currentTask['tags'] = $this->tagModel->getTagsByTaskId($currentTask['id']);
            $currentTask['category'] = $this->categoryModel->getCategoryById($currentTask['category_id']);
            $currentTask['client'] = $this->clientModel->getClientById($currentTask['client_id']);
            $currentTask['city_info'] = $this->clientModel->getCityAndAreaByCityId($currentTask['client']['city_id']);
        }

        foreach ($completedTasks as &$currentTask) {
            $currentTask['tags'] = $this->tagModel->getTagsByTaskId($currentTask['id']);
            $currentTask['category'] = $this->categoryModel->getCategoryById($currentTask['category_id']);
            $currentTask['client'] = $this->clientModel->getClientById($currentTask['client_id']);
            $currentTask['city_info'] = $this->clientModel->getCityAndAreaByCityId($currentTask['client']['city_id']);
        }

        foreach ($newTasks as &$currentTask) {
            $currentTask['tags'] = $this->tagModel->getTagsByTaskId($currentTask['id']);
            $currentTask['category'] = $this->categoryModel->getCategoryById($currentTask['category_id']);
            $currentTask['client'] = $this->clientModel->getClientById($currentTask['client_id']);
            $currentTask['city_info'] = $this->clientModel->getCityAndAreaByCityId($currentTask['client']['city_id']);
        }

        include 'app/crm/todo/task/index.php';
    }

    public function showCreateForm(){
        $categories = $this->categoryModel->getAllVisibleCategories();
        
        $clients = $this->clientModel->getAllClients();

        include 'app/crm/todo/task/create.php';
    }
    
    public function showEditForm($params){                 
        $selectedTask = $this->taskModel->getTaskById($params['id']); // Для нахождения таска при открытии формы изменения

        if(!$selectedTask || $selectedTask['user_id'] != $this->user_id){
            http_response_code(404);
            include 'app/crm/errors/404.php';
            return;
        }

        $clients = $this->clientModel->getAllClients();

        $categories = $this->categoryModel->getAllVisibleCategories();

        $tags = $this->tagModel->getTagsByTaskId($selectedTask['id']);

        include 'app/crm/todo/task/edit.php';
    }

    public function showArchive(){
        $tasks = $this->taskModel->getAllArchiveTasksByUserId($this->user_id);
        
        foreach ($tasks as &$currentTask) {
            $currentTask['tags'] = $this->tagModel->getTagsByTaskId($currentTask['id']);
            $currentTask['category'] = $this->categoryModel->getCategoryById($currentTask['category_id']);
            $currentTask['client'] = $this->clientModel->getClientById($currentTask['client_id']);
        }

        include 'app/crm/todo/task/archive.php';
    }

    public function createTask(){
        if(!$this->validateInput(['client_id', 'category_id'])){
            echo "Fields are not filled in";
            return;
        }

        $data = [
            'client_id' => !empty($_POST['client_id']) ? trim(htmlspecialchars($_POST['client_id'])) : null,
            'category_id' => htmlspecialchars(trim($_POST['category_id'])),
            'user_id' => isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0,
            'status' => START_TASK_STATUS,
        ];

        $this->taskModel->create($data);
        header("Location: $this->returnPath");
    }

    public function createClientWithTask(){
        $dataClient = [
            'full_name' => trim(htmlspecialchars($_POST['full_name'])),
            'identification_number' => trim(htmlspecialchars($_POST['identification_number'])),
            'phone' => trim(htmlspecialchars($_POST['phone'])),
            'vehicle_number' => trim(htmlspecialchars($_POST['vehicle_number'])),
        ];

        $clientId = $this->clientModel->create($dataClient);

        $dataTask = [
            'client_id' => $clientId,
            'category_id' => htmlspecialchars(trim($_POST['category_id'])),
            'user_id' => 1,
            'status' => START_TASK_STATUS,
        ];
        tt($dataTask);
        $this->taskModel->create($dataTask);
    }
    
    public function updateTask(){
        if(!$this->validateInput(['client_id', 'id', 'category_id'])){
            echo "Fields are not filled in";
            return;
        }

        $data = [
            'id' => $_POST['id'],
            'category_id' => trim(htmlspecialchars($_POST['category_id'])),
            'status' => trim(htmlspecialchars($_POST['status'])),
            'description' => trim(htmlspecialchars($_POST['description'])),
            'client_id' => !empty($_POST['client_id']) ? trim(htmlspecialchars($_POST['client_id'])) : null,
            'user_id' => isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0
        ];

        $tags = explode(',', $_POST['tags']);           // Рвзбиение строки с тегами
        $tags = array_map('trim', $tags);

        $this->tagModel->removeAllTaskTags($data['id']);           // Удаление старых связей между тегами и задачей
        
        foreach ($tags as $tagName){
            $tagNameLower = strtolower($tagName);        // Приводим название тега к нижнему регистру
            $tag = $this->tagModel->getTagByNameAndUserId($tagNameLower, $data['user_id']);
            // Если тег не существует, добавляем его и получаем его ID
            // Если тег уже существует, используем его ID
            $tag_id = !$tag ? $this->tagModel->addTag($tagNameLower, $data['user_id']) : $tag['id'];
            $this->tagModel->bindTaskTag($data['id'], $tag_id);    // Связываем задачу с тегом
        }

        $oldTags = $this->tagModel->getTagsByTaskId($data['id']); // Получение тегов с базы по задаче, которую редактируем
        foreach ($oldTags as $oldTag){                      // Удаляем неиспользуемые теги
            $this->tagModel->removeUnusedTag($oldTag['id']);
        }

        $this->taskModel->update($data);
        header("Location: $this->returnPath");
    }

    public function deleteTask($params){
        $this->taskModel->delete($params['id']);
        header("Location: $this->returnPath");
    }

    public function tasksByTag($params){
        $tasksByTag = $this->taskModel->getTasksByTagId($params['id'], $this->user_id);

        $tagname = $this->tagModel->getTagNameById($params['id']);
        // Получение списка тегов для каждой записи в массиве
        foreach($tasksByTag as &$currentTask){
            $currentTask['tags'] = $this->tagModel->getTagsByTaskId($currentTask['task_id']);
            $currentTask['category'] = $this->categoryModel->getCategoryById($currentTask['category_id']);
            $currentTask['client'] = $this->clientModel->getClientById($currentTask['category_id']);
        }

        include 'app/crm/todo/task/by-tag.php';
    }

    public function updateTaskStatus($params){
        $status = trim(htmlspecialchars($_POST['status']));
        $datetime = ($status === 'Выполнено') ? date("Y-m-d H:i:s") : null;

        if ($status) {
            $this->taskModel->updateStatus($params['id'], $status, $datetime);
            header("Location: /crm/todo/tasks");
        } else {
            http_response_code(404);
            include 'app/crm/errors/404.php';
            return;
        }
    }

    public function viewTask($params){

        $task_id = isset($params['id']) ? intval($params['id']) : 0;

        $task = $this->taskModel->getTaskByIdAndUserId($task_id, $this->user_id);

        if(!$task || $task['user_id'] != $this->user_id){
            http_response_code(404);
            include 'app/crm/errors/404.php';
            return;
        }

        $category = $this->categoryModel->getCategoryById($task['category_id']);

        if(!$task){
            http_response_code(404);
            include 'app/crm/errors/404.php';
            return;
        }
        $client = $this->clientModel->getClientById($task['client_id']);
        $tags = $this->tagModel->getTagsByTaskId($task['id']);

        include 'app/crm/todo/task/task-information.php';
    }

    private function validateInput($fields){
        foreach($fields as $field){
            if(!isset($_POST[$field]) || empty(trim($_POST[$field]))){
                return false;
            }
        }
        return true;
    }
}