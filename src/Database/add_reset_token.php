<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/config.php';
use App\Database\Database;

$db = new Database();
echo "Adding reset_token column to tbl_user...\n";

$check = $db->link->query("SHOW COLUMNS FROM tbl_user LIKE 'reset_token'");
if ($check && $check->num_rows == 0) {
    $sql = "ALTER TABLE tbl_user ADD COLUMN reset_token VARCHAR(255) NULL DEFAULT NULL";
    if ($db->link->query($sql)) {
        echo "Column 'reset_token' added successfully.\n";
    } else {
        echo "Error adding column: " . $db->link->error . "\n";
    }
} else {
    echo "Column 'reset_token' already exists.\n";
}
