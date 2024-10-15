<?php

// CORS headers
header("Access-Control-Allow-Origin: *");  // Allows requests from any domain
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");  // Specifies allowed methods
header("Access-Control-Allow-Headers: Content-Type, Authorization");  // Specifies allowed headers

// Handle preflight OPTIONS request (if needed)
if ($_SERVER['REQUEST_METHOD'] == 'OPTIONS') {
    http_response_code(200);  // Return OK for preflight
    exit;
}

// Include the database class
require_once '../src/Config/Database.php';
require_once '../src/Controllers/ProductController.php';
require_once '../src/Controllers/CategoryController.php'; 



require_once '../vendor/autoload.php'; 

use FastRoute\RouteCollector;
use function FastRoute\simpleDispatcher;

// Create a FastRoute dispatcher
$dispatcher = simpleDispatcher(function (RouteCollector $r) {
    // Root route
    $r->addRoute('GET', '/', function() {
        echo 'Welcome to the E-Commerce API!';
    });

    // Product routes
    $r->addRoute('GET', '/products', ['ProductController', 'getAllProducts']);
    $r->addRoute('GET', '/products/{sku}', ['ProductController', 'getProductBySKU']);
    $r->addRoute('POST', '/products', ['ProductController', 'createProduct']);
    $r->addRoute('PUT', '/products/{sku}', ['ProductController', 'updateProduct']);
    $r->addRoute('DELETE', '/products/{sku}', ['ProductController', 'deleteProduct']);

    // Category routes
    $r->addRoute('GET', '/categories', ['CategoryController', 'getAllCategories']);
    $r->addRoute('GET', '/categories/{id}', ['CategoryController', 'getCategoryById']);
});

// Fetch method and URI from the request
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);


// Remove the /E-Commerce-Product-Catalog-API/public/index.php part from the URI
$basePath = '/E-Commerce-Product-Catalog-API/backend/public';
if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}

// Dispatch the request
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        http_response_code(404);
        echo '404 Not Found';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        http_response_code(405);
        echo '405 Method Not Allowed';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];
        
        // Check if the handler is a Closure and call it directly
        if (is_callable($handler)) {
            $handler($vars);
        } else {
            // Otherwise, treat it as a controller-method pair
            [$controller, $method] = $handler;
            (new $controller())->$method($vars);
        }
        break;
}