<?php

namespace controllers\todo;

use models\todo\Category;

class CategoryController {
    private $returnPath = '/crm/todo/category';

    public function displayIndex(){
        $category = new Category();
        $categories = $category->getAllCategories();

        include 'app/crm/todo/category/index.php';
    }

    public function showCreateForm(){
        include 'app/crm/todo/category/create.php';
    }
    
    public function showEditForm($params){
        $category = new Category();
        $selectedCategory = $category->getCategoryById($params['id']);

        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;

        if(!$selectedCategory || $selectedCategory['user_id'] != $user_id){
            http_response_code(404);
            include 'app/crm/errors/404.php';
            return;
        }

        include 'app/crm/todo/category/edit.php';
    }

    public function createCategory(){
        if(!$this->validateInput(['title', 'description'])){
            echo "Fields are not filled in";
            return;
        }

        $user_id = isset($_SESSION['user_id']) ? $_SESSION['user_id'] : 0;
        $category = new Category();
        $category->create(trim(htmlspecialchars($_POST['title'])), trim(htmlspecialchars($_POST['description'])), $user_id);
        header("Location: $this->returnPath");
    }
    
    public function updateCategory(){
        if(!$this->validateInput(['id', 'title', 'description'])){
            echo "Fields are not filled in";
            return;
        }
        
        $is_visible = isset($_POST['is_visible']) ? $_POST['is_visible'] : 0;
        $category = new Category();
        $category->update($_POST['id'], trim(htmlspecialchars($_POST['title'])), trim(htmlspecialchars($_POST['description'])), $is_visible);
        header("Location: $this->returnPath");
    }

    public function deleteCategory($params){
        $category = new Category();
        $category->delete($params['id']);
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