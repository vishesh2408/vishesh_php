<?php 
include __DIR__ . '/partials/header.php';
use App\Models\Group;
use App\Models\Exam;
use App\Lib\Session;

$group = new Group();
$exam = new Exam();
$teacherId = Session::get("userId");

$exams = $exam->getExams(); // For dropdown

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['create_group'])) {
    $msg = $group->createGroup($_POST, $teacherId);
}

// Handle Delete (Simple implementation)
// Handle Delete
if (isset($_GET['del'])) {
    $msg = $group->deleteGroup($_GET['del']); 
}
// Handle Edit/Update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_group'])) {
    $msg = $group->updateGroup($_POST['group_id'], $_POST);
}
// Handle Assign Exam (Update)
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['assign_exam'])) {
    $msg = $exam->assignToGroup($_POST['exam_id'], $_POST['group_id'], $_POST['start_time'], $_POST['end_time']);
}
// Handle Disable Assignment
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['disable_exam_assignment'])) {
    $msg = $exam->disableExamAssignment($_POST['exam_id']);
}
?>

<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 1rem;">
    <div style="margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <h1 class="page-title" style="margin: 0; text-align: left;">Student Groups</h1>
            <p style="color: #94a3b8; margin: 5px 0 0 0;">Create groups for specific exams (Universities, Countries, etc.)</p>
        </div>
        <button onclick="document.getElementById('createGroupModal').style.display='flex'" class="btn btn-primary" style="width: auto;">
            + Create Group
        </button>
    </div>

    <?php if (isset($msg)) echo $msg; ?>

    <div class="card" style="background: #1a2335; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; color: #f8fafc;">
            <thead>
                <tr style="background: rgba(255,255,255,0.05); text-align: left;">
                    <th style="padding: 1rem; font-weight: 600;">Group Name</th>
                    <th style="padding: 1rem; font-weight: 600;">Description</th>
                    <th style="padding: 1rem; font-weight: 600;">Students</th>
                    <th style="padding: 1rem; font-weight: 600;">Assigned Exams</th>
                    <th style="padding: 1rem; font-weight: 600;">Created</th>
                    <th style="padding: 1rem; font-weight: 600;">Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php 
            $groups = $group->getGroups();
            if ($groups) {
                while($row = $groups->fetch_assoc()) {
                    $members = $group->getMembers($row['id']);
                    $count = $members ? $members->num_rows : 0;
                    
                    // Get assigned exams count or list
                    $assignedExams = $exam->getExamsByGroupId($row['id']);
                    $examCount = $assignedExams ? $assignedExams->num_rows : 0;
            ?>
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <td style="padding: 1rem; font-weight: 500; font-size: 1.1rem; color: #818cf8;">
                        <?php echo $row['name']; ?>
                    </td>
                    <td style="padding: 1rem; color: #94a3b8;"><?php echo $row['description']; ?></td>
                    <td style="padding: 1rem;">
                        <span style="background: rgba(255,255,255,0.1); padding: 4px 10px; border-radius: 20px; font-size: 0.85rem;">
                            <?php echo $count; ?> Students
                        </span>
                    </td>
                    <td style="padding: 1rem;">
                         <span style="background: rgba(250, 204, 21, 0.1); color: #facc15; padding: 4px 10px; border-radius: 20px; font-size: 0.85rem;">
                            <?php echo $examCount; ?> Active
                        </span>
                    </td>
                    <td style="padding: 1rem; color: #94a3b8; font-size: 0.9rem;">
                        <?php echo date('M d, Y', strtotime($row['created_at'])); ?>
                    </td>
                    <td style="padding: 1rem; display: flex; gap: 0.5rem; align-items: center;">
                        <a href="groups/manage?id=<?php echo $row['id']; ?>" class="btn btn-primary" style="padding: 0.4rem 1rem; font-size: 0.85rem; width: auto; text-decoration: none;">Manage</a>
                        <button onclick="openEditModal('<?php echo $row['id']; ?>', '<?php echo addslashes($row['name']); ?>', '<?php echo addslashes($row['description']); ?>')" class="btn btn-outline" style="padding: 0.4rem 1rem; font-size: 0.85rem; width: auto;">Edit</button>
                        <a href="?del=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this group?')" class="btn btn-outline" style="padding: 0.4rem 1rem; font-size: 0.85rem; width: auto; border-color: #ef4444; color: #ef4444;">Delete</a>
                        <a href="?manage_exams=<?php echo $row['id']; ?>" class="btn btn-outline" style="padding: 0.4rem 1rem; font-size: 0.85rem; width: auto; border-color: #facc15; color: #facc15; text-decoration: none;">Exams</a>
                    </td>
                </tr>
            <?php } } else { ?>
                <tr><td colspan="6" style="text-align: center; padding: 2rem; color: #94a3b8;">No groups found. Create one to get started!</td></tr>
            <?php } ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Create Group Modal -->
<div id="createGroupModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; justify-content: center; align-items: center;">
    <div style="background: #1a2335; width: 100%; max-width: 500px; padding: 2rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1);">
        <h2 style="color: white; margin-bottom: 1.5rem;">Create New Group</h2>
        <form action="" method="post">
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="color: #cbd5e1; display: block; margin-bottom: 0.5rem;">Group Name</label>
                <input type="text" name="group_name" placeholder="e.g. Batch 2024 - USA" class="form-control" required style="width: 100%; padding: 0.8rem; background: #0f172a; border: 1px solid #334155; color: white; border-radius: 8px;">
            </div>
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="color: #cbd5e1; display: block; margin-bottom: 0.5rem;">Description</label>
                <textarea name="description" placeholder="Optional description..." class="form-control" rows="3" style="width: 100%; padding: 0.8rem; background: #0f172a; border: 1px solid #334155; color: white; border-radius: 8px;"></textarea>
            </div>
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <a href="groups" class="btn btn-outline" style="width: auto; margin:0; text-decoration:none;">Cancel</a>
                <button type="submit" name="create_group" class="btn btn-primary" style="width: auto;">Create Group</button>
            </div>
        </form>
    </div>
</div>

<!-- Edit Group Modal -->
<div id="editGroupModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; justify-content: center; align-items: center;">
    <div style="background: #1a2335; width: 100%; max-width: 500px; padding: 2rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1);">
        <h2 style="color: white; margin-bottom: 1.5rem;">Edit Group</h2>
        <form action="" method="post">
            <input type="hidden" name="group_id" id="edit_group_id">
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="color: #cbd5e1; display: block; margin-bottom: 0.5rem;">Group Name</label>
                <input type="text" name="group_name" id="edit_group_name" class="form-control" required style="width: 100%; padding: 0.8rem; background: #0f172a; border: 1px solid #334155; color: white; border-radius: 8px;">
            </div>
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="color: #cbd5e1; display: block; margin-bottom: 0.5rem;">Description</label>
                <textarea name="description" id="edit_group_desc" class="form-control" rows="3" style="width: 100%; padding: 0.8rem; background: #0f172a; border: 1px solid #334155; color: white; border-radius: 8px;"></textarea>
            </div>
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <a href="groups" class="btn btn-outline" style="width: auto; margin:0; text-decoration:none;">Cancel</a>
                <button type="submit" name="update_group" class="btn btn-primary" style="width: auto;">Update Group</button>
            </div>
        </form>
    </div>
</div>

<?php 
// Manage Exams Modal (Logic to show if GET param exists)
if (isset($_GET['manage_exams'])) {
    $mGroupId = (int)$_GET['manage_exams'];
    $mGroup = $group->getGroupById($mGroupId);
    $mAssigned = $exam->getExamsByGroupId($mGroupId);
?>
<div id="manageExamsModal" style="display: flex; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.8); z-index: 1000; justify-content: center; align-items: center;">
    <div style="background: #1a2335; width: 100%; max-width: 600px; padding: 2rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.1); max-height: 90vh; overflow-y: auto;">
        <h2 style="color: white; margin-bottom: 0.5rem;">Manage Assigned Exams</h2>
        <p style="color: #94a3b8; margin-bottom: 1.5rem;">Group: <strong style="color: #facc15;"><?php echo $mGroup['name']; ?></strong></p>
        
        <!-- List Active Assignments -->
        <h4 style="color: #cbd5e1; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.5rem; margin-bottom: 1rem;">Active Exams</h4>
        <?php if ($mAssigned && $mAssigned->num_rows > 0) { ?>
            <div style="display: flex; flex-direction: column; gap: 0.8rem; margin-bottom: 2rem;">
            <?php while($ae = $mAssigned->fetch_assoc()) { ?>
                <div style="background: rgba(255,255,255,0.05); padding: 1rem; border-radius: 8px; display: flex; justify-content: space-between; align-items: center;">
                    <div>
                        <div style="color: white; font-weight: 500; font-size: 1.05rem;"><?php echo $ae['name']; ?></div>
                        <div style="color: #94a3b8; font-size: 0.85rem; margin-top: 4px;">
                            <?php 
                            if ($ae['is_scheduled'] == '1' && $ae['start_time']) {
                                echo "Starts: " . date('M d, H:i', strtotime($ae['start_time'])) . " • Ends: " . date('M d, H:i', strtotime($ae['end_time']));
                            } else {
                                echo "No Schedule (Always Available)";
                            }
                            ?>
                        </div>
                    </div>
                    <form action="groups" method="post" style="margin:0;">
                         <input type="hidden" name="exam_id" value="<?php echo $ae['id']; ?>">
                         <button type="submit" name="disable_exam_assignment" class="btn btn-outline" style="padding: 0.4rem 0.8rem; font-size: 0.8rem; color: #f87171; border-color: #f87171; background: transparent;">Disable</button>
                    </form>
                </div>
            <?php } ?>
            </div>
        <?php } else { ?>
            <p style="color: #64748b; font-style: italic; margin-bottom: 2rem;">No exams currently assigned.</p>
        <?php } ?>

        <!-- Assign New -->
        <h4 style="color: #cbd5e1; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 0.5rem; margin-bottom: 1rem;">Assign New Exam</h4>
        <form action="groups" method="post">
            <input type="hidden" name="group_id" value="<?php echo $mGroupId; ?>">
            <input type="hidden" name="assign_exam" value="1">
            
            <div class="form-group" style="margin-bottom: 1.2rem;">
                <label class="form-label" style="color: #cbd5e1; display: block; margin-bottom: 0.5rem;">Select Exam</label>
                <select name="exam_id" class="form-control" required style="width: 100%; padding: 0.8rem; background: #0f172a; border: 1px solid #334155; color: white; border-radius: 8px;">
                    <option value="">-- Select an Exam --</option>
                    <?php 
                    if ($exams) {
                        $exams->data_seek(0); 
                        while($e = $exams->fetch_assoc()) {
                            // Optionally filter out already assigned ones if needed, but for now allow re-assign to update time
                             echo '<option value="'.$e['id'].'">'.$e['name'].'</option>';
                        }
                    }
                    ?>
                </select>
            </div>
            
            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem; margin-bottom: 1.5rem;">
                <div class="form-group">
                    <label class="form-label" style="color: #cbd5e1; display: block; margin-bottom: 0.5rem;">Start Time</label>
                    <input type="datetime-local" name="start_time" class="form-control" style="width: 100%; padding: 0.8rem; background: #0f172a; border: 1px solid #334155; color: white; border-radius: 8px;">
                </div>
                <div class="form-group">
                    <label class="form-label" style="color: #cbd5e1; display: block; margin-bottom: 0.5rem;">End Time</label>
                    <input type="datetime-local" name="end_time" class="form-control" style="width: 100%; padding: 0.8rem; background: #0f172a; border: 1px solid #334155; color: white; border-radius: 8px;">
                </div>
            </div>
            
            <div style="display: flex; gap: 1rem; justify-content: flex-end;">
                <a href="groups" class="btn btn-outline" style="width: auto; margin:0; text-decoration: none;">Close</a>
                <button type="submit" class="btn btn-primary" style="width: auto; border-color: #facc15; color: #facc15; background: rgba(250, 204, 21, 0.1);">Assign Schedule</button>
            </div>
        </form>
    </div>
</div>
<?php } ?>

<script>
// Close modal on outside click
window.onclick = function(event) {
    if (event.target == document.getElementById('createGroupModal')) {
        document.getElementById('createGroupModal').style.display = "none";
    }
    if (event.target == document.getElementById('editGroupModal')) {
        document.getElementById('editGroupModal').style.display = "none";
    }
    if (event.target == document.getElementById('assignExamModal')) {
        document.getElementById('assignExamModal').style.display = "none";
    }
}

function openEditModal(id, name, desc) {
    document.getElementById('edit_group_id').value = id;
    document.getElementById('edit_group_name').value = name;
    document.getElementById('edit_group_desc').value = desc;
    document.getElementById('editGroupModal').style.display = 'flex';
}

function openAssignModal(id, name) {
    document.getElementById('assign_group_id').value = id;
    document.getElementById('assign_group_name_display').innerText = "Assigning to: " + name;
    document.getElementById('assignExamModal').style.display = 'flex';
}
</script>

</body>
</html>
