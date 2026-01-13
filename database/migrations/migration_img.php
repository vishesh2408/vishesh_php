<?php
include 'src/Database/Database.php';
// basic migration script
use App\Database\Database;
$db = new Database();
$query = "ALTER TABLE tbl_user ADD image VARCHAR(255) DEFAULT NULL";
$result = $db->update($query); // Update usually runs generic queries too in some wrappers, or use direct link if public
if($result) echo "Column added.";
else echo "Column might exist or error.";
