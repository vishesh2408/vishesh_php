<?php 
include __DIR__ . '/partials/header.php';
use App\Models\Group;
$group = new Group();

if (!isset($_GET['id'])) {
    echo "<script>window.location='/teacher/groups';</script>";
}

$groupId = (int)$_GET['id'];
$groupData = $group->getGroupById($groupId);

// Handle Add/Remove
if (isset($_GET['add'])) {
    $group->addMember($groupId, $_GET['add']);
    echo "<script>window.location='/teacher/groups/manage?id=$groupId';</script>";
}
if (isset($_GET['remove'])) {
    $group->removeMember($groupId, $_GET['remove']);
    echo "<script>window.location='/teacher/groups/manage?id=$groupId';</script>";
}
// Handle CSV Import
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['import_csv'])) {
    if (isset($_FILES['csv_file']['name']) && $_FILES['csv_file']['name'] != '') {
        $msg = $group->importMembersFromCsv($groupId, $_FILES['csv_file']);
    } else {
        $msg = "<div class='alert alert-danger'>Please select a file.</div>";
    }
}
?>

<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 1rem;">
    <div style="margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between;">
        <div>
            <div style="margin-bottom: 0.5rem;"><a href="/teacher/groups" style="color: #94a3b8; text-decoration: none;">&larr; Back to Groups</a></div>
            <h1 class="page-title" style="margin: 0; text-align: left;"><?php echo $groupData['name']; ?></h1>
            <p style="color: #94a3b8; margin: 5px 0 0 0;"><?php echo $groupData['description']; ?></p>
        </div>
        <div style="display: flex; gap: 1rem;">
           <button onclick="document.getElementById('importModal').style.display='flex'" class="btn btn-outline" style="width: auto;">
             📂 Import CSV
           </button>
        </div>
    </div>
    
    <?php if (isset($msg)) echo $msg; ?>

    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 2rem;">
        
        <!-- Current Members -->
        <div class="card" style="background: #1a2335; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); overflow: hidden; height: fit-content;">
            <div style="padding: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05); display: flex; justify-content: space-between; align-items: center;">
                <h3 style="margin: 0; color: #f8fafc; font-size: 1.1rem;">Current Students</h3>
                <span style="background: rgba(99, 102, 241, 0.2); color: #818cf8; padding: 2px 8px; border-radius: 10px; font-size: 0.8rem;">Enrolled</span>
            </div>
            
            <table style="width: 100%; border-collapse: collapse; color: #f8fafc;">
                <tbody>
                <?php 
                $members = $group->getMembers($groupId);
                if ($members && $members->num_rows > 0) {
                    while($row = $members->fetch_assoc()) {
                ?>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td style="padding: 1rem;">
                            <div style="font-weight: 500;"><?php echo $row['name']; ?></div>
                            <div style="color: #94a3b8; font-size: 0.85rem;"><?php echo $row['email']; ?></div>
                        </td>
                        <td style="padding: 1rem; text-align: right;">
                            <a href="?id=<?php echo $groupId; ?>&remove=<?php echo $row['userId']; ?>" style="color: #ef4444; text-decoration: none; font-size: 0.9rem;">Remove</a>
                        </td>
                    </tr>
                <?php } } else { ?>
                    <tr><td colspan="2" style="text-align: center; padding: 2rem; color: #94a3b8;">No students in this group yet.</td></tr>
                <?php } ?>
                </tbody>
            </table>
        </div>

        <!-- Available Students -->
        <div class="card" style="background: #1a2335; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); overflow: hidden; height: fit-content;">
            <div style="padding: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05);">
                <div style="display:flex; justify-content:space-between; align-items:center;">
                    <h3 style="margin: 0; color: #f8fafc; font-size: 1.1rem;">Add Students</h3>
                </div>
                <input type="text" placeholder="Search students..." style="width: 100%; margin-top: 1rem; padding: 0.6rem; background: #0f172a; border: 1px solid #334155; color: white; border-radius: 6px;">
            </div>
            
            <div style="max-height: 400px; overflow-y: auto;">
                <table style="width: 100%; border-collapse: collapse; color: #f8fafc;">
                    <tbody>
                    <?php 
                    $available = $group->getAvailableStudents($groupId);
                    if ($available && $available->num_rows > 0) {
                        while($row = $available->fetch_assoc()) {
                    ?>
                        <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                            <td style="padding: 1rem;">
                                <div style="font-weight: 500;"><?php echo $row['name']; ?></div>
                                <div style="color: #94a3b8; font-size: 0.85rem;"><?php echo $row['email']; ?></div>
                                <?php if (!empty($row['institution'])) { ?>
                                    <div style="color: #facc15; font-size: 0.8rem; margin-top: 2px;">
                                        🏛 <?php echo $row['institution']; ?>
                                        <?php if(!empty($row['institution_id'])) echo " <span style='color: #94a3b8;'>(" . $row['institution_id'] . ")</span>"; ?>
                                    </div>
                                <?php } ?>
                            </td>
                            <td style="padding: 1rem; text-align: right;">
                                <a href="?id=<?php echo $groupId; ?>&add=<?php echo $row['userId']; ?>" class="btn btn-primary" style="padding: 0.3rem 0.8rem; font-size: 0.8rem; width: auto; text-decoration: none;">+ Add</a>
                            </td>
                        </tr>
                    <?php } } else { ?>
                        <tr><td colspan="2" style="text-align: center; padding: 2rem; color: #94a3b8;">No available students found.</td></tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
<!-- Import Modal -->
<div id="importModal" style="display: none; position: fixed; top: 0; left: 0; width: 100%; height: 100%; background: rgba(0,0,0,0.7); z-index: 1000; align-items: center; justify-content: center;">
    <div style="background: #1e293b; padding: 2rem; border-radius: 12px; width: 90%; max-width: 500px; border: 1px solid rgba(255,255,255,0.1);">
        <h3 style="color: #fff; margin-top: 0;">Import Students via CSV</h3>
        <p style="color: #94a3b8; font-size: 0.9rem;">Upload a CSV file containing student emails. The system will search for existing users by email and add them to this group.</p>
        
        <form action="" method="post" enctype="multipart/form-data" style="margin-top: 1.5rem;">
            <div style="background: rgba(0,0,0,0.2); padding: 1rem; border-radius: 8px; border: 1px dashed rgba(255,255,255,0.2); text-align: center; margin-bottom: 1.5rem;">
                <input type="file" name="csv_file" accept=".csv" required style="color: #cbd5e1;">
            </div>
            
            <div style="display: flex; justify-content: flex-end; gap: 1rem;">
                <button type="button" onclick="document.getElementById('importModal').style.display='none'" class="btn btn-outline">Cancel</button>
                <button type="submit" name="import_csv" class="btn btn-primary">Import Students</button>
            </div>
        </form>
    </div>
</div>

</div>
</body>
</html>
