<?php

require_once '../src/Config/Database.php';

class Product {
    private $db;

    public function __construct() {
        $this->db = Database::getConnection();
    }

    public function getAll($filters = []) {
        $query = "SELECT * FROM products WHERE 1=1";
        
        
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
        $query = "SELECT * FROM products WHERE SKU = :sku";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':sku', $sku);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC); 
    }
    

    public function create($data) {
        // Validate the input data
        if (empty($data['name']) || empty($data['price']) || empty($data['sku'])) {
            throw new Exception('Invalid input: name, price, and SKU are required.');
        }
    
        // Prepare the SQL statement
        $stmt = $this->db->prepare("INSERT INTO products (name, price, sku, category_id, type, description, image_url) VALUES (:name, :price, :sku, :category_id, :type, :description, :image_url)");
        
        // Bind parameters
        $stmt->bindParam(':name', $data['name']);
        $stmt->bindParam(':price', $data['price']);
        $stmt->bindParam(':sku', $data['sku']);
        $stmt->bindParam(':category_id', $data['category_id']);
        $stmt->bindParam(':type', $data['type']);
        $stmt->bindParam(':description', $data['description']); // Bind the description
        $stmt->bindParam(':image_url', $data['image_url']); // Bind the image URL
        
        // Execute the statement
        if ($stmt->execute()) {
            return $this->db->lastInsertId(); // Return the ID of the newly created product
        } else {
            throw new Exception('Failed to create product.');
        }
    }
    

    public function update($sku, $data) {
        // Validate the input data
        if (empty($data['name']) && empty($data['price']) && empty($data['category_id']) && empty($data['type']) && empty($data['description']) && empty($data['image_url'])) {
            throw new Exception('Invalid input: at least one field must be provided for update.');
        }
    
        // Prepare the SQL statement
        $query = "UPDATE products SET ";
        $params = [];
    
        // Dynamically build the query based on which fields are provided
        if (!empty($data['name'])) {
            $query .= "name = :name, ";
            $params[':name'] = $data['name'];
        }
        if (!empty($data['price'])) {
            $query .= "price = :price, ";
            $params[':price'] = $data['price'];
        }
        if (!empty($data['category_id'])) {
            $query .= "category_id = :category_id, ";
            $params[':category_id'] = $data['category_id'];
        }
        if (!empty($data['type'])) {
            $query .= "type = :type, ";
            $params[':type'] = $data['type'];
        }
        if (!empty($data['description'])) {
            $query .= "description = :description, ";
            $params[':description'] = $data['description']; // Bind description
        }
        if (!empty($data['image_url'])) {
            $query .= "image_url = :image_url, ";
            $params[':image_url'] = $data['image_url']; // Bind image URL
        }
    
        // Remove the trailing comma and add the WHERE clause
        $query = rtrim($query, ', ') . " WHERE SKU = :sku";
        $params[':sku'] = $sku;
    
        // Prepare the statement
        $stmt = $this->db->prepare($query);
        
        // Bind the parameters
        foreach ($params as $key => &$value) {
            $stmt->bindParam($key, $value);
        }
        
        // Execute the statement
        if ($stmt->execute()) {
            return $stmt->rowCount(); // Return the number of affected rows
        } else {
            throw new Exception('Failed to update product.');
        }
    }
    

    public function delete($sku) {
        $query = "DELETE FROM products WHERE SKU = :sku";
        $stmt = $this->db->prepare($query);
        $stmt->bindParam(':sku', $sku);
        return $stmt->execute();
    }
}