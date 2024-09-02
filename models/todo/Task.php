<?php

namespace models\todo;

use PDO;
use PDOException;
use models\Database;

class Task {
    private $dbConnection;

    public function __construct() {
        $this->dbConnection = Database::getInstance()->getConnection();
    }

    public function getAllTasks() {
        $query = "SELECT * FROM todo_list";

        $statement = $this->dbConnection->query($query);

        $tasks = [];
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $tasks[] = $row;
        }

        return $tasks;
    }

    public function getAllNewTasksByUserId($user_id) {     // Выдает отсортированные, по времени, задачи, которые не просрочены и не выполнены
        $query = "SELECT * FROM todo_list
        WHERE user_id = ? AND status = 'В ожидании'
        ORDER BY ABS(TIMESTAMPDIFF(SECOND, NOW(), created_at))";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$user_id]);

        $tasks = [];
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $tasks[] = $row;
        }
        return $tasks;
    }

    public function getAllTasksByUserId($user_id) {     // Выдает отсортированные, по времени, задачи, которые не просрочены и не выполнены
        $query = "SELECT * FROM todo_list
        WHERE user_id = ? AND status = 'К выполнению'
        ORDER BY ABS(TIMESTAMPDIFF(SECOND, NOW(), created_at))";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$user_id]);

        $tasks = [];
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $tasks[] = $row;
        }
        return $tasks;
    }

    public function getAllCompletedTasksByUserId($user_id) {     // Выдает отсортированные, по времени, задачи, которые выполнены
        $query = "SELECT * FROM todo_list 
        WHERE user_id = ? AND status = 'Выполнено'  
        ORDER BY ABS(TIMESTAMPDIFF(SECOND, NOW(), created_at))";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$user_id]);

        $tasks = [];
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $tasks[] = $row;
        }

        return $tasks;
    }

    public function getAllArchiveTasksByUserId($user_id) {     // Выдает отсортированные, по времени, задачи, которые выполнены
        $query = "SELECT * FROM todo_list 
        WHERE user_id = ? AND status = 'Архив'  
        ORDER BY ABS(TIMESTAMPDIFF(SECOND, NOW(), created_at))";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$user_id]);

        $tasks = [];
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $tasks[] = $row;
        }

        return $tasks;
    }


    public function getTaskById($task_id){
        $query = "SELECT * FROM todo_list WHERE id = ?";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$task_id]);

        $task = $statement->fetch(PDO::FETCH_ASSOC); 

        return $task ? $task : false;
    }

    public function getTasksByTagId($tag_id, $user_id){
        $query = "SELECT * FROM todo_list
        JOIN task_tags ON todo_list.id = task_tags.task_id
        WHERE task_tags.tag_id = :tag_id AND todo_list.user_id = :user_id ORDER BY ABS(TIMESTAMPDIFF(SECOND, NOW(), created_at));";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute(['tag_id' => $tag_id, 'user_id' => $user_id]);
        $tasks = $statement->fetchAll(\PDO::FETCH_ASSOC);
        
        return $tasks ? $tasks : $tasks = [];
    }

    public function getTaskByIdAndUserId($id_task, $id_user){
        $query = "SELECT * FROM todo_list WHERE id = ? AND user_id = ?";

        $statement =$this->dbConnection->prepare($query);
        $statement->execute([$id_task, $id_user]);

        $todo_task = $statement->fetch(\PDO::FETCH_ASSOC);

        return $todo_task ? $todo_task : [];
    }

    public function getTasksCountAndStatusByUserId($user_id){
        $query = "SELECT COUNT(*) AS all_tasks,
        SUM(status = 'completed') AS completed,
        SUM(status != 'completed') AS opened
        FROM todo_list WHERE user_id = :user_id";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute(['user_id' => $user_id]);

        $tasks = $statement->fetchAll(\PDO::FETCH_ASSOC);

        return $tasks ? $tasks : $tasks = [];
    }

    public function create($data){
        $query = "INSERT INTO todo_list (user_id, client_id, category_id, status) VALUE (?, ?, ?, ?)";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$data['user_id'], $data['client_id'], $data['category_id'], $data['status']]);
    }

    public function update($data){
        $query = "UPDATE todo_list SET client_id = ?, category_id = ?, status = ?, description = ?, client_id = ? WHERE id = ?";
        
        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$data['client_id'], $data['category_id'], $data['status'], $data['description'],  $data['client_id'], $data['id']]);
    }

    public function updateStatus($id, $status, $datetime) {
        $query = "UPDATE todo_list SET status = :status, completed_at = :completed_at WHERE id = :id";

        $params = [':status' => $status, ':id' => $id, ':completed_at' => $datetime ?? null];

        $statement = $this->dbConnection->prepare($query);
        $statement->execute($params);
        
        return $statement->rowCount() > 0;
    }

    public function delete($task_id){
        $query = "DELETE FROM todo_list WHERE id = ?";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$task_id]);
    }
    
}