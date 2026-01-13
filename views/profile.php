<?php 
use App\Lib\Session;
Session::init();
// Check core session validity
if (Session::get("login") != true) {
    header("Location: /");
    exit();
}

// Dynamic Header Inclusion
$roleId = Session::get("role");
if ($roleId == 1) {
    include __DIR__ . '/admin/partials/header.php';
} elseif ($roleId == 2) {
    include __DIR__ . '/teacher/partials/header.php';
} else {
    include __DIR__ . '/partials/header.php';
}

use App\Models\User;
use App\Models\Exam;
use App\Models\Process;
$user = new User();
$exam = new Exam();
$pro  = new Process();
$fm   = new \App\Helpers\Format();
?>
<?php
  $userId = Session::get("userId");
  
  if ($_SERVER['REQUEST_METHOD'] == 'POST') {
      if (isset($_POST['update_info'])) {
          $userProfile = $user->getUserPData($userId, $_POST);
      }
      if (isset($_FILES['image'])) {
          $imageUpdate = $user->updateUserImage($userId, $_FILES);
      }
  }
?>

<div class="main-wrapper" style="padding-top: 2rem;">
    <div class="container" style="max-width: 1200px; margin: 0 auto; display: grid; grid-template-columns: 300px 1fr; gap: 2rem;">
        
        <!-- Left Sidebar: Profile Summary -->
        <div class="profile-sidebar" style="background: #1a2335; border-radius: 16px; padding: 2rem; height: fit-content; text-align: center; border: 1px solid rgba(255,255,255,0.05);">
            <!-- Image Upload Section moved here -->
            <div style="position: relative; width: 150px; height: 150px; margin: 0 auto 1.5rem;">
                <?php 
                    $img = Session::get("image");
                    $displayImg = ($img && $img != '') ? $img : null;
                    $initial = strtoupper(substr(Session::get("name"), 0, 1));
                ?>
                <div style="width: 100%; height: 100%; border-radius: 50%; overflow: hidden; background: #334155; display: flex; align-items: center; justify-content: center; border: 4px solid var(--surface-color); box-shadow: 0 0 0 3px var(--primary-color);">
                    <?php if ($displayImg): ?>
                        <img src="<?php echo $displayImg; ?>" style="width: 100%; height: 100%; object-fit: cover;" alt="Profile">
                    <?php else: ?>
                        <span style="font-size: 4rem; color: #fff; font-weight: bold;"><?php echo $initial; ?></span>
                    <?php endif; ?>
                </div>
                <form action="" method="post" enctype="multipart/form-data" id="avatarForm">
                    <label for="file-upload" style="position: absolute; bottom: 0; right: 0; background: var(--primary-color); width: 40px; height: 40px; border-radius: 50%; display: flex; align-items: center; justify-content: center; cursor: pointer; box-shadow: 0 4px 6px rgba(0,0,0,0.3);">
                        📷
                    </label>
                    <input id="file-upload" type="file" name="image" style="display: none;" onchange="document.getElementById('avatarForm').submit()">
                </form>
            </div>
            
            <h3 style="color: #f8fafc; margin-bottom: 0.5rem;"><?php echo Session::get("name"); ?></h3>
            <p style="color: #94a3b8; font-size: 0.9rem; margin-bottom: 2rem;">@<?php echo Session::get("userName"); ?></p>
            
            <div class="sidebar-menu" style="text-align: left;">
                <a href="#" class="btn btn-block" style="background: rgba(255,255,255,0.05); margin-bottom: 0.5rem; text-align: left; padding-left: 1.5rem;">👤 Personal Details</a>
                <a href="#" class="btn btn-block" style="background: transparent; color: #94a3b8; margin-bottom: 0.5rem; text-align: left; padding-left: 1.5rem;">🔒 Security</a>
                <a href="#" class="btn btn-block" style="background: transparent; color: #94a3b8; margin-bottom: 0.5rem; text-align: left; padding-left: 1.5rem;">🔔 Notifications</a>
            </div>
        </div>

        <!-- Right Content: Edit Form -->
        <div class="profile-content">
            
            <div class="card" style="background: #1a2335; border-radius: 16px; padding: 2.5rem; border: 1px solid rgba(255,255,255,0.05);">
                <div style="margin-bottom: 2rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem;">
                    <h2 style="color: #f8fafc; margin-bottom: 0.5rem;">Edit Profile</h2>
                    <p style="color: #94a3b8; font-size: 0.95rem;">Update your personal information and settings</p>
                </div>
                
                <div class="toast-wrapper">
                <?php
                if (isset($userProfile)) { echo $userProfile; }
                if (isset($imageUpdate)) { echo $imageUpdate; }
                ?>
                </div>

                <form action="" method="post">
                    <input type="hidden" name="update_info" value="1">
                    <?php
                    $getData = $user->getUserProfile($userId);
                    if ($getData) {
                        while ($result = $getData->fetch_assoc()) {
                    ?>
                    
                    <h4 style="color: #818cf8; margin-bottom: 1.5rem;">Basic Information</h4>
                    <div class="row" style="display: flex; gap: 1.5rem; flex-wrap: wrap; margin-bottom: 1.5rem;">
                        <input type="hidden" name="ignore_me" value="for_layout_spacing">


            <div class="row" style="display: flex; gap: 1rem; flex-wrap: wrap;">
                 <div class="col-md-6" style="flex: 1; min-width: 250px;">
                    <div class="form-group">
                        <label class="form-label">Email Address</label>
                        <input class="form-control" type="email" name="email" value="<?php echo $result['email']; ?>" required>
                    </div>
                 </div>
                 <div class="col-md-6" style="flex: 1; min-width: 250px;">
                    <div class="form-group">
                        <label class="form-label">Phone Number</label>
                        <input class="form-control" type="text" name="phone" value="<?php echo isset($result['phone']) ? $result['phone'] : ''; ?>" placeholder="+1234567890">
                    </div>
                 </div>
            </div>

            <div class="row" style="display: flex; gap: 1rem; flex-wrap: wrap;">
                 <div class="col-md-6" style="flex: 1; min-width: 250px;">
                    <div class="form-group">
                        <label class="form-label">Institution / University</label>
                        <input class="form-control" type="text" name="institution" value="<?php echo isset($result['institution']) ? $result['institution'] : ''; ?>" placeholder="e.g. MIT, Stanford, etc.">
                    </div>
                 </div>
                 <div class="col-md-6" style="flex: 1; min-width: 250px;">
                    <div class="form-group">
                        <label class="form-label">Roll No. / Student ID</label>
                        <input class="form-control" type="text" name="institution_id" value="<?php echo isset($result['institution_id']) ? $result['institution_id'] : ''; ?>" placeholder="e.g. 2024001">
                    </div>
                 </div>
            </div>

            <div class="row" style="display: flex; gap: 1rem; flex-wrap: wrap;">
                 <div class="col-md-6" style="flex: 1; min-width: 250px;">
                    <div class="form-group">
                        <label class="form-label">Date of Birth</label>
                        <input class="form-control" type="date" name="dob" value="<?php echo isset($result['dob']) ? $result['dob'] : ''; ?>">
                    </div>
                 </div>
                 <div class="col-md-6" style="flex: 1; min-width: 250px;">
                    <div class="form-group">
                        <label class="form-label">Gender</label>
                        <select class="form-control" name="gender">
                            <option value="">Select Gender</option>
                            <option value="Male" <?php if(isset($result['gender']) && $result['gender'] == 'Male') echo 'selected'; ?>>Male</option>
                            <option value="Female" <?php if(isset($result['gender']) && $result['gender'] == 'Female') echo 'selected'; ?>>Female</option>
                            <option value="Other" <?php if(isset($result['gender']) && $result['gender'] == 'Other') echo 'selected'; ?>>Other</option>
                        </select>
                    </div>
                 </div>
            </div>
            
            <div class="form-group">
                <label class="form-label">Address</label>
                <textarea class="form-control" name="address" rows="2" placeholder="Street Address, City, Country"><?php echo isset($result['address']) ? $result['address'] : ''; ?></textarea>
            </div>

            <div class="form-group">
                <label class="form-label">Bio / About Me</label>
                <textarea class="form-control" name="bio" rows="3" placeholder="Tell us a little about yourself..."><?php echo isset($result['bio']) ? $result['bio'] : ''; ?></textarea>
            </div>

            <div style="margin-top: 2rem;">
                 <input type="submit" class="btn btn-primary" value="Update Info">
            </div>
            
             <div style="text-align: center; margin-top: 1rem;">
                <a href="exam" class="btn btn-outline" style="display:inline-block; width:auto; padding: 0.5rem 1.5rem; font-size: 0.9rem;">Cancel</a>
            </div>
            <?php } } ?>
        </form>
        </div> <!-- End Edit Card -->

    </div>

     <!-- Attempt History Section -->
     <div class="container" style="max-width: 1200px; margin: 0 auto; padding-top: 3rem; padding-bottom: 3rem;">
        <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem; flex-wrap: wrap; gap: 1rem;">
             <h3 style="color: #f8fafc; margin: 0;">Recent Exam Attempts</h3>
             
             <!-- Search Form -->
             <form action="" method="get" style="display: flex; gap: 0.5rem;">
                 <input type="text" name="search" placeholder="Search by exam name..." value="<?php echo isset($_GET['search']) ? htmlspecialchars($_GET['search']) : ''; ?>" 
                        style="padding: 0.7rem 1rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); background: #1a2335; color: #fff; width: 250px;">
                 <button type="submit" class="btn btn-primary" style="padding: 0.7rem 1.2rem;">Search</button>
                 <?php if(isset($_GET['search']) && !empty($_GET['search'])) { ?>
                    <a href="profile" class="btn btn-outline" style="padding: 0.7rem 1rem;">Clear</a>
                 <?php } ?>
             </form>
        </div>

        <?php
        $page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
        $search = isset($_GET['search']) ? $_GET['search'] : '';
        $limit = 20;
        $offset = ($page - 1) * $limit;
        
        $attempts = $user->getAttempts($userId, $limit, $offset, $search);
        $totalAttempts = $user->getTotalAttempts($userId, $search);
        $totalPages = ceil($totalAttempts / $limit);
        ?>
             
        <div style="display: grid; grid-template-columns: repeat(auto-fill, minmax(300px, 1fr)); gap: 1.5rem;">
             <?php 
             if ($attempts && $attempts->num_rows > 0) {
                 while ($row = $attempts->fetch_assoc()) {
             ?>
             <div class="attempt-card" style="background: #1a2335; padding: 1.5rem; border-radius: 16px; border: 1px solid rgba(255,255,255,0.05); box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06); display: flex; flex-direction: column; gap: 1rem; transition: transform 0.2s ease, box-shadow 0.2s ease;" onmouseover="this.style.transform='translateY(-4px)'; this.style.boxShadow='0 10px 15px -3px rgba(0, 0, 0, 0.3)';" onmouseout="this.style.transform='translateY(0)'; this.style.boxShadow='0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06)';">
                 <div style="border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.75rem; display: flex; justify-content: space-between; align-items: flex-start;">
                     <div>
                        <h4 style="color: #f8fafc; margin: 0; font-size: 1.1rem; line-height: 1.4;"><?php echo $row['exam_name']; ?></h4>
                        <span style="font-size: 0.8rem; color: #94a3b8; display: block; margin-top: 4px;"><?php echo date('M d, Y h:i A', strtotime($row['attempt_date'])); ?></span>
                     </div>
                     <?php if($row['score'] >= 0): // Example condition for badge ?>
                     <span style="background: rgba(16, 185, 129, 0.1); color: #10b981; font-size: 0.75rem; padding: 2px 8px; border-radius: 999px; font-weight: 600;">Completed</span>
                     <?php endif; ?>
                 </div>
                 
                 <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 0.75rem; font-size: 0.9rem; background: rgba(255,255,255,0.02); padding: 1rem; border-radius: 8px;">
                     <div style="color: #94a3b8;">Total Time</div>
                     <div style="color: #f1f5f9; text-align: right; font-weight: 500;"><?php echo $row['exam_time']; ?> min</div>
                     
                     <div style="color: #94a3b8;">Time Taken</div>
                     <div style="color: #f1f5f9; text-align: right; font-weight: 500;"><?php echo $row['time_taken']; ?></div>
                     
                     <div style="color: #94a3b8;">Score</div>
                     <div style="color: #10b981; text-align: right; font-weight: 700; font-size: 1.1rem;"><?php echo $row['score']; ?></div>
                 </div>
                 
                 <div style="margin-top: auto; padding-top: 0.5rem;">
                     <a href="viewans?exam_id=<?php echo $row['examId']; ?>" class="btn btn-outline btn-block" style="text-align: center; justify-content: center; width: 100%; display: flex; align-items: center; gap: 8px;">
                        <span>View Analysis</span>
                        <svg width="16" height="16" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3" /></svg>
                     </a>
                 </div>
             </div>
             <?php 
                 }
             } else {
                 echo "<div style='background:#1a2335; padding:2rem; width:100%; border-radius:12px; text-align:center; color:#94a3b8;'>No attempts found matching your criteria.</div>";
             }
             ?>
        </div>
        
        <!-- Pagination -->
        <?php if ($totalPages > 1) { ?>
         <div style="margin-top: 3rem; display: flex; justify-content: center; gap: 0.5rem;">
             <?php 
             $urlParams = !empty($search) ? "&search=".urlencode($search) : "";
             if ($page > 1) { ?>
                <a href="?page=<?php echo $page-1 . $urlParams; ?>" class="btn btn-outline" style="padding: 0.5rem 1rem;">&laquo; Prev</a>
             <?php } ?>
             
             <?php for($i=1; $i<=$totalPages; $i++) { ?>
                <a href="?page=<?php echo $i . $urlParams; ?>" class="btn <?php echo ($i == $page) ? 'btn-primary' : 'btn-outline'; ?>" style="padding: 0.5rem 1rem;"><?php echo $i; ?></a>
             <?php } ?>
             
             <?php if ($page < $totalPages) { ?>
                 <a href="?page=<?php echo $page+1 . $urlParams; ?>" class="btn btn-outline" style="padding: 0.5rem 1rem;">Next &raquo;</a>
             <?php } ?>
         </div>
         <?php } ?>
    </div>
</div>