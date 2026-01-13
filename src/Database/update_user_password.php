<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/config.php';
use App\Database\Database;

$targetEmail = "visheshyadav62@gmail.com";
$newPass = "users123";
$db = new Database();

$hashedPass = md5($newPass);

$sql = "UPDATE tbl_user SET password = '$hashedPass' WHERE email = '$targetEmail'";
$db->link->query($sql);

if ($db->link->affected_rows > 0) {
    echo "Success: Password for '$targetEmail' updated to '$newPass'.\n";
} else {
    echo "Update attempted. If nothing changed, password might already be the same or user not found.\n";
}
