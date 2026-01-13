<?php 
namespace App\Models;

use App\Database\Database;
use App\Helpers\Format;

class Announcement {
	private $db;
	private $fm;

	public function __construct(){
		$this->db = new Database();
		$this->fm = new Format();
	}

    public function addAnnouncement($data, $creatorId) {
        // Auto Migration
        $chk = $this->db->select("SHOW TABLES LIKE 'tbl_announcements'");
        if (!$chk || $chk->num_rows == 0) {
            $sql = "CREATE TABLE tbl_announcements (
                id INT(11) AUTO_INCREMENT PRIMARY KEY,
                title VARCHAR(255) NOT NULL,
                message TEXT NOT NULL,
                creator_id INT(11) NOT NULL,
                target_group VARCHAR(50) DEFAULT 'all',
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )";
            $this->db->update($sql);
        }

        $title = mysqli_real_escape_string($this->db->link, $data['title']);
        $message = mysqli_real_escape_string($this->db->link, $data['message']);
        $target = isset($data['target']) ? mysqli_real_escape_string($this->db->link, $data['target']) : 'all';
        $creatorId = (int)$creatorId;

        if (empty($title) || empty($message)) {
            return "<div class='alert alert-danger'>Fields must not be empty!</div>";
        }

        $query = "INSERT INTO tbl_announcements(title, message, creator_id, target_group) 
                  VALUES('$title', '$message', '$creatorId', '$target')";
        
        $inserted = $this->db->insert($query);
        
        if ($inserted) {
            // --- Email Sending Logic ---
            $emails = [];
            
            if ($target == 'all') {
                // Fetch all students
                $eRes = $this->db->select("SELECT email FROM tbl_user WHERE role = '0' AND status = '0'");
                if ($eRes) {
                    while($r = $eRes->fetch_assoc()) $emails[] = $r['email'];
                }
            } else {
                // Fetch group members
                $groupId = (int)$target;
                // Need to join to get emails. We can replicate logic from Group model or just write query.
                // Assuming tbl_group_members exists as checked in Group model (but relying on Group model might be safer if autoloaded)
                // Let's just write the direct query since we are in Model layer
                $q = "SELECT u.email FROM tbl_user u 
                      JOIN tbl_group_members gm ON u.userId = gm.user_id 
                      WHERE gm.group_id = '$groupId' AND u.status = '0'";
                $eRes = $this->db->select($q);
                if ($eRes) {
                    while($r = $eRes->fetch_assoc()) $emails[] = $r['email'];
                }
            }
            
            // Send Emails
            $subject = "New Announcement: " . $title;
            $headers = "From: no-reply@quiznest.com\r\n";
            $headers .= "Content-Type: text/html; charset=UTF-8\r\n";
            
            $emailContent = "
            <html>
            <head>
              <title>New Announcement</title>
            </head>
            <body style='font-family: Arial, sans-serif; color: #333;'>
              <div style='background: #f8fafc; padding: 20px; border-radius: 8px;'>
                  <h2 style='color: #6366f1;'>$title</h2>
                  <p style='font-size: 16px; line-height: 1.6;'>$message</p>
                  <hr style='border: 0; border-top: 1px solid #ddd; margin: 20px 0;'>
                  <p style='font-size: 12px; color: #888;'>This is an automated message from QuizNest.</p>
              </div>
            </body>
            </html>
            ";

            $sentCount = 0;
            // Note: mail() requires a configured SMTP server (e.g., Sendmail on Linux, or SMTP in php.ini on Windows).
            // On a local dev environment (XAMPP/WAMP) without configuration, this might fail or do nothing.
            foreach ($emails as $to) {
                if(filter_var($to, FILTER_VALIDATE_EMAIL)){
                    // Suppress warning if mail server not configured
                    if(@mail($to, $subject, $emailContent, $headers)) {
                        $sentCount++;
                    }
                }
            }
            
            $msg = "<div class='alert alert-success'>Announcement Posted Successfully!</div>";
            if ($sentCount > 0) {
                 $msg .= "<div class='alert alert-info' style='margin-top:5px; font-size:0.9rem;'>Email sent to $sentCount recipients.</div>";
            } else {
                 //$msg .= "<div class='alert alert-warning' style='margin-top:5px; font-size:0.9rem;'>Announcement saved, but emails could not be sent (SMTP not configured).</div>";
            }
            return $msg;
        }
        return "<div class='alert alert-danger'>Error posting announcement.</div>";
    }

    public function getAnnouncements($limit = 10) {
        // Ensure table exists (in case get is called before add)
        $chk = $this->db->select("SHOW TABLES LIKE 'tbl_announcements'");
        if (!$chk || $chk->num_rows == 0) return false;

        $limit = (int)$limit;
        $query = "SELECT * FROM tbl_announcements ORDER BY created_at DESC LIMIT $limit";
        return $this->db->select($query);
    }
}
