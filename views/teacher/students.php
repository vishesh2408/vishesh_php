<?php 
include __DIR__ . '/partials/header.php';
use App\Models\User;
$user = new User();

// Action Logic
if (isset($_GET['dis'])) {
 	$disid = (int)$_GET['dis'];
 	$disuser = $user->disableUser($disid);
}
if (isset($_GET['ena'])) {
 	$enaid = (int)$_GET['ena'];
 	$enauser = $user->enaUser($enaid);
}

// Handle CSV Import for Bulk Registration
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['import_students_csv'])) {
    if (isset($_FILES['student_csv']['name']) && $_FILES['student_csv']['name'] != '') {
        $msg = $user->importStudentsFromCsv($_FILES['student_csv']);
    } else {
        $msg = "<div class='alert alert-danger'>Please select a file.</div>";
    }
}
?>

<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 1rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 class="page-title" style="margin: 0; text-align: left;">Student Management</h1>
            <p style="color: #94a3b8; margin: 5px 0 0 0;">Manage enrolled students</p>
        </div>
        <div>
             <button onclick="document.getElementById('importStudentModal').style.display='flex'" class="btn btn-outline">
                 📂 Import CSV
             </button>
        </div>
    </div>

    <?php 
    if(isset($disuser)) echo $disuser;
    if(isset($enauser)) echo $enauser;
    if(isset($msg)) echo $msg;
    ?>

    <div class="card" style="background: #1a2335; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; color: #f8fafc;">
            <thead>
                <tr style="background: rgba(255,255,255,0.05); text-align: left;">
                    <th style="padding: 1rem; font-weight: 600;">No.</th>
                    <th style="padding: 1rem; font-weight: 600;">Name</th>
                    <th style="padding: 1rem; font-weight: 600;">Username</th>
                    <th style="padding: 1rem; font-weight: 600;">Email</th>
                    <th style="padding: 1rem; font-weight: 600;">Institution</th>
                    <th style="padding: 1rem; font-weight: 600;">Reg. ID</th>
                    <th style="padding: 1rem; font-weight: 600;">Status</th>
                    <th style="padding: 1rem; font-weight: 600;">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $userData = $user->getUserData();
            if ($userData) {
                $i = 0;
                while ($result = $userData->fetch_assoc()) {
                    // Filter out admins/teachers
                    if($result['role'] != 0) continue; 
                    
                    $i++;
                    $statusColor = $result['status'] == '1' ? '#f87171' : '#4ade80';
                    $statusText = $result['status'] == '1' ? 'Disabled' : 'Active';
            ?>
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <td style="padding: 1rem; color: #94a3b8;"><?php echo $i; ?></td>
                    <td style="padding: 1rem;">
                        <div style="display: flex; align-items: center; gap: 10px;">
                            <div style="width: 30px; height: 30px; background: rgba(99, 102, 241, 0.2); border-radius: 50%; display: flex; align-items: center; justify-content: center; color: #818cf8; font-weight: bold; font-size: 0.8rem;">
                                <?php echo strtoupper(substr($result['name'], 0, 1)); ?>
                            </div>
                            <?php echo $result['name']; ?>
                        </div>
                    </td>
                    <td style="padding: 1rem;"><?php echo $result['userName']; ?></td>
                    <td style="padding: 1rem; color: #94a3b8;"><?php echo $result['email']; ?></td>
                    <td style="padding: 1rem; color: #facc15; font-size: 0.9rem;">
                        <?php echo !empty($result['institution']) ? '🏛 '.$result['institution'] : '-'; ?>
                    </td>
                    <td style="padding: 1rem; color: #e2e8f0; font-size: 0.9rem;">
                        <?php echo !empty($result['institution_id']) ? '#'.$result['institution_id'] : '-'; ?>
                    </td>
                    <td style="padding: 1rem;">
                        <span style="color: <?php echo $statusColor; ?>; background: rgba(255,255,255,0.05); padding: 4px 10px; border-radius: 20px; font-size: 0.85rem;">
                            <?php echo $statusText; ?>
                        </span>
                    </td>
                    <td style="padding: 1rem;">
                        <?php if ($result['status'] == '1') { ?>
                            <a href="?ena=<?php echo $result['userId']; ?>" style="color: #4ade80; text-decoration: none; margin-right: 15px;">Enable</a>
                        <?php } else { ?>
                            <a href="?dis=<?php echo $result['userId']; ?>" style="color: #f87171; text-decoration: none; margin-right: 15px;">Disable</a>
                        <?php } ?>
                        <!-- <a href="#" style="color: #60a5fa; text-decoration: none;">Stats</a> -->
                    </td>
                </tr>
            <?php } } else { ?>
                <tr><td colspan="6" style="text-align:center; padding: 2rem; color: #94a3b8;">No students found.</td></tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Import Modal -->
<div id="importStudentModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: #1e293b; padding: 2rem; border-radius: 12px; width: 90%; max-width: 500px; border: 1px solid rgba(255,255,255,0.1);">
        <h3 style="color: #fff; margin-top: 0;">Bulk Register Students</h3>
        <p style="color: #94a3b8; font-size: 0.9rem;">Upload a CSV file to register multiple students at once. Duplicate emails will be skipped.<br><strong>Default Password: Registration ID</strong></p>
        <p style="color: #64748b; font-size: 0.8rem; margin-top: 0.5rem;">Format: Name, Email, Institution, Registration ID</p>
        
        <form action="" method="post" enctype="multipart/form-data" style="margin-top: 1.5rem;">
            <div style="background: rgba(0,0,0,0.2); padding: 1rem; border-radius: 8px; border: 1px dashed rgba(255,255,255,0.2); text-align: center; margin-bottom: 1.5rem;">
                <input type="file" name="student_csv" accept=".csv" required style="color: #cbd5e1;">
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                <button type="button" onclick="document.getElementById('importStudentModal').style.display='none'" class="btn btn-outline">Cancel</button>
                <button type="submit" name="import_students_csv" class="btn btn-primary">Import & Register</button>
            </div>
        </form>
    </div>
</div>

</body>
</html>
