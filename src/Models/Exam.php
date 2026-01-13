<?php 
namespace App\Models;

use App\Database\Database;
use App\Helpers\Format;

class Exam{
	private $db;
	private $fm;

	public function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
	}

    // --- Exam Management ---
    public function addExam($data) {
        // Auto Migration for Scheduling and Auto-Evaluate
        $chk = $this->db->select("SHOW COLUMNS FROM tbl_exam LIKE 'start_time'");
        if(!$chk || $chk->num_rows == 0){
             $this->db->update("ALTER TABLE tbl_exam ADD COLUMN start_time DATETIME DEFAULT NULL");
             $this->db->update("ALTER TABLE tbl_exam ADD COLUMN end_time DATETIME DEFAULT NULL");
             $this->db->update("ALTER TABLE tbl_exam ADD COLUMN is_scheduled TINYINT(1) DEFAULT 0");
        }
        $chk2 = $this->db->select("SHOW COLUMNS FROM tbl_exam LIKE 'auto_evaluate'");
        if(!$chk2 || $chk2->num_rows == 0){
             $this->db->update("ALTER TABLE tbl_exam ADD COLUMN auto_evaluate TINYINT(1) DEFAULT 1");
        }
        $chk3 = $this->db->select("SHOW COLUMNS FROM tbl_exam LIKE 'assigned_group_id'");
        if(!$chk3 || $chk3->num_rows == 0){
             $this->db->update("ALTER TABLE tbl_exam ADD COLUMN assigned_group_id INT(11) DEFAULT NULL");
        }

        $name = mysqli_real_escape_string($this->db->link, $data['name']);
        $time = (int)$data['time_limit'];
        $status = isset($data['status']) ? 1 : 0;
        
        $is_scheduled = isset($data['is_scheduled']) ? 1 : 0;
        $auto_evaluate = isset($data['auto_evaluate']) ? 1 : 0;
        
        $assigned_group_id = isset($data['assigned_group_id']) && $data['assigned_group_id'] != '' ? (int)$data['assigned_group_id'] : "NULL";

        $start_time = !empty($data['start_time']) ? "'" . mysqli_real_escape_string($this->db->link, $data['start_time']) . "'" : "NULL";
        $end_time = !empty($data['end_time']) ? "'" . mysqli_real_escape_string($this->db->link, $data['end_time']) . "'" : "NULL";
        
        // Logic: If only End Time and no Start Time -> Start Time = Current Date
        if ($is_scheduled == 1 && $start_time == "NULL" && $end_time != "NULL") {
             $start_time = "'" . date('Y-m-d H:i:s') . "'";
        }
        
        // If not scheduled, ensure NULLs
        if ($is_scheduled == 0) {
            $start_time = "NULL";
            $end_time = "NULL";
        }

        $query = "INSERT INTO tbl_exam(name, time_limit, status, is_scheduled, start_time, end_time, auto_evaluate, assigned_group_id) 
                  VALUES('$name', '$time', '$status', '$is_scheduled', $start_time, $end_time, '$auto_evaluate', $assigned_group_id)";
        
        $inserted = $this->db->insert($query);
        if ($inserted) return "<div class='alert alert-success'>Exam Added!</div>";
        return "<div class='alert alert-danger'>Error adding exam.</div>";
    }

    public function getExams($limit = 100, $offset = 0) {
        $limit = (int)$limit;
        $offset = (int)$offset;
        
        // Ensure assigned_group_id exists (Quick Fix for Migration)
        $chk = $this->db->select("SHOW COLUMNS FROM tbl_exam LIKE 'assigned_group_id'");
        if(!$chk || $chk->num_rows == 0){
             $this->db->update("ALTER TABLE tbl_exam ADD COLUMN assigned_group_id INT(11) DEFAULT NULL");
        }
        
        $role = \App\Lib\Session::get("userRole"); // 0: User, 1: Admin, 2: Teacher
        if ($role == '0') {
             $userId = \App\Lib\Session::get("userId");
             // Get User Groups
             // Ensure tbl_group_members exists too
             $this->db->select("CREATE TABLE IF NOT EXISTS tbl_group_members (
                id INT(11) AUTO_INCREMENT PRIMARY KEY,
                group_id INT(11) NOT NULL,
                user_id INT(11) NOT NULL,
                joined_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                UNIQUE KEY unique_member (group_id, user_id)
            )");

             $q = "SELECT group_id FROM tbl_group_members WHERE user_id = '$userId'";
             $gRes = $this->db->select($q);
             $groupIds = [];
             if ($gRes) {
                 while($r = $gRes->fetch_assoc()) $groupIds[] = $r['group_id'];
             }
             
             $groupList = implode(',', $groupIds);
             $whereClause = "WHERE (assigned_group_id IS NULL";
             if (!empty($groupList)) {
                 $whereClause .= " OR assigned_group_id IN ($groupList)";
             }
             $whereClause .= ")";
             
             return $this->db->select("SELECT * FROM tbl_exam $whereClause ORDER BY id DESC LIMIT $limit OFFSET $offset");
        } else {
             // Admin/Teacher sees all
             return $this->db->select("SELECT * FROM tbl_exam ORDER BY id DESC LIMIT $limit OFFSET $offset");
        }
    }

    public function getTotalExams() {
        $res = $this->db->select("SELECT count(*) as cnt FROM tbl_exam");
        if($res) {
            $row = $res->fetch_assoc();
            return $row['cnt'];
        }
        return 0;
    }

    public function getExamById($id) {
        $res = $this->db->select("SELECT * FROM tbl_exam WHERE id = '$id'");
        return $res ? $res->fetch_assoc() : null;
    }

    public function assignToGroup($examId, $groupId, $start = null, $end = null) {
        $examId = (int)$examId;
        $groupId = (int)$groupId;
        
        $startTime = !empty($start) ? "'" . mysqli_real_escape_string($this->db->link, $start) . "'" : "NULL";
        $endTime = !empty($end) ? "'" . mysqli_real_escape_string($this->db->link, $end) . "'" : "NULL";
        
        // If assigned, it's implicitly scheduled for this group
        $isScheduled = ($startTime != "NULL" || $endTime != "NULL") ? 1 : 0;

        $query = "UPDATE tbl_exam SET 
            assigned_group_id = '$groupId',
            start_time = $startTime,
            end_time = $endTime,
            is_scheduled = '$isScheduled'
            WHERE id = '$examId'";
            
        $updated = $this->db->update($query);
        if ($updated) {
            return "<div class='alert alert-success'>Exam Assigned to Group Successfully!</div>";
        } else {
            return "<div class='alert alert-danger'>Error assigning exam.</div>";
        }
    }
    
    public function disableExamAssignment($examId) {
        $examId = (int)$examId;
        $query = "UPDATE tbl_exam SET assigned_group_id = NULL, is_scheduled = 0, start_time = NULL, end_time = NULL WHERE id = '$examId'";
        $updated = $this->db->update($query);
        if ($updated) return "<div class='alert alert-success'>Exam Assignment Disabled!</div>";
        return "<div class='alert alert-danger'>Error disabling assignment.</div>";
    }

    public function publishResults($examId) {
        $examId = (int)$examId;
        $query = "UPDATE tbl_exam SET auto_evaluate = 1 WHERE id = '$examId'";
        $updated = $this->db->update($query);
        if ($updated) return "<div class='alert alert-success'>Results Published! Students can now view their scores.</div>";
        return "<div class='alert alert-danger'>Error publishing results.</div>";
    }
    
    public function getExamsByGroupId($groupId) {
        $groupId = (int)$groupId;
        return $this->db->select("SELECT * FROM tbl_exam WHERE assigned_group_id = '$groupId' ORDER BY id DESC");
    }

    public function deleteExam($id) {
        $this->db->delete("DELETE FROM tbl_ques WHERE exam_id='$id'");
        $this->db->delete("DELETE FROM tbl_ans WHERE exam_id='$id'");
        $this->db->delete("DELETE FROM tbl_exam WHERE id='$id'");
        return "<div class='alert alert-success'>Exam Deleted!</div>";
    }

    public function updateExam($id, $data) {
        $name = mysqli_real_escape_string($this->db->link, $data['name']);
        $time = (int)$data['time_limit'];
        $status = isset($data['status']) ? 1 : 0;
        
        $is_scheduled = isset($data['is_scheduled']) ? 1 : 0;
        $auto_evaluate = isset($data['auto_evaluate']) ? 1 : 0; 
        
        $assigned_group_id = isset($data['assigned_group_id']) && $data['assigned_group_id'] != '' ? (int)$data['assigned_group_id'] : "NULL";

        $start_time = !empty($data['start_time']) ? "'" . mysqli_real_escape_string($this->db->link, $data['start_time']) . "'" : "NULL";
        $end_time = !empty($data['end_time']) ? "'" . mysqli_real_escape_string($this->db->link, $data['end_time']) . "'" : "NULL";
        
        if ($is_scheduled == 1 && $start_time == "NULL" && $end_time != "NULL") {
             $start_time = "'" . date('Y-m-d H:i:s') . "'";
        }
        if ($is_scheduled == 0) {
            $start_time = "NULL";
            $end_time = "NULL";
        }
        
        $query = "UPDATE tbl_exam SET 
            name='$name', 
            time_limit='$time', 
            status='$status',
            is_scheduled='$is_scheduled',
            auto_evaluate='$auto_evaluate',
            assigned_group_id=$assigned_group_id,
            start_time=$start_time,
            end_time=$end_time
            WHERE id='$id'";
            
        $updated = $this->db->update($query);
        if ($updated) return "<div class='alert alert-success'>Exam Updated!</div>";
        return "<div class='alert alert-danger'>Error updating exam.</div>";
    }

   // --- Question Management ---
    public function getAddQuestion($data){
        $examId = (int)$data['exam_id'];
        $quesNo = mysqli_real_escape_string($this->db->link, $data['quesNo']);
        $ques   = mysqli_real_escape_string($this->db->link, $data['ques']);
        $ans    = array();
        $ans[1] = $data['ans1'];
        $ans[2] = $data['ans2'];
        $ans[3] = $data['ans3'];
        $ans[4] = $data['ans4'];
        $rightAns = mysqli_real_escape_string($this->db->link, $data['rightAns']);

        $query = "INSERT INTO tbl_ques(exam_id, quesNo, ques) VALUES('$examId', '$quesNo','$ques')";
        $insert_row = $this->db->insert($query);

        if ($insert_row) {
            foreach ($ans as $key => $ansName) {
                if ($ansName != '') {
                    $isRight = ($rightAns == $key) ? '1' : '0';
                    $rquery = "INSERT INTO tbl_ans(exam_id, quesNo, rightAns, ans) VALUES('$examId', '$quesNo','$isRight','$ansName')";
                    $this->db->insert($rquery);
                }
            }
            return "<div class='alert alert-success'>Question Added Successfully!</div>";
        }
    }

    public function getQuestionById($id) {
         $q = $this->db->select("SELECT * FROM tbl_ques WHERE id = '$id'");
         return $q ? $q->fetch_assoc() : null;
    }
    
    public function getAnswersByQuesNo($quesNo, $examId) {
         return $this->db->select("SELECT * FROM tbl_ans WHERE quesNo = '$quesNo' AND exam_id = '$examId'");
    }

    public function updateQuestion($id, $data) {
         $examId = (int)$data['exam_id'];
         $quesNo = (int)$data['quesNo'];
         $ques = mysqli_real_escape_string($this->db->link, $data['ques']);
         $rightAns = (int)$data['rightAns'];
         
         $this->db->update("UPDATE tbl_ques SET ques='$ques' WHERE id='$id'");
         
         // Delete old answers
         $this->db->delete("DELETE FROM tbl_ans WHERE exam_id='$examId' AND quesNo='$quesNo'");
         
         // Insert new
        $ans = array();
        $ans[1] = $data['ans1'];
        $ans[2] = $data['ans2'];
        $ans[3] = $data['ans3'];
        $ans[4] = $data['ans4'];
        
        foreach ($ans as $key => $ansName) {
            if ($ansName != '') {
                $isRight = ($rightAns == $key) ? '1' : '0';
                $rquery = "INSERT INTO tbl_ans(exam_id, quesNo, rightAns, ans) VALUES('$examId', '$quesNo','$isRight','$ansName')";
                $this->db->insert($rquery);
            }
        }
        return "<div class='alert alert-success'>Question Updated!</div>";
    }

    public function getqueData($examId = null){
        if ($examId) {
             $query = "SELECT * FROM tbl_ques WHERE exam_id = '$examId' ORDER BY quesNo ASC";
        } else {
             $query = "SELECT q.*, e.name as exam_name FROM tbl_ques q LEFT JOIN tbl_exam e ON q.exam_id = e.id ORDER BY e.name ASC, q.quesNo ASC";
        }
        return $this->db->select($query);
    }
    
    public function deleteQuestion($id) {
        // Get details to delete answers
        $q_res = $this->db->select("SELECT * FROM tbl_ques WHERE id = '$id'");
        if ($q_res) {
            $q = $q_res->fetch_assoc();
            $eId = $q['exam_id'];
            $qNo = $q['quesNo'];
            $this->db->delete("DELETE FROM tbl_ques WHERE id = '$id'");
            $this->db->delete("DELETE FROM tbl_ans WHERE exam_id = '$eId' AND quesNo = '$qNo'");
            return "<div class='alert alert-success'>Question Deleted!</div>";
        }
    }

    public function getTotalRows($examId = null){
        if($examId){
            $query = "SELECT * FROM tbl_ques WHERE exam_id = '$examId'";
        } else {
            $query = "SELECT * FROM tbl_ques";
        }
        $getResult = $this->db->select($query);
        if ($getResult) return $getResult->num_rows;
        return 0;
    }

    // For User Taking Exam logic (legacy mostly, but updated for multi-exam)
    public function getQuestionNumber($quesNo, $examId = 1){
        $query = "SELECT * FROM tbl_ques WHERE quesNo = '$quesNo' AND exam_id = '$examId'";
        $result = $this->db->select($query);
        if ($result && $result->num_rows > 0) {
            return $result->fetch_assoc();
        }
        return false;
    }
    
    public function getAnswer($quesnumber, $examId = 1){
         $query = "SELECT * FROM tbl_ans WHERE quesNo = '$quesnumber' AND exam_id = '$examId'";
         return $this->db->select($query);
    }
}
