<?php

namespace models;

use PDO;
use models\Database;

class Role {
    private $dbConnection;

    public function __construct() {
        $this->dbConnection = Database::getInstance()->getConnection();
    }

    public function getAllRoles() {
        $query = "SELECT * FROM roles";

        $statement = $this->dbConnection->query($query);

        $roles = [];
        while($row = $statement->fetch(PDO::FETCH_ASSOC)){
            $roles[] = $row;
        }

        return $roles;
    }

    public function getRoleById($role_id){
        $query = "SELECT * FROM roles WHERE id = ?";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$role_id]);

        $role = $statement->fetch(PDO::FETCH_ASSOC); 

        return $role ? $role : false;
    }

    public function create($role_name, $role_description){
        $query = "INSERT INTO roles (role_name, role_description) VALUE (?, ?)";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$role_name, $role_description]);
    }

    public function update($role_id, $role_name, $role_description){
        $query = "UPDATE roles SET role_name = ?, role_description = ? WHERE id = ?";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$role_name, $role_description, $role_id]);
    }

    public function delete($role_id){
        $query = "DELETE FROM roles WHERE id = ?";

        $statement = $this->dbConnection->prepare($query);
        $statement->execute([$role_id]);
    }
    
}