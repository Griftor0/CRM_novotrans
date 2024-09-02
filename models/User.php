<?php

namespace models;

use PDO;
use models\Database;

class User{
    private $dbConnection;
    
    public function __construct(){
        $this->dbConnection = Database::getInstance()->getConnection();
    }

    public function getAllUsers(){      // Показать всех пользователей
        $query = "SELECT * FROM users";

        $statement = $this->dbConnection->query($query);

        $users = [];
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $users[] = $row;
        }

        return $users;
    }

    public function getUserByEmail($email) {
        $query = "SELECT * FROM users WHERE email = ? LIMIT 1";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$email]);
        
        $user = $statement->fetch(PDO::FETCH_ASSOC);

        return $user ? $user : false;
    }
    
    public function create($username, $email, $password, $role, $created_at){
        $query = "INSERT INTO users (username, email, password, role, created_at) VALUE (?, ?, ?, ?, ?)";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$username, $email, password_hash($password, PASSWORD_DEFAULT), $role, $created_at]);
    }
    
    public function getUserById($user_id){          // Найти пользователя по id для создания формы редактирования 
        $query = "SELECT * FROM users WHERE id = ?";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$user_id]);

        $user = $statement->fetch(PDO::FETCH_ASSOC); 

        return $user ? $user : false;
    }
    
    public function update($user_id, $updateData){         // Редактировать пользователя по id. Принимаем массив $updateData c контроллера
        $username = trim(htmlspecialchars($updateData['username']));    // Меняем только имя, email и роль
        $email = trim(htmlspecialchars($updateData['email']));
        $role = trim(htmlspecialchars($updateData['role']));

        $query = "UPDATE users SET username = ?, email = ?, role = ? WHERE id = ?";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$username, $email, $role, $user_id]);
    }
    
    public function delete($user_id){                // Удалить пользователя по id
        $query = "DELETE FROM users WHERE id = ?";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$user_id]);
    }
}