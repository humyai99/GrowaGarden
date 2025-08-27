<?php

namespace Models;

use Core\Model;
use PDO;

class Announcement extends Model {
    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all active announcements, ordered by most recent
     * @return array
     */
    public function getActiveAnnouncements() {
        $pdo = $this->db->pdo();
        $sql = "SELECT title, content, created_at FROM announcements WHERE is_active = 1 ORDER BY created_at DESC LIMIT 5";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }
}
