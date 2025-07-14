<?php
session_start();

// Define base path
define('BASE_PATH', __DIR__);

// Autoload classes
spl_autoload_register(function ($class) {
    $file = BASE_PATH . '/app/' . str_replace('\\', '/', $class) . '.php';
    if (file_exists($file)) {
        require $file;
    }
});

// Load configuration
require_once 'app/config/config.php';

// Load core classes
require_once 'app/core/Controller.php';
require_once 'app/core/Database.php';
require_once 'app/core/Model.php';

// Route the request
$url = isset($_GET['url']) ? $_GET['url'] : '';
$url = rtrim($url, '/');
$url = filter_var($url, FILTER_SANITIZE_URL);
$url = explode('/', $url);

// Special routes mapping
$specialRoutes = [
    'login' => ['controller' => 'AuthController', 'action' => 'login'],
    'register' => ['controller' => 'AuthController', 'action' => 'register'],
    'logout' => ['controller' => 'AuthController', 'action' => 'logout']
];

// Set default controller and action
$controller = !empty($url[0]) ? strtolower($url[0]) : 'home';
$action = isset($url[1]) ? strtolower($url[1]) : 'index';
$params = array_slice($url, 2);

// Create controller instance
if (isset($specialRoutes[$controller])) {
    // Handle special routes
    $controllerName = $specialRoutes[$controller]['controller'];
    $action = $specialRoutes[$controller]['action'];
} else {
    // Handle normal routes
    $controllerName = ucfirst($controller) . 'Controller';
}

$controllerFile = BASE_PATH . '/app/controllers/' . $controllerName . '.php';

if (file_exists($controllerFile)) {
    require_once $controllerFile;
    $controller = new $controllerName();
    
    if (method_exists($controller, $action)) {
        call_user_func_array([$controller, $action], $params);
    } else {
        // Handle 404
        header("HTTP/1.0 404 Not Found");
        require BASE_PATH . '/app/views/error/404.php';
    }
} else {
    // Handle 404
    header("HTTP/1.0 404 Not Found");
    require BASE_PATH . '/app/views/error/404.php';
} 