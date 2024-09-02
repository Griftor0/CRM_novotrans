<?php

namespace models;

use PDO;
use models\Database;

class Page {
    private $dbConnection;

    public function __construct() {
        $this->dbConnection = Database::getInstance()->getConnection();
    }

    public function getAllPages() {
        $query = "SELECT * FROM pages";

        $statement = $this->dbConnection->query($query);

        $pages = [];
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $pages[] = $row;
        }

        return $pages;
    }

    public function getPageById($page_id){
        $query = "SELECT * FROM pages WHERE id = ?";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$page_id]);
        
        $page = $statement->fetch(PDO::FETCH_ASSOC); 

        return $page ? $page : false;
    }

    public function getPageBySlug($slug){
        $query = "SELECT * FROM pages WHERE slug = ?";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$slug]);
        
        $page = $statement->fetch(PDO::FETCH_ASSOC); 

        return $page ? $page : false;
    }

    public function create($title, $slug, $roles){
        $query = "INSERT INTO pages (title, slug, roles) VALUE (?, ?, ?)";

        $roles = implode(',', $roles);
        
        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$title, $slug, $roles]);
    }

    public function update($page_id, $title, $slug, $roles){
        $query = "UPDATE pages SET title = ?, slug = ?, roles = ? WHERE id = ?";

        $roles = implode(',', $roles);
        
        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$title, $slug, $roles, $page_id]);
    }

    public function delete($page_id){
        $query = "DELETE FROM pages WHERE id = ?";
        
        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$page_id]);
    }
}