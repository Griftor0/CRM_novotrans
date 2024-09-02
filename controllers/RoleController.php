<?php

namespace controllers;

use models\Role;

class RoleController {
    private $returnPath = '/crm/roles';

    public function displayIndex(){
        $role = new Role();
        $roles = $role->getAllRoles();

        include 'app/crm/roles/index.php';
    }

    public function showCreateForm(){               // Вызывает шаблон страницы создания пользователя
        include 'app/crm/roles/create.php';
    }
    
    public function showEditForm($params){                 // Вызывает шаблон страницы редактирования пользователя
        $role = new Role();                    
        $role = $role->getRoleById($params['id']);      // Ищет выделенного пользователя
        
        if(!$role){
            http_response_code(404);
            include 'app/crm/errors/404.php';
            return;
        }

        include 'app/crm/roles/edit.php';
    }

    public function createRole(){
        if(!$this->validateInput(['role_name', 'role_description'])){
            http_response_code(404);
            include 'app/crm/errors/404.php';
            return;
        }

        $role_name = trim(htmlspecialchars($_POST['role_name']));
        $role_description = trim(htmlspecialchars($_POST['role_description']));

        $role = new Role();
        $role->create($role_name, $role_description);

        header("Location: $this->returnPath");
    }
    
    public function updateRole(){
        if(!$this->validateInput(['id', 'role_name', 'role_description'])){
            http_response_code(404);
            include 'app/crm/errors/404.php';
            return;
        }

        $role_name = trim(htmlspecialchars($_POST['role_name']));
        $role_description = trim(htmlspecialchars($_POST['role_description']));
        
        $role = new Role();
        $role->update($_POST['id'], $role_name, $role_description);
        
        header("Location: $this->returnPath");
    }

    public function deleteRole($params){
        $role = new Role();
        $role->delete($params['id']);
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