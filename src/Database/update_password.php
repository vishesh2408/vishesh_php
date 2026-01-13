<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/config.php';
use App\Database\Database;

$targetEmail = "visheshyadav2408@gmail.com";
$newPass = "admin123";
$db = new Database();

// MD5 hashing to match system standard
$hashedPass = md5($newPass);

$sql = "UPDATE tbl_user SET password = '$hashedPass' WHERE email = '$targetEmail'";
$db->link->query($sql);

if ($db->link->affected_rows > 0) {
    echo "Success: Password for '$targetEmail' updated to '$newPass'.\n";
} else {
    // If password was already same, affected rows might be 0, but query successful.
    echo "Update attempted. If nothing changed, password might already be the same.\n";
}
