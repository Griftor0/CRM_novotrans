<?php

namespace app;

use models\PageAccess;
use models\DatabaseInit;

class Router {

    private $roleAccessChecker;
    private $routes = [];

    public function __construct()
    {
        $databaseInit = new DatabaseInit();

        $userRole = $_SESSION['user_role'] ?? START_ROLE;
        $this->roleAccessChecker = new PageAccess($userRole);

        $this->routes = [
            '/^\/crm\/?$/' => ['controller' => 'HomeController'],
            '/^\/crm\/users(\/(?P<action>[a-zA-Z]+)(\/(?P<id>\d+))?)?$/' => ['controller' => 'UserController'],
            '/^\/crm\/authentication(\/(?P<action>[a-zA-Z]+)(\/(?P<id>\d+))?)?$/' => ['controller' => 'AuthController'],
            '/^\/crm\/roles(\/(?P<action>[a-zA-Z]+)(\/(?P<id>\d+))?)?$/' => ['controller' => 'RoleController'],
            '/^\/crm\/pages(\/(?P<action>[a-zA-Z]+)(\/(?P<id>\d+))?)?$/' => ['controller' => 'PageController'],
            '/^\/crm\/todo\/category(\/(?P<action>[a-zA-Z]+)(\/(?P<id>\d+))?)?$/' => ['controller' => 'todo\\CategoryController'],
            '/^\/crm\/todo\/tasks(\/(?P<action>[a-zA-Z]+)(\/(?P<id>\d+))?)?$/' => ['controller' => 'todo\\TaskController'],
            '/^\/crm\/todo\/tasks\/by-tag(\/(?P<id>\d+))?$/' => ['controller' => 'todo\\TaskController', 'action' => 'tasksByTag'],
            '/^\/crm\/todo\/tasks\/update-status(\/(?P<id>\d+))?$/' => ['controller' => 'todo\\TaskController', 'action' => 'updateTaskStatus'],
            '/^\/crm\/todo\/tasks\/task-information(\/(?P<id>\d+))?$/' => ['controller' => 'todo\\TaskController', 'action' => 'viewTask'],
            '/^\/crm\/todo\/clients(\/(?P<action>[a-zA-Z]+)(\/(?P<id>\d+))?)?$/' => ['controller' => 'todo\\ClientController'],
            '/^\/(?P<action>[a-zA-Z]+)?$/' => ['controller' => 'SiteController'],
        ];
    }

    public function run() {
        $uri = $_SERVER['REQUEST_URI'];
        $controller = null;
        $action = null;
        $params = null;
        
        foreach ($this->routes as $pattern => $route) {
            if (preg_match($pattern, $uri, $matches)) {
                $controller = "controllers\\" . $route['controller'];
                $action = $route['action'] ?? $matches['action'] ?? 'displayIndex';
                $params = array_filter($matches, 'is_string', ARRAY_FILTER_USE_KEY);
                
                break;
            }
        }
        
        if (!$controller) {
            http_response_code(404);
            include 'app/crm/errors/404.php';
            return;
        }
        
        $controllerInstance = new $controller();
        if (!method_exists($controllerInstance, $action)) {
            http_response_code(404);
            include 'app/crm/errors/404.php';
            return;
        }
        
        call_user_func_array([$controllerInstance, $action], [$params]);
        
        $this->roleAccessChecker->checkAccess();
    }
}