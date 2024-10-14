<?php

require_once '../src/Models/Category.php';

class CategoryService {
    public function getAllCategories() {
        return (new Category())->getAll(); 
    }

    public function getCategoryById($id) {
        return (new Category())->findById($id); 
    }

}