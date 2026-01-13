<?php
namespace App\Database;

use mysqli;

class Database {
    public $host   = DB_HOST;
    public $user   = DB_USER;
    public $pass   = DB_PASS;
    public $dbname = DB_NAME;

    public $link;
    public $error;

    public function __construct() {
        $this->connectDB();
    }

    private function connectDB() {
        // Suppress errors to handle them manually if needed, or rely on try-catch with new driver
        // For compatibility with existing legacy code structure:
        try {
            $this->link = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
            if ($this->link->connect_error) {
                $this->error = "Connection failed: " . $this->link->connect_error;
                return false;
            }
        } catch (\Exception $e) {
            $this->error = "Connection failed: " . $e->getMessage();
            return false;
        }
    }

    // Select or Read data
    public function select($query) {
        if (!$this->link) {
            die("Database Connection Error: " . $this->error);
        }
        $result = $this->link->query($query);
        if (!$result) {
            // Keep original behavior but strictly it should throw exception or handle error
             $this->error = "Query failed: " . $this->link->error;
             return false;
        }
        if ($result === true) {
             // For statements like CREATE/ALTER/DROP that return boolean true
             return true;
        }
        if ($result->num_rows > 0) {
            return $result;
        } else {
            return false;
        }
    }

    // Insert data
    public function insert($query) {
        $insert_row = $this->link->query($query);
        if (!$insert_row) {
             $this->error = "Insert failed: " . $this->link->error;
             return false;
        }
        return $insert_row;
    }

    // Update data
    public function update($query) {
        $update_row = $this->link->query($query);
        if (!$update_row) {
             $this->error = "Update failed: " . $this->link->error;
             return false;
        }
        return $update_row;
    }

    // Delete data
    public function delete($query) {
        $delete_row = $this->link->query($query);
        if (!$delete_row) {
             $this->error = "Delete failed: " . $this->link->error;
             return false;
        }
        return $delete_row;
    }
}
