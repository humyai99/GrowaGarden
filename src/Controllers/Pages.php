<?php

namespace Controllers;

use Core\Controller;

class Pages extends Controller {
    public function __construct() {
        // This is where we will instantiate models
    }

    public function index() {
        // Instantiate models
        $announcementModel = $this->model('Announcement');
        $systemStatusModel = $this->model('SystemStatus');

        // Fetch data
        $announcements = $announcementModel->getActiveAnnouncements();
        $statuses = $systemStatusModel->getAll();

        $data = [
            'title' => 'Welcome to the IT Helpdesk',
            'description' => 'Your one-stop solution for IT support.',
            'announcements' => $announcements,
            'statuses' => $statuses
        ];

        // This will look for the file at /templates/pages/index.php
        $this->view('pages/index', $data);
    }

    public function about() {
        $data = [
            'title' => 'About Us & Contact IT',
            'description' => 'Get in touch with the IT department.'
        ];
        $this->view('pages/about', $data);
    }
}
