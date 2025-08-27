<?php

// Database Configuration
define('DB_HOST', 'localhost');
define('DB_NAME', 'it_helpdesk');
define('DB_USER', 'root');
define('DB_PASS', '');
define('DB_CHARSET', 'utf8mb4');

// Application Configuration
if (!defined('APP_ROOT')) {
    define('APP_ROOT', dirname(__DIR__));
}
define('URL_ROOT', 'http://localhost/helpdesk'); // Change this to your actual URL
define('APP_NAME', 'IT Helpdesk');

// Timezone
date_default_timezone_set('Asia/Bangkok');

// Enable/Disable error reporting for development
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
