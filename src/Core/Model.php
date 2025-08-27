<?php

namespace Core;

class Model {
    protected $db;

    public function __construct() {
        // Get the database instance from our Singleton Database class
        $this->db = Database::getInstance();
    }
}
