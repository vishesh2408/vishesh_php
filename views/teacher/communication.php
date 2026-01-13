<?php 
include __DIR__ . '/partials/header.php'; 
use App\Models\Announcement;
use App\Lib\Session;
use App\Models\Group; // For target groups

$ann = new Announcement();
$group = new Group();
$teacherId = Session::get("userId");

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['post_announcement'])) {
    $msg = $ann->addAnnouncement($_POST, $teacherId);
}
?>

<div class="container" style="max-width: 800px; margin: 0 auto; padding: 1rem;">
    <div style="margin-bottom: 2rem;">
        <h1 class="page-title" style="margin: 0; text-align: left;">Communication Hub</h1>
        <p style="color: #94a3b8; margin: 5px 0 0 0;">Send announcements and manage class notifications</p>
    </div>

    <?php if (isset($msg)) echo $msg; ?>

    <!-- Compose Announcement -->
    <div class="card" style="background: #1a2335; padding: 2rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); margin-bottom: 2rem;">
        <h3 style="color: #f8fafc; margin-bottom: 1.5rem;">📢 Post New Announcement</h3>
        <form action="" method="post">
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; color: #f8fafc;">Title</label>
                <input class="form-control" type="text" name="title" placeholder="e.g. Exam Schedule Change" required style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2); color: white;">
            </div>
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; color: #f8fafc;">Message</label>
                <textarea class="form-control" name="message" placeholder="Write your announcement here..." rows="5" required style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2); color: white;"></textarea>
            </div>
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; color: #f8fafc;">Send To</label>
                <select name="target" class="form-control" style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2); color: white;">
                    <option value="all">All Students</option>
                    <?php 
                    $groups = $group->getGroups();
                    if ($groups) {
                        while($row = $groups->fetch_assoc()) {
                            echo "<option value='".$row['id']."'>Group: ".$row['name']."</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div style="text-align: right;">
                <button type="submit" name="post_announcement" class="btn btn-primary" style="width: auto;">Post Announcement</button>
            </div>
        </form>
    </div>

    <!-- Recent History -->
    <div>
        <h3 style="color: #f8fafc; margin-bottom: 1rem;">Recent Announcements</h3>
        
        <?php 
        $list = $ann->getAnnouncements();
        if ($list) {
            while ($row = $list->fetch_assoc()) {
        ?>
        <div class="card" style="background: rgba(255,255,255,0.02); padding: 1.5rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.05); margin-bottom: 1rem;">
            <div style="display: flex; justify-content: space-between; margin-bottom: 0.5rem;">
                <strong style="color: #f8fafc;"><?php echo $row['title']; ?></strong>
                <span style="color: #94a3b8; font-size: 0.85rem;"><?php echo date('M d, H:i', strtotime($row['created_at'])); ?></span>
            </div>
            <p style="color: #94a3b8; margin: 0; font-size: 0.95rem; white-space: pre-line;"><?php echo $row['message']; ?></p>
            <div style="text-align: right; margin-top: 0.5rem;">
                <span style="font-size: 0.75rem; color: #64748b; background: rgba(255,255,255,0.05); padding: 2px 8px; border-radius: 4px;">
                    To: <?php echo ($row['target_group'] == 'all') ? 'All Students' : 'Group #' . $row['target_group']; ?>
                </span>
            </div>
        </div>
        <?php } } else { ?>
            <p style="color: #64748b; font-style: italic;">No announcements post yet.</p>
        <?php } ?>
    </div>
</div>
</body>
</html>
