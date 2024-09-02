<?php

namespace models\todo;

use PDO;
use PDOException;
use models\Database;

class Category {
    private $dbConnection;
    private $userID;

    public function __construct() {
        $this->dbConnection = Database::getInstance()->getConnection();

        $this->userID = $_SESSION['user_id'] ?? null;
    }

    public function getAllCategories() {
        $query = "SELECT * FROM todo_category WHERE user_id = ?"; // У каждого пользователя свои категории

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$this->userID]);

        $categories = [];
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $categories[] = $row;
        }

        return $categories;
    }

    public function getAllVisibleCategories() { // Для отображения в форме с is_visible = 1
        $query = "SELECT * FROM todo_category WHERE user_id = ? ANd is_visible = 1";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$this->userID]);

        $categories = [];
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $categories[] = $row;
        }

        return $categories;
    }

    public function getCategoryById($category_id){
        $query = "SELECT * FROM todo_category WHERE id = ?";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$category_id]);

        $category = $statement->fetch(PDO::FETCH_ASSOC); 

        return $category ? $category : false;
    }

    public function create($title, $description, $user_id){
        $query = "INSERT INTO todo_category (title, description, user_id) VALUE (?, ?, ?)";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$title, $description, $user_id]);
    }

    public function update($category_id, $title, $description, $is_visible){
        $query = "UPDATE todo_category SET title = ?, description = ?, is_visible = ? WHERE id = ?";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$title, $description, $is_visible, $category_id]);
    }

    public function delete($category_id){
        $query = "DELETE FROM todo_category WHERE id = ?";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$category_id]);
    }
    
}