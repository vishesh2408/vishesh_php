<?php
include 'src/Database/Database.php';
use App\Database\Database;
$db = new Database();

// Add new columns
$queries = [
    "ALTER TABLE tbl_user ADD phone VARCHAR(20) DEFAULT NULL",
    "ALTER TABLE tbl_user ADD dob DATE DEFAULT NULL",
    "ALTER TABLE tbl_user ADD bio TEXT DEFAULT NULL",
    "ALTER TABLE tbl_user ADD gender VARCHAR(10) DEFAULT NULL",
    "ALTER TABLE tbl_user ADD address TEXT DEFAULT NULL"
];

foreach($queries as $q) {
    $db->update($q);
}
echo "Migration attempted.";
