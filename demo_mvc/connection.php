<?php
class Database
{
    private $host;
    private $port;
    private $username;
    private $password;
    private $database;
    public $conn;

    public function __construct()
    {
        // Lấy thông tin kết nối từ biến môi trường hoặc dùng giá trị mặc định
        $this->host = getenv('DB_HOST') ?: 'aws-0-ap-southeast-1.pooler.supabase.com';
        $this->port = getenv('DB_PORT') ?: 6543;
        $this->username = getenv('DB_USER') ?: 'postgres.qaerzlrgzbhcufkqqabt';
        $this->password = getenv('DB_PASSWORD') ?: '123456Aa';
        $this->database = getenv('DB_NAME') ?: 'postgres';

        try {
            // Connect to PostgreSQL database on Supabase
            $this->conn = new PDO(
                "pgsql:host=$this->host;port=$this->port;dbname=$this->database",
                $this->username,
                $this->password
            );

            // Set error mode and fetch mode
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_ASSOC);

            // Set connection timeout
            $this->conn->setAttribute(PDO::ATTR_TIMEOUT, 30);

            // Set character set
            $this->conn->exec("SET NAMES 'utf8'");
        } catch (PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
            exit;
        }
    }

    public function getConnection()
    {
        return $this->conn;
    }
}

// Function to setup database tables if they don't exist
function setupDatabase()
{
    $db = new Database();
    $conn = $db->getConnection();

    try {
        // Create users table
        $conn->exec("
            CREATE TABLE IF NOT EXISTS users (
                id SERIAL PRIMARY KEY,
                username VARCHAR(50) NOT NULL UNIQUE,
                email VARCHAR(100) NOT NULL UNIQUE,
                password VARCHAR(255) NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            )
        ");

        // Create tasks table
        $conn->exec("
            CREATE TABLE IF NOT EXISTS tasks (
                id SERIAL PRIMARY KEY,
                user_id INTEGER NOT NULL,
                title VARCHAR(100) NOT NULL,
                description TEXT,
                status VARCHAR(10) CHECK (status IN ('TODO', 'DOING', 'REVIEW', 'DONE')) DEFAULT 'TODO',
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
            )
        ");

        // Create subtasks table
        $conn->exec("
            CREATE TABLE IF NOT EXISTS subtasks (
                id SERIAL PRIMARY KEY,
                task_id INTEGER NOT NULL,
                title VARCHAR(100) NOT NULL,
                completed BOOLEAN DEFAULT FALSE,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
                FOREIGN KEY (task_id) REFERENCES tasks(id) ON DELETE CASCADE
            )
        ");

        echo "Database tables created successfully";
    } catch (PDOException $e) {
        echo "Error creating tables: " . $e->getMessage();
    }
}

// Tạo file setup-database.php riêng thay vì tự động chạy setupDatabase() mỗi lần
// Nếu bạn muốn tạo bảng khi chạy lần đầu, hãy bỏ comment dòng dưới
// setupDatabase();