<?php

class Category {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection(); 
    }

    public function getAll() {
        $query = "SELECT id, name FROM categories"; 
        $stmt = $this->db->prepare($query);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC); 
    }

    public function findById($id) {
        $query = "SELECT id, name FROM categories WHERE id = :id";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }

    
}