<?php
// db_connection.php
class Database {
    private $host = "localhost";
    private $db_name = "nexuscare";
    private $username = "root";  // Default XAMPP username
    private $password = "";      // Default XAMPP password (empty)
    public $conn;
    
    public function getConnection() {
        $this->conn = null;
        
        try {
            $this->conn = new PDO(
                "mysql:host=" . $this->host . ";dbname=" . $this->db_name . ";charset=utf8mb4",
                $this->username,
                $this->password
            );
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);
        } catch(PDOException $exception) {
            error_log("Connection error: " . $exception->getMessage());
            // Don't display detailed errors to users in production
            die("Database connection failed. Please try again later.");
        }
        
        return $this->conn;
    }
}

// Create database connection
$database = new Database();
$pdo = $database->getConnection();
?>
