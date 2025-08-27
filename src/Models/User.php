<?php

namespace Models;

use Core\Model;
use PDO;

class User extends Model {
    public function __construct() {
        parent::__construct();
    }

    /**
     * Find user by email
     * @param string $email
     * @return mixed
     */
    public function findByEmail($email) {
        $pdo = $this->db->pdo();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE email = :email");
        $stmt->execute(['email' => $email]);
        return $stmt->fetch();
    }

    /**
     * Login user
     * @param string $email
     * @param string $password
     * @return mixed Returns user object on success, false on failure
     */
    public function login($email, $password) {
        $user = $this->findByEmail($email);

        if ($user) {
            // Check password
            if (password_verify($password, $user->password)) {
                return $user; // Password is correct
            }
        }

        return false; // User not found or password incorrect
    }

    /**
     * Register user
     * @param array $data
     * @return bool
     */
    public function register($data) {
        $pdo = $this->db->pdo();
        $sql = "INSERT INTO users (username, email, password, full_name, department_id) VALUES (:username, :email, :password, :full_name, :department_id)";
        $stmt = $pdo->prepare($sql);

        // Execute
        if ($stmt->execute($data)) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Create user (by admin)
     * @param array $data
     * @return bool
     */
    public function createUser($data) {
        $pdo = $this->db->pdo();
        $sql = "INSERT INTO users (username, email, password, full_name, role, department_id) VALUES (:username, :email, :password, :full_name, :role, :department_id)";
        $stmt = $pdo->prepare($sql);

        // Bind values
        $stmt->bindValue(':username', $data['username']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':password', $data['password']); // Hashed password
        $stmt->bindValue(':full_name', $data['full_name']);
        $stmt->bindValue(':role', $data['role']);
        $stmt->bindValue(':department_id', $data['department_id']);

        return $stmt->execute();
    }

    /**
     * Get all users with the role of technician or admin
     * @return array
     */
    public function getTechnicians() {
        $pdo = $this->db->pdo();
        $sql = "SELECT id, full_name FROM users WHERE role IN ('technician', 'admin') ORDER BY full_name ASC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function getAllUsers() {
        $pdo = $this->db->pdo();
        $sql = "SELECT u.id, u.username, u.full_name, u.email, u.role, d.name as department_name
                FROM users u
                LEFT JOIN departments d ON u.department_id = d.id
                ORDER BY u.full_name ASC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }

    public function findById($id) {
        $pdo = $this->db->pdo();
        $stmt = $pdo->prepare("SELECT * FROM users WHERE id = :id");
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    public function updateUser($data) {
        $pdo = $this->db->pdo();
        $sql = "UPDATE users SET full_name = :full_name, email = :email, role = :role, department_id = :department_id WHERE id = :id";

        // If password is provided, add it to the query
        if(!empty($data['password'])){
            $sql = "UPDATE users SET full_name = :full_name, email = :email, password = :password, role = :role, department_id = :department_id WHERE id = :id";
        }

        $stmt = $pdo->prepare($sql);

        $stmt->bindValue(':full_name', $data['full_name']);
        $stmt->bindValue(':email', $data['email']);
        $stmt->bindValue(':role', $data['role']);
        $stmt->bindValue(':department_id', $data['department_id']);
        $stmt->bindValue(':id', $data['id']);
        if(!empty($data['password'])){
            $stmt->bindValue(':password', $data['password']);
        }

        return $stmt->execute();
    }

    public function deleteUser($id) {
        $pdo = $this->db->pdo();
        // You should consider what to do with tickets from this user.
        // For now, we just delete the user. A soft delete might be better.
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }
}
