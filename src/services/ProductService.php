<?php

require_once '../src/Models/Product.php';

class ProductService {
    public function getAllProducts($filters = []) {
        return (new Product())->getAll($filters);
    }

    public function getProductBySKU($sku) {
        return (new Product())->findBySKU($sku);
    }

    public function createProduct($data) {
        // Check for required fields
        if (!$this->validateProductData($data)) {
            return null; // Return null for invalid input
        }
        $product = (new Product())->create($data);
        return $product; // Return the created product
    }

    public function updateProduct($sku, $data) {
        // Check if the product exists first
        $existingProduct = (new Product())->findBySKU($sku);
        if (!$existingProduct) {
            return null; // Return null if the product does not exist
        }
        
        // Validate the input data
        if (!$this->validateProductData($data, false)) {
            return null; // Return null for invalid data
        }

        $updatedProduct = (new Product())->update($sku, $data);
        return $updatedProduct; // Return the updated product
    }

    public function deleteProduct($sku) {
        $deleted = (new Product())->delete($sku);
        return $deleted; // Return true if deleted successfully, false otherwise
    }

    private function validateProductData($data, $isNew = true) {
        // Check if required fields are present
        if (empty($data['sku']) || empty($data['name']) || empty($data['price']) || empty($data['type']) || empty($data['category_id'])) {
            return false; // Invalid input
        }
        
        return true; // Valid input
    }
}