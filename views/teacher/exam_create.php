<?php 
// Reusing Admin Logic but with Teacher Header
include __DIR__ . '/partials/header.php';
use App\Models\Exam;
$exam = new Exam();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addExam'])) {
    $msg = $exam->addExam($_POST);
}
?>

<div class="container" style="max-width: 800px; margin: 0 auto; padding: 1rem;">
    <div style="margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between;">
         <h1 class="page-title" style="margin: 0; text-align: left;">Create New Exam</h1>
         <a href="/teacher/exams" style="color: #94a3b8; text-decoration: none;">&larr; Back to Exams</a>
    </div>

    <?php if (isset($msg)) echo $msg; ?>

    <div class="card" style="background: #1a2335; border-radius: 12px; padding: 2rem; border: 1px solid rgba(255,255,255,0.05);">
        <form action="" method="post">
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; color: #f8fafc;">Exam Name</label>
                <input class="form-control" type="text" name="name" placeholder="e.g. Advanced Physics Midterm" required style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2); color: white;">
            </div>
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; color: #f8fafc;">Time Limit (Minutes)</label>
                <input class="form-control" type="number" name="time_limit" value="30" required style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2); color: white;">
            </div>
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="color: #f8fafc; display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="status" checked style="width: 1.2rem; height: 1.2rem;"> 
                    Active (Students can see this exam)
                </label>
            </div>
            
            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="color: #f8fafc; display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="is_scheduled" id="enable_schedule" onchange="toggleSchedule()" style="width: 1.2rem; height: 1.2rem;"> 
                    Enable Scheduling
                </label>
            </div>
            
            <div id="schedule_options" style="display: none; background: rgba(0,0,0,0.2); padding: 1.5rem; border-radius: 8px; margin-bottom: 1.5rem; border: 1px solid rgba(255,255,255,0.05);">
                <div class="form-group" style="margin-bottom: 1rem;">
                    <label class="form-label" style="display: block; margin-bottom: 0.5rem; color: #f8fafc;">Start Time</label>
                    <input class="form-control" type="datetime-local" name="start_time" style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); background: #1a2335; color: white;">
                    <small style="color: #94a3b8; font-size: 0.85rem; margin-top: 0.3rem; display: block;">Leave empty to start immediately</small>
                </div>
                <div class="form-group">
                    <label class="form-label" style="display: block; margin-bottom: 0.5rem; color: #f8fafc;">Expiry Time</label>
                    <input class="form-control" type="datetime-local" name="end_time" style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); background: #1a2335; color: white;">
                    <small style="color: #94a3b8; font-size: 0.85rem; margin-top: 0.3rem; display: block;">Leave empty for no expiry</small>
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="color: #f8fafc; display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="checkbox" name="auto_evaluate" checked style="width: 1.2rem; height: 1.2rem;"> 
                    Enable Auto-Evaluation (Instant Results)
                </label>
            </div>

            <div class="form-group" style="margin-bottom: 2rem;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; color: #f8fafc;">Assign to Group (Optional)</label>
                <select name="assigned_group_id" class="form-control" style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2); color: white;">
                    <option value="">All Students (Open)</option>
                    <?php 
                    use App\Models\Group;
                    $grp = new Group();
                    $groups = $grp->getGroups();
                    if ($groups) {
                        while($row = $groups->fetch_assoc()) {
                            echo "<option value='".$row['id']."'>".$row['name']."</option>";
                        }
                    }
                    ?>
                </select>
            </div>

            <div style="text-align: right;">
                <input type="submit" name="addExam" class="btn btn-primary" value="Create Exam" style="padding: 0.8rem 2rem; font-size: 1rem;">
            </div>
        </form>
    </div>
</div>

<script>
function toggleSchedule() {
    const chk = document.getElementById('enable_schedule');
    const div = document.getElementById('schedule_options');
    div.style.display = chk.checked ? 'block' : 'none';
}
</script>

</body>
</html>
