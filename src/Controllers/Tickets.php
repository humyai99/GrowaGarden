<?php

namespace Controllers;

use Core\Controller;

class Tickets extends Controller {
    private $ticketModel;
    private $userModel;

    public function __construct() {
        // Instantiate models
        $this->ticketModel = $this->model('Ticket');
        $this->userModel = $this->model('User');
    }

    /**
     * Index method to display all tickets (Protected)
     */
    public function index() {
        // Check for technician or admin role
        if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], ['admin', 'technician'])) {
            header('location: ' . URL_ROOT . '/users/login');
            exit();
        }

        // Get all tickets from the model
        $tickets = $this->ticketModel->getAllTickets();

        // Prepare data for the view
        $data = [
            'title' => 'All Helpdesk Tickets',
            'tickets' => $tickets
        ];

        // Load the view with the data
        $this->view('tickets/index', $data);
    }

    /**
     * Show a single ticket's details (Protected)
     * @param int $id
     */
    public function show($id) {
        if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], ['admin', 'technician'])) {
            header('location: ' . URL_ROOT . '/users/login');
            exit();
        }

        $ticket = $this->ticketModel->findById($id);

        if (!$ticket) {
            header('location: ' . URL_ROOT . '/tickets');
            exit();
        }

        $technicians = $this->userModel->getTechnicians();

        $data = [
            'title' => 'Ticket Details',
            'ticket' => $ticket,
            'technicians' => $technicians
        ];

        $this->view('tickets/show', $data);
    }

    /**
     * Update a ticket's status and assignment (Protected)
     * @param int $id
     */
    public function update($id) {
        if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], ['admin', 'technician'])) {
            header('location: ' . URL_ROOT);
            exit();
        }

        $data = [
            'id' => $id,
            'status' => trim($_POST['status']),
            'assigned_to' => trim($_POST['assigned_to'])
        ];

        // Basic validation
        if (!empty($data['status']) && !empty($data['assigned_to'])) {
            if ($this->ticketModel->update($data)) {
                // Success, redirect back to the ticket
                header('location: ' . URL_ROOT . '/tickets/show/' . $id);
            } else {
                die('Something went wrong updating the ticket.');
            }
        } else {
            // In a real app, you'd handle this error more gracefully
            header('location: ' . URL_ROOT . '/tickets/show/' . $id);
        }
    }

    /**
     * Show form to create a new ticket
     */
    public function create() {
        // Check if user is logged in
        if (!isset($_SESSION['user_id'])) {
            header('location: ' . URL_ROOT . '/users/login');
            exit();
        }

        $data = [
            'title' => 'Report a New Issue',
            'issue_type' => '',
            'subject' => '',
            'description' => '',
            'priority' => 'medium',
            'subject_err' => '',
            'description_err' => ''
        ];

        $this->view('tickets/create', $data);
    }

    /**
     * Store a new ticket in the database
     */
    public function store() {
        if ($_SERVER['REQUEST_METHOD'] != 'POST' || !isset($_SESSION['user_id'])) {
            header('location: ' . URL_ROOT);
            exit();
        }

        $data = [
            'title' => 'Report a New Issue',
            'user_id' => $_SESSION['user_id'],
            'issue_type' => trim($_POST['issue_type']),
            'subject' => trim($_POST['subject']),
            'description' => trim($_POST['description']),
            'priority' => trim($_POST['priority']),
            'attachment_path' => '',
            'subject_err' => '',
            'description_err' => ''
        ];

        // Validate data
        if (empty($data['subject'])) {
            $data['subject_err'] = 'Please enter a subject';
        }
        if (empty($data['description'])) {
            $data['description_err'] = 'Please enter a description';
        }

        // Handle file upload
        if (isset($_FILES['attachment']) && $_FILES['attachment']['error'] == UPLOAD_ERR_OK) {
            $uploadDir = 'uploads/';
            $fileName = basename($_FILES['attachment']['name']);
            $targetFilePath = $uploadDir . time() . '-' . $fileName;

            // Check if file is valid
            // You should add more robust validation (file type, size) in a real app
            if (move_uploaded_file($_FILES['attachment']['tmp_name'], $targetFilePath)) {
                $data['attachment_path'] = $targetFilePath;
            } else {
                // Handle upload error, maybe set an error message in $data
            }
        }

        // Make sure errors are empty
        if (empty($data['subject_err']) && empty($data['description_err'])) {
            // Validated, call model method
            if ($this->ticketModel->create($data)) {
                // Redirect to a success page or the ticket list
                // For now, redirect to the main tickets page
                header('location: ' . URL_ROOT . '/tickets');
            } else {
                die('Something went wrong');
            }
        } else {
            // Load view with errors
            $this->view('tickets/create', $data);
        }
    }

    /**
     * Track a ticket's status
     */
    public function track() {
        $data = [
            'title' => 'Track Ticket Status',
            'ticket_id' => '',
            'ticket' => null,
            'error' => ''
        ];

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $ticket_id = trim($_POST['ticket_id']);

            if (empty($ticket_id)) {
                $data['error'] = 'Please enter a Ticket ID.';
            } else {
                $ticket = $this->ticketModel->findByTicketId($ticket_id);
                if ($ticket) {
                    $data['ticket'] = $ticket;
                } else {
                    $data['error'] = 'No ticket found with that ID. Please check the ID and try again.';
                }
            }
            $data['ticket_id'] = $ticket_id;
        }

        $this->view('tickets/track', $data);
    }
}
