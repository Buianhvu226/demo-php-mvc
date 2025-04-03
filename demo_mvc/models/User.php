<?php
class User
{
    private $db;

    public function __construct()
    {
        $database = new Database();
        $this->db = $database->getConnection();
    }

    public function register($username, $email, $password)
    {
        try {
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            $stmt = $this->db->prepare("
                INSERT INTO users (username, email, password) 
                VALUES (:username, :email, :password)
            ");

            $stmt->bindParam(':username', $username);
            $stmt->bindParam(':email', $email);
            $stmt->bindParam(':password', $hashedPassword);

            return $stmt->execute();
        } catch (PDOException $e) {
            return false;
        }
    }

    public function login($username, $password)
    {
        $stmt = $this->db->prepare("
            SELECT id, username, password 
            FROM users 
            WHERE username = :username
        ");

        $stmt->bindParam(':username', $username);
        $stmt->execute();

        $user = $stmt->fetch();

        if ($user && password_verify($password, $user['password'])) {
            return $user;
        }

        return false;
    }

    public function findByEmail($email)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM users WHERE email = :email
        ");

        $stmt->bindParam(':email', $email);
        $stmt->execute();

        return $stmt->fetch();
    }

    public function findByUsername($username)
    {
        $stmt = $this->db->prepare("
            SELECT * FROM users WHERE username = :username
        ");

        $stmt->bindParam(':username', $username);
        $stmt->execute();

        return $stmt->fetch();
    }
}
