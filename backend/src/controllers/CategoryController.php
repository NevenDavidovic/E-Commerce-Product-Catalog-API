<?php

require_once '../src/Models/Category.php';
require_once '../src/Services/CategoryService.php'; 

class CategoryController {
    public function getAllCategories() {
        $categories = (new CategoryService())->getAllCategories(); 
        echo json_encode($categories);
    }

    public function getCategoryById($vars) {
        $id = $vars['id']; // Get the ID from the route variables
        $category = (new CategoryService())->getCategoryById($id); 
        
        if ($category) {
            echo json_encode($category);
        } else {
            http_response_code(404);
            echo json_encode(['error' => 'Category not found']);
        }
    }
}
