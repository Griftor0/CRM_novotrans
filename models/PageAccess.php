<?php

namespace models;

use models\Page;

class PageAccess{

    private $userRole;

    public function __construct($userRole)
    {
        $this->userRole = $userRole;
    }     
    
    public function getCurrentSlugURL() {
        $url = "https://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

        $parseURL = parse_url($url);    // Разбираем URL, чтобы извлечь путь
        $slugWithoutBase = str_replace(APP_BASE_PATH, '', $parseURL['path']);   // Удаляем базовый путь (APP_BASE_PATH) из пути URL

        $slugSegments = explode('/', ltrim($slugWithoutBase, '/'));     // Разбиваем слаг на сегменты
        $firstTwoSlugSegments = array_slice($slugSegments, 0, 2);       // Берем первые два сегмента слага
        $slug = implode('/', $firstTwoSlugSegments);                    // Объединяем первые два сегмента обратно вместе

        return $slug;
    }

    public function checkAccess(){
        $slug = $this->getCurrentSlugURL();
        $pageModel = new Page();
        $page = $pageModel->getPageBySlug($slug);
        
        if(!$page) {
            return false; // Страница не найдена
        }

        $allowedRoles = explode(",", $page['roles']);
        if(isset($_SESSION['user_role']) || in_array($this->userRole, $allowedRoles)) {
            return true;
        }
        header("Location: /crm/authentication/showLoginForm");
        exit();
    }
    
    public function isCurrentRole($role){
        return $this->userRole == $role;
    }
}