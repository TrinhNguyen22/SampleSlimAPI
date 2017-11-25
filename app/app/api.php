<?php
require '/../../app/vendor/autoload.php';

// Use Medoo namespace
use Medoo\Medoo;

// Create Medoo database object
class DatabaseController {
    private $database;

    public function __construct() {
        $this->database = new Medoo([
            'database_type' => 'sqlite',
            'database_file' => '../db/Pets.db',
            'option' => [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            ],
        ]);
    }
}