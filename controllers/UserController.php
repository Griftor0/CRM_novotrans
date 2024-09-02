<?php

namespace controllers;

use models\Role;
use models\User;

class UserController {
    private $returnPath = '/crm/users';

    public function displayIndex(){
        $user = new User();
        $users = $user->getAllUsers();

        include 'app/crm/users/index.php';
    }

    public function showCreateForm(){
        include 'app/crm/users/create.php';
    }
    
    public function showEditForm($params){
        $user = new User();
        $user = $user->getUserById($params['id']);
        
        $role = new Role();
        $roles = $role->getAllRoles();

        if(!$user){
            http_response_code(404);
            include 'app/crm/errors/404.php';
            return;
        }

        include 'app/crm/users/edit.php';
    }

    public function createUser(){
        if(!$this->validateInput(['username', 'email', 'password'])){
            http_response_code(404);
            include 'app/crm/errors/404.php';
            return;
        }

        $username = trim(htmlspecialchars($_POST['username']));
        $email = trim(htmlspecialchars($_POST['email']));
        $password = trim(htmlspecialchars($_POST['password']));

        $user = new User();
        $user->create($username, $email, $password, START_ROLE, date('Y-m-d H:i:s'));
        
        header("Location: $this->returnPath");
    }
    
    public function updateUser($params){
        if(!$this->validateInput(['username', 'email', 'role'])){
            http_response_code(404);
            include 'app/crm/errors/404.php';
            return;
        }

        $user = new User();
        $user->update($params['id'], $_POST);

        header("Location: $this->returnPath");
    }

    public function deleteUser($params){
        $user = new User();
        $user->delete($params['id']);

        header("Location: $this->returnPath");
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