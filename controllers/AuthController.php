<?php
namespace controllers;

use models\User;

class AuthController {

    public function showRegisterForm(){
        include 'app/crm/authentication/register.php';        // Вызывает страницу всех пользователей
    }
    
    public function showLoginForm(){      
        include 'app/crm/authentication/login.php';
    }

    public function registerUser(){
        if(!$this->validateInput(['username', 'email', 'password', 'confirm_password'])){
            http_response_code(404);
            include 'app/crm/errors/404.php';
            return;
        }

        $username = trim(htmlspecialchars($_POST['username']));
        $email = trim(filter_var($_POST['email'], FILTER_SANITIZE_EMAIL));
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);
        
        if ($password !== $confirm_password){       // Проверка повторного пароля
            http_response_code(404);
            include 'app/crm/errors/404.php';
            return;
        }

        $User = new User();
        $User->create($username, $email, $password, START_ROLE, date('Y-m-d H:i:s'));

        header('Location: /crm/authentication/showLoginForm');
    }

    public function authenticateUser(){
        if(!$this->validateInput(['email', 'password'])){
            http_response_code(404);
            include 'app/crm/errors/404.php';
            return;
        }

        $email = $_POST['email'];
        $password = $_POST['password'];
        $remember = isset($_POST['remember']) ? $_POST['remember'] : '';

        $user = new User();
        $user = $user->getUserByEmail($email);
        
        if($user && password_verify($password, $user['password'])) {
            if (session_status() == PHP_SESSION_NONE) {
                session_start();
            }
                        
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['user_role'] = $user['role'];
            $_SESSION['user_email'] = $user['email'];

            if($remember == 'on'){
                setcookie('user_email', $email, time() + (7 * 24 * 60 * 60), '/');
                setcookie('user_password', $password, time() + (7 * 24 * 60 * 60), '/');
            }

            header('Location: /crm');
        }
        else {
            http_response_code(404);
            include 'app/crm/errors/404.php';
            return;
        }
    }

    public function logout(){
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
        session_destroy();
        header('Location: /crm');
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