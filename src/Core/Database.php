<?php

namespace Core;

use PDO;
use PDOException;

/*
 * PDO Database Class
 * Connect to database
 * Create prepared statements
 * Bind values
 * Return rows and results
 */
class Database {
    private static $instance = null;

    private $host = DB_HOST;
    private $user = DB_USER;
    private $pass = DB_PASS;
    private $dbname = DB_NAME;
    private $charset = DB_CHARSET;

    private $dbh; // Database Handler
    private $stmt; // Statement
    private $error;

    private function __construct() {
        $dsn = 'mysql:host=' . $this->host . ';dbname=' . $this->dbname . ';charset=' . $this->charset;
        $options = [
            PDO::ATTR_PERSISTENT => true,
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_OBJ,
            PDO::ATTR_EMULATE_PREPARES => false,
        ];

        try {
            $this->dbh = new PDO($dsn, $this->user, $this->pass, $options);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
            // In a real app, you'd log this error, not echo it
            die('Database Connection Error: ' . $this->error);
        }
    }

    public static function getInstance() {
        if (self::$instance == null) {
            // Require config if it hasn't been loaded yet
            if (!defined('DB_HOST')) {
                require_once dirname(__DIR__, 2) . '/config/config.php';
            }
            self::$instance = new Database();
        }
        return self::$instance;
    }

    // Get the underlying PDO object
    public function pdo() {
        return $this->dbh;
    }

    // Further methods for querying, binding, executing will be added later
    // Example:
    // public function query($sql) {
    //     $this->stmt = $this->dbh->prepare($sql);
    // }
    //
    // public function bind($param, $value, $type = null) { ... }
    //
    // public function execute() { ... }
    //
    // public function resultSet() { ... }
    //
    // public function single() { ... }
}
