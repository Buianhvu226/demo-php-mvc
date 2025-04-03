<?php
class Router
{
    private $routes = [];

    public function addRoute($url, $controller, $action)
    {
        $this->routes[$url] = ['controller' => $controller, 'action' => $action];
    }

    public function dispatch($url)
    {
        // Remove query string
        if (($pos = strpos($url, '?')) !== false) {
            $url = substr($url, 0, $pos);
        }

        // Remove trailing slash
        $url = rtrim($url, '/');

        // Set default route if empty
        if (empty($url)) {
            $url = '/';
        }

        if (array_key_exists($url, $this->routes)) {
            $controllerName = $this->routes[$url]['controller'];
            $action = $this->routes[$url]['action'];

            require_once "controllers/{$controllerName}.php";

            $controller = new $controllerName();
            $controller->$action();
        } else {
            // Handle 404
            http_response_code(404);
            require_once 'views/404.php';
        }
    }
}

$router = new Router();

// Define routes
$router->addRoute('/', 'HomeController', 'index');
$router->addRoute('/login', 'AuthController', 'login');
$router->addRoute('/register', 'AuthController', 'register');
$router->addRoute('/logout', 'AuthController', 'logout');
$router->addRoute('/tasks', 'TaskController', 'index');
$router->addRoute('/tasks/create', 'TaskController', 'create');
$router->addRoute('/tasks/store', 'TaskController', 'store');
$router->addRoute('/tasks/edit', 'TaskController', 'edit');
$router->addRoute('/tasks/update', 'TaskController', 'update');
$router->addRoute('/tasks/delete', 'TaskController', 'delete');
$router->addRoute('/tasks/change-status', 'TaskController', 'changeStatus');
$router->addRoute('/subtasks/create', 'SubtaskController', 'create');
$router->addRoute('/subtasks/store', 'SubtaskController', 'store');
$router->addRoute('/subtasks/update', 'SubtaskController', 'update');
$router->addRoute('/subtasks/delete', 'SubtaskController', 'delete');
