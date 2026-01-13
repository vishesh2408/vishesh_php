<?php 
include __DIR__ . '/partials/header.php';
use App\Models\Exam;
$exam = new Exam();

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['addExam'])) {
    $msg = $exam->addExam($_POST);
}

if (isset($_GET['del'])) {
    $msg = $exam->deleteExam((int)$_GET['del']);
}
?>

<div class="admin-header">
    <h1 class="admin-title">Manage Exams</h1>
</div>

<?php if (isset($msg)) echo $msg; ?>

<div style="display: grid; grid-template-columns: 1fr 2fr; gap: 2rem;">
    <!-- Add Exam Form -->
    <div class="auth-container" style="min-height: auto; flex-direction: column; padding: 0;">
        <div class="auth-form-side" style="padding: 1.5rem;">
            <h3 style="margin-bottom: 1rem;">Create New Exam</h3>
            <form action="" method="post">
                <div class="form-group">
                    <label class="form-label">Exam Name</label>
                    <input class="form-control" type="text" name="name" placeholder="e.g. Science Quiz" required>
                </div>
                <div class="form-group">
                    <label class="form-label">Time Limit (Minutes)</label>
                    <input class="form-control" type="number" name="time_limit" value="30" required>
                </div>
                <div class="form-group">
                    <label class="form-label"><input type="checkbox" name="status" checked> Active</label>
                </div>
                
                <div class="form-group">
                    <label class="form-label" style="cursor: pointer;">
                        <input type="checkbox" name="is_scheduled" id="enable_schedule" onchange="toggleSchedule()"> Enable Scheduling
                    </label>
                </div>
                
                <div id="schedule_options" style="display: none; background: rgba(0,0,0,0.05); padding: 1rem; border-radius: 8px; margin-bottom: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Start Time (Optional)</label>
                        <input class="form-control" type="datetime-local" name="start_time">
                        <small class="text-muted">Empty = Start anytime (or Now if End Time set)</small>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Expiry Time (Optional)</label>
                        <input class="form-control" type="datetime-local" name="end_time">
                        <small class="text-muted">Empty = No expiry</small>
                    </div>
                </div>

                <div class="form-group">
                     <label class="form-label" style="cursor: pointer;">
                        <input type="checkbox" name="auto_evaluate" checked> Enable Auto-Evaluation (Instant Results)
                    </label>
                </div>

                <input type="submit" name="addExam" class="btn btn-primary" value="Create Exam">
            </form>
            
            <script>
            function toggleSchedule() {
                const chk = document.getElementById('enable_schedule');
                const div = document.getElementById('schedule_options');
                div.style.display = chk.checked ? 'block' : 'none';
            }
            </script>
        </div>
    </div>

    <!-- Exam List -->
    <div class="table-container">
        <table class="custom-table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Time</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
            <?php
            $exams = $exam->getExams();
            if ($exams) {
                while ($row = $exams->fetch_assoc()) {
            ?>
                <tr>
                    <td><?php echo $row['id']; ?></td>
                    <td><strong><?php echo $row['name']; ?></strong></td>
                    <td><?php echo $row['time_limit']; ?> min</td>
                    <td><?php echo $row['status'] == 1 ? '<span style="color:var(--success-color)">Active</span>' : '<span style="color:var(--text-muted)">Inactive</span>'; ?></td>
                    <td>
                        <a class="action-btn btn-info" href="exams/edit?id=<?php echo $row['id']; ?>">Edit</a>
                        <a class="action-btn btn-danger" onclick="return confirm('Delete Exam? This will delete all questions in it!')" href="?del=<?php echo $row['id']; ?>">Delete</a>
                    </td>
                </tr>
            <?php } } else { echo "<tr><td colspan='5'>No exams found.</td></tr>"; } ?>
            </tbody>
        </table>
    </div>
</div>

</div> <!-- Close wrapper -->
</body>
</html>
