<?php

require_once '../src/Models/Category.php'; // Adjust the path as necessary
require_once '../src/Services/CategoryService.php'; // Assuming you have a CategoryService

class CategoryController {
    public function getAllCategories() {
        $categories = (new CategoryService())->getAllCategories(); // Assuming you have a getAllCategories method in CategoryService
        echo json_encode($categories);
    }
}