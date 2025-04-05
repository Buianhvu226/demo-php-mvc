<?php
session_start();

// Enable error reporting for debugging
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Load required files
require_once 'connection.php';
require_once 'routes.php';

// Application configuration
// Sử dụng http://localhost:8080/demo_mvc thay vì /demo_mvc
define('BASE_URL', 'http://localhost:8080/demo_mvc');

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

// Debug - Uncomment dòng này nếu muốn debug
// echo "Original URL: " . htmlspecialchars($url) . "<br>";

// Remove base path from URL
$basePath = '/demo_mvc';
if (strpos($url, $basePath) === 0) {
    $url = substr($url, strlen($basePath));
}

// Ensure URL starts with a slash
if (empty($url) || $url[0] !== '/') {
    $url = '/' . $url;
}

// Debug - Uncomment dòng này nếu muốn debug
// echo "Processed URL: " . htmlspecialchars($url) . "<br>";

// Dispatch to router
$router->dispatch($url);
