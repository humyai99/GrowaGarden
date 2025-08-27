<?php

namespace Models;

use Core\Model;
use PDO;

class SystemStatus extends Model {
    public function __construct() {
        parent::__construct();
    }

    /**
     * Get the status of all systems
     * @return array
     */
    public function getAll() {
        $pdo = $this->db->pdo();
        $sql = "SELECT system_name, status, last_updated FROM system_status ORDER BY system_name ASC";
        $stmt = $pdo->query($sql);
        return $stmt->fetchAll();
    }
}
