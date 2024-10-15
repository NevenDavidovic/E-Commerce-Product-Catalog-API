<?php

class Database {
    private static $connection = null;

    // Method to get a database connection
    public static function getConnection() {
        if (self::$connection === null) {
            try {
                $db_user = 'root'; // Replace with your actual DB user
                $db_password = ''; // Replace with your actual DB password
                $db_name = 'product_catalog'; // Replace with your actual DB name

                // Data Source Name (DSN)
                $dsn = 'mysql:host=127.0.0.1;dbname=' . $db_name . ';charset=utf8';

                // Create a new PDO instance
                self::$connection = new PDO($dsn, $db_user, $db_password);

                // Set PDO attributes to handle errors and fetch data properly
                self::$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
                self::$connection->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

                
            } catch (PDOException $e) {
                die("Database connection failed: " . $e->getMessage());
            }
        }
        return self::$connection;
    }
}