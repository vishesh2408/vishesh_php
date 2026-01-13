<?php 
namespace App\Models;

use App\Database\Database;
use App\Helpers\Format;

class Group {
    private $db;
    private $fm;

    public function __construct(){
        $this->db = new Database();
        $this->fm = new Format();
        $this->initTables();
    }

    private function initTables() {
        // Create Groups Table
        $chk = $this->db->select("SHOW TABLES LIKE 'tbl_groups'");
        if (!$chk || $chk->num_rows == 0) {
            $sql = "CREATE TABLE tbl_groups (
                id INT(11) AUTO_INCREMENT PRIMARY KEY,
                name VARCHAR(255) NOT NULL,
                description TEXT,
                created_by INT(11) NOT NULL,
                created_at DATETIME DEFAULT CURRENT_TIMESTAMP
            )";
            $this->db->update($sql);
        }

        // Create Group Members Table
        $chk2 = $this->db->select("SHOW TABLES LIKE 'tbl_group_members'");
        if (!$chk2 || $chk2->num_rows == 0) {
            $sql = "CREATE TABLE tbl_group_members (
                id INT(11) AUTO_INCREMENT PRIMARY KEY,
                group_id INT(11) NOT NULL,
                user_id INT(11) NOT NULL,
                joined_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                UNIQUE KEY unique_member (group_id, user_id)
            )";
            $this->db->update($sql);
        }
    }

    public function createGroup($data, $creatorId) {
        $name = mysqli_real_escape_string($this->db->link, $data['group_name']);
        $desc = mysqli_real_escape_string($this->db->link, $data['description']);
        
        if (empty($name)) return "<div class='alert alert-danger'>Group Name is required!</div>";

        $query = "INSERT INTO tbl_groups(name, description, created_by) VALUES('$name', '$desc', '$creatorId')";
        $inserted = $this->db->insert($query);
        if ($inserted) return "<div class='alert alert-success'>Group Created Successfully!</div>";
        return "<div class='alert alert-danger'>Error creating group.</div>";
    }

    public function getGroups($creatorId = null) {
        // If creatorId is null, maybe admin view seeing all? For now restrict or show all.
        // Let's show all for simplicity or filter if needed.
        $query = "SELECT * FROM tbl_groups ORDER BY id DESC";
        return $this->db->select($query);
    }

    public function deleteGroup($id) {
        $id = (int)$id;
        $this->db->delete("DELETE FROM tbl_group_members WHERE group_id = '$id'");
        $del = $this->db->delete("DELETE FROM tbl_groups WHERE id = '$id'");
        if ($del) {
             return "<div class='alert alert-success'>Group Deleted Successfully!</div>";
        } else {
             return "<div class='alert alert-danger'>Error deleting group.</div>";
        }
    }
    
    public function updateGroup($id, $data) {
        $id = (int)$id;
        $name = mysqli_real_escape_string($this->db->link, $data['group_name']);
        $desc = mysqli_real_escape_string($this->db->link, $data['description']);
        
        $query = "UPDATE tbl_groups SET name='$name', description='$desc' WHERE id='$id'";
        $updated = $this->db->update($query);
        if ($updated) return "<div class='alert alert-success'>Group Updated Successfully!</div>";
        return "<div class='alert alert-danger'>Error updating group.</div>";
    }
    
    public function getGroupById($id) {
        $query = "SELECT * FROM tbl_groups WHERE id = '$id'";
        $res = $this->db->select($query);
        return $res ? $res->fetch_assoc() : null;
    }

    public function addMember($groupId, $userId) {
        $groupId = (int)$groupId;
        $userId = (int)$userId;
        // Check if exists
        $chk = $this->db->select("SELECT * FROM tbl_group_members WHERE group_id='$groupId' AND user_id='$userId'");
        if ($chk) return false; // Already added

        $query = "INSERT INTO tbl_group_members(group_id, user_id) VALUES('$groupId', '$userId')";
        return $this->db->insert($query);
    }

    public function removeMember($groupId, $userId) {
        $groupId = (int)$groupId;
        $userId = (int)$userId;
        $query = "DELETE FROM tbl_group_members WHERE group_id='$groupId' AND user_id='$userId'";
        return $this->db->delete($query);
    }

    public function getMembers($groupId) {
        $query = "SELECT u.* FROM tbl_user u 
                  JOIN tbl_group_members gm ON u.userId = gm.user_id 
                  WHERE gm.group_id = '$groupId'";
        return $this->db->select($query);
    }

    // Helper to get available students (not in group)
    // In a real app, this would need search/pagination
    public function getAvailableStudents($groupId) {
        $query = "SELECT * FROM tbl_user WHERE role = '0' AND userId NOT IN (SELECT user_id FROM tbl_group_members WHERE group_id = '$groupId')";
        return $this->db->select($query);
    }

    public function importMembersFromCsv($groupId, $file) {
        $fname = $file['name'];
        $chkExt = explode(".", $fname);
        if(strtolower(end($chkExt)) != "csv"){
             return "<div class='alert alert-danger'>Invalid file! Please upload a valid CSV file.</div>";
        }

        $handle = fopen($file['tmp_name'], "r");
        if (!$handle) return "<div class='alert alert-danger'>Could not open file.</div>";

        $count = 0;
        $notFound = 0;
        $alreadyIn = 0;

        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            // Logic: Scan row for the first valid email
            $email = null;
            foreach ($row as $col) {
                if (filter_var($col, FILTER_VALIDATE_EMAIL)) {
                    $email = $col;
                    break;
                }
            }

            if ($email) {
                $email = mysqli_real_escape_string($this->db->link, $email);
                // Check if user exists
                $usr = $this->db->select("SELECT userId FROM tbl_user WHERE email = '$email'");
                if ($usr && $usr->num_rows > 0) {
                    $userData = $usr->fetch_assoc();
                    $userId = $userData['userId'];
                    
                    // Add to group
                    if ($this->addMember($groupId, $userId)) {
                        $count++;
                    } else {
                        $alreadyIn++;
                    }
                } else {
                    $notFound++;
                }
            }
        }
        fclose($handle);

        return "<div class='alert alert-success'>Import Complete: $count added, $alreadyIn skipped (already in group), $notFound emails not found in system.</div>";
    }
}
