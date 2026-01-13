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
if (isset($_GET['del'])) {
 	$delid = (int)$_GET['del'];
 	$deluser = $user->delUser($delid);
}
if (isset($_GET['setRole']) && isset($_GET['uid'])) {
 	$roleId = (int)$_GET['setRole'];
    $uId = (int)$_GET['uid'];
 	$roleMsg = $user->updateRole($uId, $roleId);
}
?>

<div class="admin-header">
    <h1 class="admin-title">Manage Users</h1>
</div>

<?php 
if(isset($disuser)) echo $disuser;
if(isset($enauser)) echo $enauser;
if(isset($deluser)) echo $deluser;
if(isset($roleMsg)) echo $roleMsg;
?>

<div class="table-container">
    <table class="custom-table">
        <thead>
            <tr>
                <th>No.</th>
                <th>Name</th>
                <th>Username</th>
                <th>Email</th>
                <th>Role</th>
                <th width="35%">Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $userData = $user->getUserData();
        if ($userData) {
            $i = 0;
            while ($result = $userData->fetch_assoc()) {
                $i++;
        ?>
            <tr>
                <td>
                    <?php if ($result['status'] == '1') { echo "<span style='color:red;'>$i (Disabled)</span>"; } else { echo $i; } ?>
                </td>
                <td><?php echo $result['name']; ?></td>
                <td><?php echo $result['userName']; ?></td>
                <td><?php echo $result['email']; ?></td>
                <td>
                    <?php if($result['role'] == 1) { ?>
                        <span style="color: var(--primary-color); font-weight: bold; background: rgba(99,102,241,0.1); padding: 2px 8px; border-radius: 4px;">Admin</span>
                    <?php } elseif($result['role'] == 2) { ?>
                        <span style="color: #facc15; font-weight: bold; background: rgba(250, 204, 21, 0.1); padding: 2px 8px; border-radius: 4px;">Teacher</span>
                    <?php } else { ?>
                        <span>Student</span>
                    <?php } ?>
                </td>
                <td>
                    <?php if ($result['status'] == '1') { ?>
                        <a class="action-btn btn-info" href="?ena=<?php echo $result['userId']; ?>">Enable</a>
                    <?php } else { ?>
                        <a class="action-btn btn-danger" href="?dis=<?php echo $result['userId']; ?>" style="background: #f3f4f6; color: #555;">Disable</a>
                    <?php } ?>
                    
                    <a class="action-btn btn-danger" onclick="return confirm('Delete User?')" href="?del=<?php echo $result['userId']; ?>">Remove</a>
                    
                    <div style="display: inline-block; margin-left: 10px;">
                        <?php if($result['role'] != 1) { ?>
                        <a class="action-btn btn-info" href="?setRole=1&uid=<?php echo $result['userId']; ?>" title="Valid for Admin">Make Admin</a>
                        <?php } ?>
                        
                        <?php if($result['role'] != 2) { ?>
                        <a class="action-btn btn-warning" href="?setRole=2&uid=<?php echo $result['userId']; ?>" style="background: #fef08a; color: #854d0e;">Make Teacher</a>
                        <?php } ?>
                        
                        <?php if($result['role'] != 0) { ?>
                        <a class="action-btn" href="?setRole=0&uid=<?php echo $result['userId']; ?>" style="background: #e2e8f0; color: #475569;">Make Student</a>
                        <?php } ?>
                    </div>
                </td>
            </tr>
        <?php } } ?>
        </tbody>
    </table>
</div>

</div> <!-- Close admin-wrapper -->
</body>
</html>