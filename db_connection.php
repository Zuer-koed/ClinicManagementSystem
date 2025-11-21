<?php
// db_connection.php
// Simple PDO connection for XAMPP/MySQL

$host = "localhost";
$dbname = "nexuscare";    //  改成你實際的資料庫名稱
$username = "root";       // XAMPP 預設
$password = "";           // XAMPP 預設空字串

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $username,
        $password
    );
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    die("Database connection failed: " . $e->getMessage());
}
