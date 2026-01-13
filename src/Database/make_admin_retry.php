<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/config.php';
use App\Database\Database;

$targetEmail = "visheshyadav2408@gmail.com";
$db = new Database();

$sql = "UPDATE tbl_user SET role = 1 WHERE email = '$targetEmail'";
$db->link->query($sql);

if ($db->link->affected_rows > 0) {
    echo "Success: User '$targetEmail' is now an Admin.\n";
} else {
    echo "Error: Could not update user. SQL Error: " . $db->link->error . "\n";
}
