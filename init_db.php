<?php
require_once 'app/config/config.php';

try {
    $dsn = 'mysql:host=' . DB_HOST;
    $pdo = new PDO($dsn, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    $sql = file_get_contents('database.sql');
    $pdo->exec($sql);
    echo "Database created successfully!";
} catch (PDOException $e) {
    echo "Error: " . $e->getMessage();
}
