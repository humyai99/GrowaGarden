<?php

// Define App Root to make includes more robust
define('APP_ROOT', dirname(__DIR__));

// Require the bootstrap file using the correct directory separator for the OS
require_once(APP_ROOT . DIRECTORY_SEPARATOR . 'src' . DIRECTORY_SEPARATOR . 'bootstrap.php');

// Import the Router class
use Core\Router;

// Initialize the Router and dispatch the request
$router = new Router();
