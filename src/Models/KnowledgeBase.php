<?php

namespace Models;

use Core\Model;
use PDO;

class KnowledgeBase extends Model {
    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all knowledge base articles
     * @return array
     */
    public function getAll() {
        $pdo = $this->db->pdo();
        $sql = "SELECT id, title, category, created_at FROM knowledge_base ORDER BY category, title ASC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }

    /**
     * Find a knowledge base article by its ID
     * @param int $id
     * @return mixed
     */
    public function findById($id) {
        $pdo = $this->db->pdo();
        $sql = "SELECT * FROM knowledge_base WHERE id = :id";
        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }
}
