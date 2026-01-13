<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/config.php';
use App\Database\Database;

$db = new Database();
$db->link->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;

echo "--- tbl_ques Columns ---\n";
$r = $db->link->query("SHOW COLUMNS FROM tbl_ques");
while($row = $r->fetch_assoc()) {
    echo $row['Field'] . " - " . $row['Type'] . "\n";
}

echo "\n--- tbl_ans Columns (if exists) ---\n";
try {
    $r = $db->link->query("SHOW COLUMNS FROM tbl_ans");
    while($row = $r->fetch_assoc()) {
        echo $row['Field'] . " - " . $row['Type'] . "\n";
    }
} catch (Exception $e) { echo "tbl_ans does not exist.\n"; }
