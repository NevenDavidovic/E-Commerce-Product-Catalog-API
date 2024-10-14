<?php
// Include the database class
require_once '../src/Config/Database.php';
require_once '../src/Controllers/ProductController.php';
require_once '../src/Controllers/CategoryController.php'; 




// Test the database connection
Database::getConnection();

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
    $r->addRoute('GET', '/products/{SKU}', ['ProductController', 'getProductBySKU']);
    $r->addRoute('POST', '/products', ['ProductController', 'createProduct']);
    $r->addRoute('PUT', '/products/{SKU}', ['ProductController', 'updateProduct']);
    $r->addRoute('DELETE', '/products/{SKU}', ['ProductController', 'deleteProduct']);

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

// Debugging: Log the original URI
echo "Original URI: " . $uri . "<br>";

// Remove the /E-Commerce-Product-Catalog-API/public/index.php part from the URI
$basePath = '/E-Commerce-Product-Catalog-API/public';
if (strpos($uri, $basePath) === 0) {
    $uri = substr($uri, strlen($basePath));
}

// Debugging: Log the stripped URI
echo "Stripped URI: " . $uri . "<br>";

// Dispatch the request
$routeInfo = $dispatcher->dispatch($httpMethod, $uri);

// Debugging: Log route info result
var_dump($routeInfo);

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