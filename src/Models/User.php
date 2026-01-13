<?php
namespace App\Models;

use App\Database\Database;
use App\Lib\Session;
use App\Helpers\Format;

class User{
	private $db;
	private $fm;

    // Use dependency injection or initialize in constructor
	public function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
	}

    // ... (Remainder of the file with minor adjustments if needed, sticking to original logic)
    
	public function userRegistion($name,$userName,$password,$email, $institution = '', $institution_id = ''){
      $name     = $this->fm->validation($name);
      $userName = $this->fm->validation($userName);
      $password = $this->fm->validation($password);
      $email    = $this->fm->validation($email);
      $institution = $this->fm->validation($institution);
      $institution_id = $this->fm->validation($institution_id);

      $name     = mysqli_real_escape_string($this->db->link, $name);
      $userName = mysqli_real_escape_string($this->db->link, $userName);
      $password = mysqli_real_escape_string($this->db->link, $password); 
      $email    = mysqli_real_escape_string($this->db->link, $email);
      $institution = mysqli_real_escape_string($this->db->link, $institution);
      $institution_id = mysqli_real_escape_string($this->db->link, $institution_id);

      // Auto-Migration for Institution & ID
      $checkInst = $this->db->select("SHOW COLUMNS FROM tbl_user LIKE 'institution'");
      if(!$checkInst) {
          $this->db->update("ALTER TABLE tbl_user ADD institution VARCHAR(255) DEFAULT NULL");
      }
      $checkID = $this->db->select("SHOW COLUMNS FROM tbl_user LIKE 'institution_id'");
      if(!$checkID) {
          $this->db->update("ALTER TABLE tbl_user ADD institution_id VARCHAR(100) DEFAULT NULL");
      }

      if ($name == "" || $userName == "" || $password == "" || $email == "") {
         echo "<div class=\"alert alert-danger alert-dismissible\">
    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
    <strong>Fields must not be empty</strong>
  </div>";
          exit();
      }elseif (filter_var($email, FILTER_VALIDATE_EMAIL) === false) {
         echo "<div class=\"alert alert-danger alert-dismissible\">
    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
    <strong>Invalid email address.</strong></div>";
          exit();
      }else{
         $chkquery = "SELECT * FROM tbl_user WHERE email = '$email'";
         $chkresult = $this->db->select($chkquery);
         if ($chkresult != false) {
            echo "<div class=\"alert alert-danger alert-dismissible\">
    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
    <strong>Email already exists. Try with different email.</strong></div>";
          exit();
         }else{
            $query = "INSERT INTO tbl_user(name, userName, password, email, institution, institution_id) VALUES('$name','$userName', MD5('".$password."'),'$email', '$institution', '$institution_id')";
            $insertr = $this->db->insert($query);
            if ($insertr) {
               echo "<div class=\"alert alert-success alert-dismissible fade show\">Registration Successful. Please login.</div>";
               exit();
            }else{
               echo "<div class=\"alert alert-danger alert-dismissible\">
    <button type=\"button\" class=\"close\" data-dismiss=\"alert\">&times;</button>
    <strong>Something happened. Registration Unsucessful.</strong></div>";
               exit();
            }
         }
      }
	}

   public function userLogin($email, $password){
      $email    = $this->fm->validation($email);
      $password = $this->fm->validation($password);
      $email    = mysqli_real_escape_string($this->db->link, $email);
      if ($email == "" || $password == "") {
         echo "empty";
         exit();
      }else{
        $password = mysqli_real_escape_string($this->db->link, $password);
         $query = "SELECT * FROM tbl_user WHERE email = '$email' AND password = MD5('".$password."')";
         $result = $this->db->select($query);
         if ($result != false) {
            $value = $result->fetch_assoc();
            if ($value['status'] == '1') {
               echo "disable";
               exit();
            }else{
               Session::init();
               Session::set("login", true);
               Session::set("userId", $value['userId']);
               Session::set("userName", $value['userName']);
               Session::set("name", $value['name']);
               Session::set("role", $value['role']);
               Session::set("image", isset($value['image']) ? $value['image'] : null);
               
               if ($value['role'] == 1) {
                   echo "/admin/dashboard";
               } elseif ($value['role'] == 2) {
                   echo "/teacher/dashboard";
               } else {
                   echo "/exam";
               }
            }
         }else{
            echo "error";
            exit();
         }
      }
   }

   public function getUserPData($userId, $data){
      $name     = isset($data['name']) ? $this->fm->validation($data['name']) : '';
      $userName = isset($data['userName']) ? $this->fm->validation($data['userName']) : '';
      $email    = isset($data['email']) ? $this->fm->validation($data['email']) : '';
      
      // New Fields
      $phone    = isset($data['phone']) ? $this->fm->validation($data['phone']) : '';
      $gender   = isset($data['gender']) ? $this->fm->validation($data['gender']) : '';
      $dob      = isset($data['dob']) ? $this->fm->validation($data['dob']) : '';
      $address  = isset($data['address']) ? $this->fm->validation($data['address']) : '';
      $bio      = isset($data['bio']) ? $this->fm->validation($data['bio']) : '';

      $name     = mysqli_real_escape_string($this->db->link, $name);
      $userName = mysqli_real_escape_string($this->db->link, $userName);
      $email    = mysqli_real_escape_string($this->db->link, $email);
      $phone    = mysqli_real_escape_string($this->db->link, $phone);
      $gender   = mysqli_real_escape_string($this->db->link, $gender);
      $dob      = mysqli_real_escape_string($this->db->link, $dob);
      $address  = mysqli_real_escape_string($this->db->link, $address);
      $bio      = mysqli_real_escape_string($this->db->link, $bio);
      $institution = isset($data['institution']) ? mysqli_real_escape_string($this->db->link, $this->fm->validation($data['institution'])) : '';
      $institution_id = isset($data['institution_id']) ? mysqli_real_escape_string($this->db->link, $this->fm->validation($data['institution_id'])) : '';

      // Auto-Migration Check (Prototype Only)
      $check = $this->db->select("SHOW COLUMNS FROM tbl_user LIKE 'phone'");
      if(!$check) {
          $this->db->update("ALTER TABLE tbl_user ADD phone VARCHAR(20) DEFAULT NULL");
          $this->db->update("ALTER TABLE tbl_user ADD dob DATE DEFAULT NULL");
          $this->db->update("ALTER TABLE tbl_user ADD bio TEXT DEFAULT NULL");
          $this->db->update("ALTER TABLE tbl_user ADD gender VARCHAR(10) DEFAULT NULL");
          $this->db->update("ALTER TABLE tbl_user ADD address TEXT DEFAULT NULL");
      }
      $checkInst = $this->db->select("SHOW COLUMNS FROM tbl_user LIKE 'institution'");
      if(!$checkInst) {
          $this->db->update("ALTER TABLE tbl_user ADD institution VARCHAR(255) DEFAULT NULL");
      }
      $checkID = $this->db->select("SHOW COLUMNS FROM tbl_user LIKE 'institution_id'");
      if(!$checkID) {
          $this->db->update("ALTER TABLE tbl_user ADD institution_id VARCHAR(100) DEFAULT NULL");
      }

             $query = "UPDATE tbl_user 
                SET
                name     = '$name',
                userName = '$userName',
                email    = '$email',
                phone    = '$phone',
                gender   = '$gender',
                dob      = '$dob',
                address  = '$address',
                institution = '$institution',
                institution_id = '$institution_id',
                bio      = '$bio'
                WHERE 
                userId   = '$userId'";
         $result = $this->db->update($query);
         if ($result) {
            $msg = "<div class='alert alert-success'>
  <strong>Done!</strong> Profile updated successfully!
  <button type='button' class='close' onclick='this.parentElement.remove()'>&times;</button>
</div>";
         return $msg;
         }else{
            $msg =  "<div class='alert alert-warning'>
  <strong>Note:</strong> No changes made.
  <button type='button' class='close' onclick='this.parentElement.remove()'>&times;</button>
</div>";
            return $msg;
         }
      }
   
      public function getUserData(){
        $query  = "SELECT * FROM tbl_user ORDER BY userId DESC";
        $result = $this->db->select($query);
        return $result;    
      }

      public function  disableUser($userId){
            $update = "UPDATE tbl_user SET status = '1' WHERE userId = '$userId'";
            $result = $this->db->update($update);
            if ($result) {
                  $msg = "<span class='success'>Data Disable Successfuly!</span>";
               return $msg;   
            }else{
                  $msg = "<span class='error'>Data Not Disable! </span>";
                  return $msg;
            }
            
      }

      public function enaUser($userId){
            $update = "UPDATE tbl_user SET status = '0' WHERE userId = '$userId'";
            $result = $this->db->update($update);
            if ($result) {
                  $msg = "<span class='success'>Data Enable Successfuly!</span>";
               return $msg;   
            }else{
                  $msg = "<span class='error'>Data Not Enable! </span>";
                  return $msg;
            }
      }

      public function delUser($userId){
            $delete = "DELETE FROM tbl_user WHERE userId = '$userId'";
            $result = $this->db->delete($delete);
            if ($result) {
                  $msg = "<div class=\"alert alert-success alert-dismissible fade show\" role=\"alert\">
  <strong>All right!</strong> Data was deleted successfully
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
    <span aria-hidden=\"true\">&times;</span>
  </button>
</div>";
                  return $msg;
            }else{
                  $msg = "<div class=\"alert alert-danger alert-dismissible fade show\" role=\"alert\">
  <strong>All right!</strong> Data was not deleted
  <button type=\"button\" class=\"close\" data-dismiss=\"alert\" aria-label=\"Close\">
    <span aria-hidden=\"true\">&times;</span>
  </button>
</div>";
                  return $msg;
            }
      }
      

      public function toggleRole($userId){
            $query = "SELECT role FROM tbl_user WHERE userId = '$userId'";
            $result = $this->db->select($query);
            if ($result) {
                $row = $result->fetch_assoc();
                $newRole = ($row['role'] == 1) ? 0 : 1;
                $update = "UPDATE tbl_user SET role = '$newRole' WHERE userId = '$userId'";
                $this->db->update($update);
                return "<span class='success'>Role Updated Successfully!</span>";
            }
            return "<span class='error'>User Not Found!</span>";
      }

      public function updateRole($userId, $role){
            $userId = (int)$userId;
            $role = (int)$role; // 0: User, 1: Admin, 2: Teacher
            $update = "UPDATE tbl_user SET role = '$role' WHERE userId = '$userId'";
            $this->db->update($update);
            return "<span class='success'>Role Updated Successfully!</span>";
      }
          
      public function setResetToken($email, $token) {
        $email = $this->fm->validation($email);
        $email = mysqli_real_escape_string($this->db->link, $email);
        
        $check = "SELECT * FROM tbl_user WHERE email = '$email'";
        $res = $this->db->select($check);
        if ($res) {
            $query = "UPDATE tbl_user SET reset_token = '$token' WHERE email = '$email'";
            return $this->db->update($query);
        }
        return false;
      }
    
      public function verifyToken($token) {
        $token = mysqli_real_escape_string($this->db->link, $token);
        $query = "SELECT * FROM tbl_user WHERE reset_token = '$token'";
        return $this->db->select($query);
      }
    
      public function resetPassword($token, $password) {
        $token = mysqli_real_escape_string($this->db->link, $token);
        $password = mysqli_real_escape_string($this->db->link, $password);
        // Using MD5 to match existing hash method
        $query = "UPDATE tbl_user SET password = MD5('$password'), reset_token = NULL WHERE reset_token = '$token'";
        return $this->db->update($query);
      }

      public function getUserProfile($userId){
         $query = "SELECT * FROM tbl_user WHERE userId = '$userId'";
         $result = $this->db->select($query);
         return $result;
      }
      public function updateUserImage($userId, $file){
          $permited  = array('jpg', 'jpeg', 'png', 'gif');
          $file_name = $file['image']['name'];
          $file_size = $file['image']['size'];
          $file_temp = $file['image']['tmp_name'];

          $div = explode('.', $file_name);
          $file_ext = strtolower(end($div));
          $unique_image = substr(md5(time()), 0, 10).'.'.$file_ext;
          
          // Ensure directory exists
          $upload_dir = "img/avatars/";
          if (!is_dir(__DIR__ . "/../../public/" . $upload_dir)) {
              mkdir(__DIR__ . "/../../public/" . $upload_dir, 0777, true);
          }
          
          $uploaded_image = $upload_dir.$unique_image;
          $target_path = __DIR__ . "/../../public/" . $uploaded_image;

          if (empty($file_name)) {
             return "<span class='error'>Please Select any Image !</span>";
          } elseif ($file_size > 1048576) {
             return "<span class='error'>Image Size should be less then 1MB!</span>";
          } elseif (in_array($file_ext, $permited) === false) {
             return "<span class='error'>You can upload only:-".implode(', ', $permited)."</span>";
          } else {
             move_uploaded_file($file_temp, $target_path);
             
             // Update DB
             // Try adding column if not exists (Hack for migration)
             $checkCol = $this->db->select("SHOW COLUMNS FROM tbl_user LIKE 'image'");
             if (!$checkCol) {
                 $this->db->update("ALTER TABLE tbl_user ADD image VARCHAR(255) DEFAULT NULL");
             }

             $query = "UPDATE tbl_user SET image = '/$uploaded_image' WHERE userId = '$userId'";
             $updated_row = $this->db->update($query);
             // Always update session even if query returns 0 (e.g. same value) but here it's new file
             Session::set("image", "/$uploaded_image"); 
             return "<div class='alert alert-success'>Image Updated Successfully! <button type='button' class='close' onclick='this.parentElement.remove()'>&times;</button></div>";
          }
      }
      public function getAttempts($userId, $limit = 20, $offset = 0, $search = '') {
          $search = mysqli_real_escape_string($this->db->link, $search);
          $limit = (int)$limit;
          $offset = (int)$offset;
          
          $condition = "a.userId = '$userId'";
          if (!empty($search)) {
              $condition .= " AND e.name LIKE '%$search%'";
          }
          
          $query = "SELECT a.*, e.name as exam_name, e.time_limit as exam_time 
                    FROM tbl_attempts a 
                    LEFT JOIN tbl_exam e ON a.examId = e.id 
                    WHERE $condition 
                    ORDER BY a.attempt_date DESC
                    LIMIT $limit OFFSET $offset";
          return $this->db->select($query);
      }
      
      public function getTotalAttempts($userId, $search = '') {
          $search = mysqli_real_escape_string($this->db->link, $search);
          $condition = "a.userId = '$userId'";
          if (!empty($search)) {
              $condition .= " AND e.name LIKE '%$search%'";
          }
           
          $query = "SELECT count(*) as cnt 
                    FROM tbl_attempts a 
                    LEFT JOIN tbl_exam e ON a.examId = e.id 
                    WHERE $condition";
          $res = $this->db->select($query);
          if ($res) {
              $row = $res->fetch_assoc();
              return $row['cnt'];
          }
          return 0;
      }

      public function getAllAttempts($limit = 50) {
    $query = "SELECT a.*, u.name as user_name, e.name as exam_name 
              FROM tbl_attempts a
              LEFT JOIN tbl_user u ON a.userId = u.userId
              LEFT JOIN tbl_exam e ON a.examId = e.id
              ORDER BY a.attempt_date DESC LIMIT $limit";
    return $this->db->select($query);
}

public function getAttemptById($id) {
    $id = (int)$id;
    $query = "SELECT a.*, u.name as user_name, u.email, e.name as exam_name 
              FROM tbl_attempts a
              LEFT JOIN tbl_user u ON a.userId = u.userId
              LEFT JOIN tbl_exam e ON a.examId = e.id
              WHERE a.id = '$id'";
    $res = $this->db->select($query);
    return $res ? $res->fetch_assoc() : null;
}

public function getUserAnswers($attemptId) {
    // Check if table exists first to avoid error on old schema
    $chk = $this->db->select("SHOW TABLES LIKE 'tbl_user_ans'");
    if (!$chk || $chk->num_rows == 0) {
        return [];
    }

    $attemptId = (int)$attemptId;
    $query = "SELECT * FROM tbl_user_ans WHERE attempt_id = '$attemptId'";
    $res = $this->db->select($query);
    $data = [];
    if ($res) {
        while($row = $res->fetch_assoc()) {
            $data[$row['question_no']] = $row['selected_ans_id'];
        }
    }
    return $data;
}

      public function getAnalytics($examId = null) {
    $stats = [
        'avg_score' => 0,
        'total_attempts' => 0,
        'pass_rate' => 0,
        'top_student' => 'N/A',
        'top_student_score' => 0
    ];

    $whereClause = "WHERE total > 0";
    if ($examId) {
        $examId = (int)$examId;
        $whereClause .= " AND examId = '$examId'";
    }

    // 1. Total Attempts & Avg Score
    $q1 = "SELECT COUNT(*) as total, AVG((score/total)*100) as avg_pct FROM tbl_attempts $whereClause";
    $r1 = $this->db->select($q1);
    if ($r1) {
        $d1 = $r1->fetch_assoc();
        $stats['total_attempts'] = $d1['total'] ?? 0;
        $stats['avg_score'] = round($d1['avg_pct'] ?? 0, 1);
    }

    // 2. Pass Rate (Assuming 50% is pass)
    if ($stats['total_attempts'] > 0) {
        $q2 = "SELECT COUNT(*) as passed FROM tbl_attempts $whereClause AND (score/total)*100 >= 50";
        $r2 = $this->db->select($q2);
        $passed = ($r2) ? $r2->fetch_assoc()['passed'] : 0;
        $stats['pass_rate'] = round(($passed / $stats['total_attempts']) * 100, 1);
    }

    // 3. Top Performer
    $q3 = "SELECT u.name, AVG((a.score/a.total)*100) as user_avg 
           FROM tbl_attempts a 
           JOIN tbl_user u ON a.userId = u.userId 
           $whereClause
           GROUP BY a.userId 
           ORDER BY user_avg DESC LIMIT 1";
    $r3 = $this->db->select($q3);
    if ($r3) {
        $d3 = $r3->fetch_assoc();
        $stats['top_student'] = $d3['name'];
        $stats['top_student_score'] = round($d3['user_avg'], 1);
    }

    return $stats;
}

public function getChartData($examId = null) {
    $data = [
        'score_dist' => [0, 0, 0, 0], // <40, 40-60, 60-80, 80+
        'difficult_topics' => []
    ];

    $whereClause = "WHERE total > 0";
    if ($examId) {
        $examId = (int)$examId;
        $whereClause .= " AND examId = '$examId'";
    }

    // 1. Score Distribution
    $q1 = "SELECT 
            SUM(CASE WHEN (score/total*100) < 40 THEN 1 ELSE 0 END) as range1,
            SUM(CASE WHEN (score/total*100) >= 40 AND (score/total*100) < 60 THEN 1 ELSE 0 END) as range2,
            SUM(CASE WHEN (score/total*100) >= 60 AND (score/total*100) < 80 THEN 1 ELSE 0 END) as range3,
            SUM(CASE WHEN (score/total*100) >= 80 THEN 1 ELSE 0 END) as range4
           FROM tbl_attempts $whereClause";
    $r1 = $this->db->select($q1);
    if ($r1) {
        $d1 = $r1->fetch_assoc();
        $data['score_dist'] = [
            (int)($d1['range1'] ?? 0), 
            (int)($d1['range2'] ?? 0), 
            (int)($d1['range3'] ?? 0), 
            (int)($d1['range4'] ?? 0)
        ];
    }

    // 2. Difficult Exams (Only useful if NO Global Exam is selected, otherwise it shows just that one)
    // If specific exam selected, show nothing or maybe breakdown by question topic later (not implemented)
    // For now, keep showing global comparison or just that exam
    
    $whereClause2 = "WHERE a.total > 0";
    if ($examId) {
         // If filtering by one exam, maybe show top students instead?
         // For consistency, let's just keep the global difficult view or filter it
         // Actually, if we filter by examId, we only get 1 result group by examId.
         $whereClause2 .= " AND a.examId = '$examId'";
    }

    $q2 = "SELECT e.name, AVG((a.score/a.total)*100) as avg_score 
           FROM tbl_attempts a 
           JOIN tbl_exam e ON a.examId = e.id 
           $whereClause2
           GROUP BY a.examId 
           ORDER BY avg_score ASC LIMIT 5";
    $r2 = $this->db->select($q2);
    if ($r2) {
        while($row = $r2->fetch_assoc()) {
            $data['difficult_topics'][] = [
                'name' => $row['name'],
                'score' => round($row['avg_score'], 1)
            ];
        }
    }

    return $data;
}

    public function getMonitoringStats() {
        $stats = [
            'active_students' => 0,
            'active_exams' => 0,
            'alerts' => 0,
            'recent_activity' => []
        ];

        // 1. Active Students (Enabled Accounts)
        $r1 = $this->db->select("SELECT COUNT(*) as cnt FROM tbl_user WHERE role = '0' AND status = '0'");
        if ($r1) $stats['active_students'] = $r1->fetch_assoc()['cnt'];

        // 2. Active Exams (Status 1)
        // Ideally checking schedule too, but simplified to Enabled exams
        $r2 = $this->db->select("SELECT COUNT(*) as cnt FROM tbl_exam WHERE status = '1'");
        if ($r2) $stats['active_exams'] = $r2->fetch_assoc()['cnt'];

        // 3. Alerts (Mock for now, or check failed login attempts?)
        // Let's keep 0.
        
        // 4. Recent Activity (Last 5 attempts)
        $q4 = "SELECT u.name as student_name, e.name as exam_name, a.score, a.total, a.attempt_date 
               FROM tbl_attempts a 
               JOIN tbl_user u ON a.userId = u.userId 
               JOIN tbl_exam e ON a.examId = e.id 
               ORDER BY a.attempt_date DESC LIMIT 5";
        $r4 = $this->db->select($q4);
        if ($r4) {
            while($row = $r4->fetch_assoc()) {
                $stats['recent_activity'][] = $row;
            }
        }

        return $stats;
    }

    public function importStudentsFromCsv($file) {
        $fname = $file['name'];
        $chkExt = explode(".", $fname);
        if(strtolower(end($chkExt)) != "csv"){
             return "<div class='alert alert-danger'>Invalid file! Please upload a valid CSV file.</div>";
        }

        $handle = fopen($file['tmp_name'], "r");
        if (!$handle) return "<div class='alert alert-danger'>Could not open file.</div>";

        $count = 0;
        $skipped = 0;
        
        // Scan for headers
        $headers = fgetcsv($handle, 1000, ",");
        $map = ['name' => -1, 'email' => -1, 'institution' => -1, 'id' => -1];
        
        // Map headers to column indices (case insensitive)
        foreach ($headers as $index => $col) {
            $c = strtolower(trim($col));
            if (strpos($c, 'name') !== false) $map['name'] = $index;
            return "<div class='alert alert-danger'>Invalid file type. Please upload a CSV file.</div>";
        }
        
        $filename = $file['tmp_name'];
        $handle = fopen($filename, "r");
        
        $successCount = 0;
        $failCount = 0;
        
        while(($data = fgetcsv($handle, 1000, ",")) !== FALSE){
            // Skip Header if present (simple checks)
            if(strtolower($data[0]) == 'name' && strtolower($data[1]) == 'email') continue;
            
            $name = $data[0] ?? '';
            $email = $data[1] ?? '';
            $institution = $data[2] ?? '';
            $institution_id = $data[3] ?? '';
            
            if($name != '' && $email != ''){
                // Use Institution ID as default password if available, else '123456'
                $defaultPass = !empty($institution_id) ? $institution_id : '123456';
                
                $regData = [
                    'name' => $name,
                    'username' => explode('@', $email)[0] . rand(10,99),
                    'email' => $email,
                    'password' => $defaultPass,
                    'institution' => $institution,
                    'institution_id' => $institution_id
                ];
                
                // Reuse existing registration logic but suppress formatted output
                // Better to just insert directly or internal method, but for speed reuse:
                // Check email exist
                $chk = $this->db->select("SELECT * FROM tbl_user WHERE email = '$email'");
                if(!$chk){
                    // Insert
                     $name = mysqli_real_escape_string($this->db->link, $regData['name']);
                     $username = mysqli_real_escape_string($this->db->link, $regData['username']);
                     $email = mysqli_real_escape_string($this->db->link, $regData['email']);
                     $password = mysqli_real_escape_string($this->db->link, md5($regData['password']));
                     $institution = mysqli_real_escape_string($this->db->link, $regData['institution']);
                     $institution_id = mysqli_real_escape_string($this->db->link, $regData['institution_id']);
                     
                     $q = "INSERT INTO tbl_user(name, userName, password, email, role, status, institution, institution_id) 
                           VALUES('$name', '$username', '$password', '$email', '0', '0', '$institution', '$institution_id')";
                     $ins = $this->db->insert($q);
                     if($ins) $successCount++;
                     else $failCount++;
                } else {
                    $failCount++; // Duplicate
                }
            }
        }
        fclose($handle);
        return "<div class='alert alert-success'>Bulk Import Complete! Registered: $successCount, Skipped/Failed: $failCount. <br>Default Password: Registration ID</div>";
    }

    public function getAttemptsByExam($examId) {
        // Auto Migration for Institution columns (just in case)
        $chk = $this->db->select("SHOW COLUMNS FROM tbl_user LIKE 'institution'");
        if(!$chk || $chk->num_rows == 0){
             $this->db->update("ALTER TABLE tbl_user ADD COLUMN institution VARCHAR(255) DEFAULT NULL");
        }
        $chk2 = $this->db->select("SHOW COLUMNS FROM tbl_user LIKE 'institution_id'");
        if(!$chk2 || $chk2->num_rows == 0){
             $this->db->update("ALTER TABLE tbl_user ADD COLUMN institution_id VARCHAR(50) DEFAULT NULL");
        }

        $examId = (int)$examId;
        $query = "SELECT a.*, u.name, u.userName, u.institution, u.institution_id 
                  FROM tbl_attempts a 
                  JOIN tbl_user u ON a.userId = u.userId 
                  WHERE a.examId = '$examId' 
                  ORDER BY a.attempt_date DESC";
        return $this->db->select($query);
    }
 }
