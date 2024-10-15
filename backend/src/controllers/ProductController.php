<?php

require_once '../src/Models/Product.php';
require_once '../src/Services/ProductService.php';

class ProductController {
    public function getAllProducts($vars) {
        $filters = [
            'name' => $_GET['name'] ?? null,
            'category' => $_GET['category'] ?? null,
            'type' => $_GET['type'] ?? null,
            'price_min' => $_GET['price_min'] ?? null,
            'price_max' => $_GET['price_max'] ?? null,
        ];
        header('Content-Type: application/json');
        $products = (new ProductService())->getAllProducts($filters);
        echo json_encode($products);
    }

    public function getProductBySKU($vars) {
        $sku = $vars['sku'];
        $product = (new ProductService())->getProductBySKU($sku);
        if ($product) {
            echo json_encode($product);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Product not found']);
        }
    }

    public function createProduct() {
        $input = json_decode(file_get_contents('php://input'), true);
        $result = (new ProductService())->createProduct($input);
        
        if ($result !== null) {
            http_response_code(201);
            echo json_encode($result);
        } else {
            http_response_code(400);
            echo json_encode(['error' => 'Invalid input']);
        }
    }

    public function updateProduct($vars) {
        $sku = $vars['sku'];
        $input = json_decode(file_get_contents('php://input'), true);
        
        // Debugging logs
        error_log("SKU received: " . $sku);
        error_log("Input data: " . json_encode($input));
        
        $result = (new ProductService())->updateProduct($sku, $input);
        
        if ($result !== null) {
            echo json_encode($result);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Product not found or invalid data']);
        }
    }
    

    public function deleteProduct($vars) {
        $sku = $vars['sku'];
        $result = (new ProductService())->deleteProduct($sku);
        
        if ($result) {
            http_response_code(204); // No Content
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Product not found']);
        }
    }
}