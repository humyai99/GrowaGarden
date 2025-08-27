<?php

namespace Models;

use Core\Model;
use PDO;

class Ticket extends Model {
    public function __construct() {
        parent::__construct();
    }

    /**
     * Get all tickets from the database, joining with user and department tables
     * @return array
     */
    public function getAllTickets() {
        // We get the raw PDO object from our db instance
        $pdo = $this->db->pdo();

        $sql = "SELECT
                    t.id,
                    t.ticket_id,
                    t.subject,
                    t.status,
                    t.priority,
                    t.created_at,
                    u.full_name as requester_name,
                    d.name as department_name,
                    tech.full_name as assigned_to_name
                FROM tickets t
                JOIN users u ON t.user_id = u.id
                LEFT JOIN departments d ON u.department_id = d.id
                LEFT JOIN users tech ON t.assigned_to = tech.id
                ORDER BY t.created_at DESC";

        $stmt = $pdo->query($sql);

        return $stmt->fetchAll();
    }

    /**
     * Create a new ticket
     * @param array $data
     * @return bool
     */
    public function create($data) {
        $pdo = $this->db->pdo();

        // Generate a unique ticket ID
        $ticket_id = 'TICKET-' . date('Ymd') . '-' . substr(str_shuffle('0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ'), 1, 5);

        $sql = "INSERT INTO tickets (ticket_id, user_id, issue_type, subject, description, attachment_path, priority)
                VALUES (:ticket_id, :user_id, :issue_type, :subject, :description, :attachment_path, :priority)";

        $stmt = $pdo->prepare($sql);

        // Bind values
        $stmt->bindValue(':ticket_id', $ticket_id);
        $stmt->bindValue(':user_id', $data['user_id']);
        $stmt->bindValue(':issue_type', $data['issue_type']);
        $stmt->bindValue(':subject', $data['subject']);
        $stmt->bindValue(':description', $data['description']);
        $stmt->bindValue(':attachment_path', $data['attachment_path']);
        $stmt->bindValue(':priority', $data['priority']);

        // Execute
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    /**
     * Find a ticket by its public-facing Ticket ID
     * @param string $ticket_id
     * @return mixed
     */
    public function findByTicketId($ticket_id) {
        $pdo = $this->db->pdo();
        $sql = "SELECT
                    t.*,
                    u.full_name as requester_name,
                    d.name as department_name,
                    tech.full_name as assigned_to_name
                FROM tickets t
                JOIN users u ON t.user_id = u.id
                LEFT JOIN departments d ON u.department_id = d.id
                LEFT JOIN users tech ON t.assigned_to = tech.id
                WHERE t.ticket_id = :ticket_id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['ticket_id' => $ticket_id]);
        return $stmt->fetch();
    }

    /**
     * Find a ticket by its primary key ID
     * @param int $id
     * @return mixed
     */
    public function findById($id) {
        $pdo = $this->db->pdo();
        $sql = "SELECT
                    t.*,
                    u.full_name as requester_name,
                    d.name as department_name,
                    tech.full_name as assigned_to_name
                FROM tickets t
                JOIN users u ON t.user_id = u.id
                LEFT JOIN departments d ON u.department_id = d.id
                LEFT JOIN users tech ON t.assigned_to = tech.id
                WHERE t.id = :id";

        $stmt = $pdo->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch();
    }

    /**
     * Update a ticket's status and assigned technician
     * @param array $data
     * @return bool
     */
    public function update($data) {
        $pdo = $this->db->pdo();
        $sql = "UPDATE tickets SET status = :status, assigned_to = :assigned_to WHERE id = :id";
        $stmt = $pdo->prepare($sql);

        // Bind values
        $stmt->bindValue(':status', $data['status']);
        $stmt->bindValue(':assigned_to', $data['assigned_to']);
        $stmt->bindValue(':id', $data['id']);

        // Execute
        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }

    public function getFilteredTickets($filters) {
        $pdo = $this->db->pdo();
        $sql = "SELECT t.*, u.full_name as requester_name, d.name as department_name, tech.full_name as assigned_to_name
                FROM tickets t
                JOIN users u ON t.user_id = u.id
                LEFT JOIN departments d ON u.department_id = d.id
                LEFT JOIN users tech ON t.assigned_to = tech.id
                WHERE 1=1"; // Start with a true condition

        $params = [];

        if (!empty($filters['status']) && $filters['status'] != 'all') {
            $sql .= " AND t.status = :status";
            $params[':status'] = $filters['status'];
        }
        if (!empty($filters['date_from'])) {
            $sql .= " AND t.created_at >= :date_from";
            $params[':date_from'] = $filters['date_from'];
        }
        if (!empty($filters['date_to'])) {
            // Add 1 day to include the whole 'to' day
            $date_to = date('Y-m-d', strtotime($filters['date_to'] . ' +1 day'));
            $sql .= " AND t.created_at < :date_to";
            $params[':date_to'] = $date_to;
        }

        $sql .= " ORDER BY t.created_at DESC";

        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        return $stmt->fetchAll();
    }
}
