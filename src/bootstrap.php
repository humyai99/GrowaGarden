<?php

// Require Composer's autoloader if you're using it
// require_once dirname(__DIR__) . '/vendor/autoload.php';

// Require configuration
require_once dirname(__DIR__) . '/config/config.php';

// Autoloader for our application classes
spl_autoload_register(function ($className) {
    // Core libraries are in the 'Core' namespace
    // e.g. Core\Router -> src/Core/Router.php
    $file = APP_ROOT . '/src/' . str_replace('\\', '/', $className) . '.php';
    if (file_exists($file)) {
        require_once $file;
    }
});

// Start the session
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
