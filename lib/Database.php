<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../config/config.php');

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
        $this->link = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if ($this->link->connect_error) {
            $this->error = "Connection failed: " . $this->link->connect_error;
            return false;
        }
    }

    // Select or Read data
    public function select($query) {
        $result = $this->link->query($query);
        if (!$result) {
            die("Query failed: " . $this->link->error);
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
            die("Insert failed: " . $this->link->error);
        }
        return $insert_row;
    }

    // Update data
    public function update($query) {
        $update_row = $this->link->query($query);
        if (!$update_row) {
            die("Update failed: " . $this->link->error);
        }
        return $update_row;
    }

    // Delete data
    public function delete($query) {
        $delete_row = $this->link->query($query);
        if (!$delete_row) {
            die("Delete failed: " . $this->link->error);
        }
        return $delete_row;
    }
}
