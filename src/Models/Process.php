<?php 
namespace App\Models;

use App\Lib\Session;
use App\Database\Database;
use App\Helpers\Format;

class Process{
	private $db;
	private $fm;

	public function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
	}
    
   public function getProcessData($data){
     $selectAns  = strip_tags($data['ans']); 
     $quesnumber = (int)$data['quesnumber'];
     $examId     = isset($data['exam_id']) ? (int)$data['exam_id'] : 1;
     
     $selectAns  = mysqli_real_escape_string($this->db->link, $selectAns);

     if (!isset($_SESSION['score'])) {
     	 $_SESSION['score'] = '0';
         $_SESSION['exam_start_time_server'] = time();
     }
     if (!isset($_SESSION['user_answers'])) {
         $_SESSION['user_answers'] = array();
     }

     $total = $this->getTotal($examId);
     
     // Store User Selection
     $_SESSION['user_answers'][$quesnumber] = $selectAns;

     $right = $this->rightAns($quesnumber, $examId);
     
     if ($right == $selectAns) {
     	$_SESSION['score']++;
     }
     
     if ($quesnumber == $total) {
        $userId = Session::get("userId") ?? 0;
        $this->saveAttempt($userId, $examId, $_SESSION['score'], $total);
        $_SESSION['exam_completed'] = true; // Block back button usage
     	header("Location:final");
     	exit();
     }else{
        $next = $quesnumber + 1;
     	header("Location:test?q=".$next."&exam_id=".$examId);
        exit();
     }
   }
   
   private function getTotal($examId){
   	$query = "SELECT * FROM tbl_ques WHERE exam_id = '$examId'";
   	$result = $this->db->select($query);
   	return $result ? $result->num_rows : 0;
   }
   
   public function rightAns($quesnumber, $examId){
   	$query = "SELECT * FROM tbl_ans WHERE quesNo = '$quesnumber' AND exam_id = '$examId' AND rightAns = '1'";
   	$result = $this->db->select($query);
    if($result) {
        $row = $result->fetch_assoc();
   	    return $row['id'];
    }
    return null;
   }

    public function getLastAttempt($userId) {
        $query = "SELECT * FROM tbl_attempts WHERE userId = '$userId' ORDER BY attempt_date DESC LIMIT 1";
        $result = $this->db->select($query);
        return $result ? $result->fetch_assoc() : null;
    }

   private function saveAttempt($userId, $examId, $score, $total){
       // Auto-Migration
       $check = $this->db->select("SHOW TABLES LIKE 'tbl_attempts'");
       if (!$check || $check->num_rows == 0) {
           $sql = "CREATE TABLE tbl_attempts (
               id INT(11) AUTO_INCREMENT PRIMARY KEY,
               userId INT(11) NOT NULL,
               examId INT(11) NOT NULL,
               score INT(11) NOT NULL,
               total INT(11) NOT NULL,
               time_taken VARCHAR(50) DEFAULT NULL,
               attempt_date DATETIME DEFAULT CURRENT_TIMESTAMP
           )";
           $this->db->update($sql);
       }

       // Calculate Time Taken (Server Side fallback or Session)
       $time_str = "N/A";
       if (isset($_SESSION['exam_start_time_server'])) {
           $duration = time() - $_SESSION['exam_start_time_server'];
           $mins = floor($duration / 60);
           $secs = $duration % 60;
           $time_str = sprintf("%02d:%02d", $mins, $secs);
           unset($_SESSION['exam_start_time_server']);
       }

       $userId = mysqli_real_escape_string($this->db->link, $userId);
       $examId = mysqli_real_escape_string($this->db->link, $examId);
       $score  = mysqli_real_escape_string($this->db->link, $score);
       $total  = mysqli_real_escape_string($this->db->link, $total);
       $time_str = mysqli_real_escape_string($this->db->link, $time_str);

       $query = "INSERT INTO tbl_attempts (userId, examId, score, total, time_taken) VALUES ('$userId', '$examId', '$score', '$total', '$time_str')";
       $attempt_insert = $this->db->insert($query);
       
       if ($attempt_insert) {
           // Get the Attempt ID we just created
           $attemptId = $this->db->link->insert_id;
           
           // Auto-Migration for User Answers Detail
           $chkAns = $this->db->select("SHOW TABLES LIKE 'tbl_user_ans'");
           if (!$chkAns || $chkAns->num_rows == 0) {
              $sql = "CREATE TABLE tbl_user_ans (
                  id INT(11) AUTO_INCREMENT PRIMARY KEY,
                  attempt_id INT(11) NOT NULL,
                  question_no INT(11) NOT NULL,
                  selected_ans_id INT(11) NOT NULL
              )";
              $this->db->update($sql);
           }
           
           // Save Detailed Answers from Session
           if (isset($_SESSION['user_answers']) && is_array($_SESSION['user_answers'])) {
               foreach ($_SESSION['user_answers'] as $qNo => $ansId) {
                   $qNo = (int)$qNo;
                   $ansId = (int)$ansId;
                   $q = "INSERT INTO tbl_user_ans (attempt_id, question_no, selected_ans_id) VALUES ('$attemptId', '$qNo', '$ansId')";
                   $this->db->insert($q);
               }
           }
       }
}
