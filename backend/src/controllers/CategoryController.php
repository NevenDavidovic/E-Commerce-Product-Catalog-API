<?php

require_once '../src/Models/Category.php'; // Adjust the path as necessary
require_once '../src/Services/CategoryService.php'; // Assuming you have a CategoryService

class CategoryController {
    public function getAllCategories() {
        $categories = (new CategoryService())->getAllCategories(); // Assuming you have a getAllCategories method in CategoryService
        echo json_encode($categories);
    }

    public function getCategoryById($vars) {
        $id = $vars['id']; // Get the ID from the route variables
        $category = (new CategoryService())->getCategoryById($id); // Assuming you have a getCategoryById method in CategoryService
        
        if ($category) {
            echo json_encode($category);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Category not found']);
        }
    }
}