<?php
namespace controllers;

use models\Role;
use models\Page;

class PageController {
    private $returnPath = '/crm/pages';

    public function displayIndex(){
        $page = new Page();
        $pages = $page->getAllPages();

        include 'app/crm/pages/index.php';
    }

    public function showCreateForm(){
        $role = new Role();
        $roles = $role->getAllRoles(); // Для отображения ролей

        include 'app/crm/pages/create.php';
    }
    
    public function showEditForm($params){
        $page = new Page();
        $page = $page->getPageById($params['id']); // Для формы нужно найти страницу

        $role = new Role();   
        $roles = $role->getAllRoles(); // Для отображения ролей

        if(!$page){
            http_response_code(404);
            include 'app/crm/errors/404.php';
            return;
        }

        include 'app/crm/pages/edit.php';
    }
    
    public function createPage(){                   // Обрабатывает введенные данные из /view/roles/create
        if(!$this->validateInput(['title', 'slug'])){
            http_response_code(404);
            include 'app/crm/errors/404.php';
            return;
        }

        $title = trim(htmlspecialchars($_POST['title']));
        $slug = trim(htmlspecialchars($_POST['slug']));
        $roles = filter_var_array($_POST['roles'], FILTER_SANITIZE_NUMBER_INT);
        
        $page = new Page();
        $page->create($title, $slug, $roles);

        header("Location: $this->returnPath");
    }
    
    public function updatePage(){
        if(!$this->validateInput(['title', 'slug'])){
            http_response_code(404);
            include 'app/crm/errors/404.php';
            return;
        }
        $title = trim(htmlspecialchars($_POST['title']));
        $slug = trim(htmlspecialchars($_POST['slug']));
        $roles = filter_var_array($_POST['roles'], FILTER_SANITIZE_NUMBER_INT);
        $page = new Page();
        $page->update($_POST['id'], $title, $slug, $roles);
    
        header("Location: $this->returnPath");
    }

    public function deletePage($params){
        $page = new Page();
        $page->delete($params['id']);

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