<?php
require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/config.php';
use App\Database\Database;

$db = new Database();
$db->link->report_mode = MYSQLI_REPORT_ERROR | MYSQLI_REPORT_STRICT;

echo "Migrating Database for Multi-Exam Support...\n";

// 1. Create tbl_exam
$sql = "CREATE TABLE IF NOT EXISTS tbl_exam (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    description TEXT,
    time_limit INT(11) DEFAULT 30,
    status INT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
)";
$db->link->query($sql);
echo "tbl_exam created/checked.\n";

// 2. Add exam_id to tbl_ques
$check = $db->link->query("SHOW COLUMNS FROM tbl_ques LIKE 'exam_id'");
if ($check->num_rows == 0) {
    $db->link->query("ALTER TABLE tbl_ques ADD COLUMN exam_id INT(11) DEFAULT 0 AFTER id");
    echo "Added exam_id to tbl_ques.\n";
}

// 3. Add exam_id to tbl_ans
$check = $db->link->query("SHOW COLUMNS FROM tbl_ans LIKE 'exam_id'");
if ($check->num_rows == 0) {
    $db->link->query("ALTER TABLE tbl_ans ADD COLUMN exam_id INT(11) DEFAULT 0 AFTER id");
    echo "Added exam_id to tbl_ans.\n";
}

// 4. Create a Default Exam for existing questions
// Check if any questions exist
$q_check = $db->link->query("SELECT COUNT(*) as c FROM tbl_ques WHERE exam_id = 0");
$count = $q_check->fetch_assoc()['c'];

if ($count > 0) {
    echo "Found $count questions with no exam. Assigning to 'General Knowledge' (Default Exam).\n";
    // Check if default exam exists
    $e_check = $db->link->query("SELECT id FROM tbl_exam WHERE name = 'General Knowledge'");
    if ($e_check->num_rows == 0) {
        $db->link->query("INSERT INTO tbl_exam (name, status) VALUES ('General Knowledge', 1)");
        $default_id = $db->link->insert_id;
    } else {
        $default_id = $e_check->fetch_assoc()['id'];
    }
    
    $db->link->query("UPDATE tbl_ques SET exam_id = '$default_id' WHERE exam_id = 0");
    $db->link->query("UPDATE tbl_ans SET exam_id = '$default_id' WHERE exam_id = 0");
    echo "Updated existing questions/answers to Exam ID: $default_id.\n";
}

echo "Migration Complete.\n";
