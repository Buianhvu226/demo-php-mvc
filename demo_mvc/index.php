<?php
session_start();

// Load required files
require_once 'connection.php';
require_once 'routes.php';

// Application configuration
define('BASE_URL', '/demo_mvc');

// Autoload models
function loadModel($modelName)
{
    $file = 'models/' . $modelName . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
}

spl_autoload_register('loadModel');

// Get current URL path
$url = $_SERVER['REQUEST_URI'];

// Remove base URL
if (strpos($url, BASE_URL) === 0) {
    $url = substr($url, strlen(BASE_URL));
}

// Dispatch to router
$router->dispatch($url);
