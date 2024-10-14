<?php

require_once '../src/Config/Database.php';

class Product {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll($filters = []) {
        $query = "SELECT * FROM products WHERE 1=1";
        
        // Add filters to the query
        if (!empty($filters['name'])) {
            $query .= " AND name LIKE :name";
        }
        if (!empty($filters['category'])) {
            $query .= " AND category_id = :category_id";
        }
        if (!empty($filters['type'])) {
            $query .= " AND type = :type";
        }
        if (!empty($filters['price_min'])) {
            $query .= " AND price >= :price_min";
        }
        if (!empty($filters['price_max'])) {
            $query .= " AND price <= :price_max";
        }

        $stmt = $this->db->prepare($query);

        // Bind parameters
        if (!empty($filters['name'])) {
            $stmt->bindValue(':name', '%' . $filters['name'] . '%');
        }
        if (!empty($filters['category'])) {
            $stmt->bindValue(':category_id', $filters['category']);
        }
        if (!empty($filters['type'])) {
            $stmt->bindValue(':type', $filters['type']);
        }
        if (!empty($filters['price_min'])) {
            $stmt->bindValue(':price_min', $filters['price_min']);
        }
        if (!empty($filters['price_max'])) {
            $stmt->bindValue(':price_max', $filters['price_max']);
        }

        $stmt->execute();
        return $stmt->fetchAll();
    }

    public function findBySKU($sku) {
        $query = "SELECT * FROM products WHERE sku = :sku";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':sku', $sku);
        $stmt->execute();
        return $stmt->fetch();
    }

    public function create($data) {
        // Handle insert logic, validate fields, etc.
    }

    public function update($sku, $data) {
        // Handle update logic, validate fields, etc.
    }

    public function delete($sku) {
        $query = "DELETE FROM products WHERE sku = :sku";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':sku', $sku);
        return $stmt->execute();
    }
}