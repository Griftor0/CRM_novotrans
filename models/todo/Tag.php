<?php

namespace models\todo;

use PDO;
use PDOException;
use models\Database;

class Tag {
    private $dbConnection;

    public function __construct() {
        $this->dbConnection = Database::getInstance()->getConnection();
    }

    public function getTagsByTaskId($task_id){
        $query = "SELECT tags.* FROM tags 
        JOIN task_tags ON tags.id = task_tags.tag_id
        WHERE task_tags.task_id = ?";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$task_id]);

        $tags = $statement->fetchAll(PDO::FETCH_ASSOC); 

        return $tags;
    }

    public function getTagByNameAndUserId($tag_name, $user_id){
        $query = "SELECT * FROM tags WHERE name = ? and user_id = ?";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$tag_name, $user_id]);

        $tag = $statement->fetch(PDO::FETCH_ASSOC);

        return $tag;
    }

    public function getTagNameById($tag_id){
        $query = "SELECT name FROM tags WHERE id = ?";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$tag_id]);

        $tag = $statement->fetch(\PDO::FETCH_ASSOC);

        return $tag ? $tag['name'] : '';
    }

    public function addTag($tag_name, $user_id){
        $query = "INSERT INTO tags (name, user_id) VALUE (?, ?)";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$tag_name, $user_id]);
        
        return $this->dbConnection->lastInsertId();
    }

    public function bindTaskTag($task_id, $tag_id){
        $query = "INSERT INTO task_tags (task_id, tag_id) VALUE (?, ?)";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$task_id, $tag_id]);
    }

    public function removeAllTaskTags($task_tag_id){
        $query = "DELETE FROM task_tags WHERE task_id = ?";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$task_tag_id]);
    }

    public function removeUnusedTag($tag_id){
        $query = "SELECT COUNT(*) FROM task_tags WHERE tag_id = ?";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$tag_id]);

        $count = $statement->fetch(PDO::FETCH_ASSOC)['COUNT(*)'];

        if($count == 0){
            $query = "DELETE FROM tags WHERE id = ?";

            $statement = $this->dbConnection->prepare($query);
            $statement->execute([$tag_id]);
        }
    }
}