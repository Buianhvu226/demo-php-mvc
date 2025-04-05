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

        // Debug route matching
        // echo "Looking for route: " . htmlspecialchars($url) . "<br>";
        // echo "Available routes: " . implode(", ", array_keys($this->routes)) . "<br>";

        if (array_key_exists($url, $this->routes)) {
            $controllerName = $this->routes[$url]['controller'];
            $action = $this->routes[$url]['action'];

            // Check if controller file exists
            $controllerFile = "controllers/{$controllerName}.php";
            if (!file_exists($controllerFile)) {
                echo "Controller file not found: {$controllerFile}";
                http_response_code(500);
                return;
            }

            require_once $controllerFile;

            // Check if controller class exists
            if (!class_exists($controllerName)) {
                echo "Controller class not found: {$controllerName}";
                http_response_code(500);
                return;
            }

            $controller = new $controllerName();
            
            // Check if action method exists
            if (!method_exists($controller, $action)) {
                echo "Action method not found: {$action} in {$controllerName}";
                http_response_code(500);
                return;
            }
            
            $controller->$action();
        } else {
            // Handle 404
            http_response_code(404);
            
            // Set page title for 404 page
            $pageTitle = '404 - Page Not Found';
            $contentView = 'views/404.php';
            include 'views/application.php';
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
$router->addRoute('/subtasks/edit', 'SubtaskController', 'edit');
// Thêm route cho toggle-complete
$router->addRoute('/subtasks/toggle-complete', 'SubtaskController', 'toggleComplete');
