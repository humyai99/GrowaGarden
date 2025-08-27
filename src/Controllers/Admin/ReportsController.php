<?php

namespace Controllers\Admin;

use Core\Controller;

class ReportsController extends Controller {
    private $ticketModel;

    public function __construct() {
        $this->ticketModel = $this->model('Ticket');

        // Protect this entire controller
        if (!isset($_SESSION['user_role']) || !in_array($_SESSION['user_role'], ['admin', 'technician'])) {
            header('location: ' . URL_ROOT);
            exit();
        }
    }

    /**
     * Show the reports page with filters
     */
    public function index() {
        $tickets = [];
        // Sanitize GET parameters
        $filters = [
            'status' => $_GET['status'] ?? 'all',
            'date_from' => $_GET['date_from'] ?? '',
            'date_to' => $_GET['date_to'] ?? ''
        ];

        // Only fetch tickets if there's a filter set (or on first load)
        if (!empty($_GET)) {
             $tickets = $this->ticketModel->getFilteredTickets($filters);
        }

        $data = [
            'title' => 'Ticket Reports',
            'tickets' => $tickets,
            'filters' => $filters
        ];

        $this->view('admin/reports/index', $data);
    }

    /**
     * Export filtered tickets to a CSV file
     */
    public function export_csv() {
        $filters = [
            'status' => $_GET['status'] ?? 'all',
            'date_from' => $_GET['date_from'] ?? '',
            'date_to' => $_GET['date_to'] ?? ''
        ];

        $tickets = $this->ticketModel->getFilteredTickets($filters);

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="helpdesk_report_'.date('Y-m-d').'.csv"');

        $output = fopen('php://output', 'w');

        // Add header row
        fputcsv($output, ['Ticket ID', 'Subject', 'Requester', 'Department', 'Status', 'Priority', 'Assigned To', 'Date Created']);

        // Add data rows
        foreach ($tickets as $ticket) {
            fputcsv($output, [
                $ticket->ticket_id,
                $ticket->subject,
                $ticket->requester_name,
                $ticket->department_name,
                $ticket->status,
                $ticket->priority,
                $ticket->assigned_to_name ?? 'Unassigned',
                $ticket->created_at
            ]);
        }

        fclose($output);
        exit();
    }
}
