<?php
namespace controllers;
use models\todo\Task;
use models\todo\Client;

class HomeController {

    public function displayIndex() {
        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
    
        $taskmodel = new Task();
        $tasks = $taskmodel->getAllTasksByUserId($user_id);

        $clientModel = new Client();
        foreach ($tasks as &$currentTask) {
            $currentTask['client'] = $clientModel->getClientById($currentTask['client_id']);
        }
        $tasksJson = json_encode($tasks);

        include 'app/crm/index.php';
    }
}