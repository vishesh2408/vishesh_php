<?php 
include __DIR__ . '/partials/header.php';
use App\Models\Exam;
$exam = new Exam();

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $msg = $exam->updateExam($id, $_POST);
}

$e = $exam->getExamById($id);
if (!$e) {
    echo "<div class='admin-wrapper'><h3>Exam Not Found</h3></div>";
    exit;
}
?>

<div class="admin-header">
    <h1 class="admin-title">Edit Exam</h1>
    <a href="/admin/exams" class="action-btn btn-info">Back to Exams</a>
</div>

<?php if (isset($msg)) echo $msg; ?>

<div class="auth-container" style="max-width: 600px; min-height: auto; flex-direction: column; padding: 0; margin: 0 auto;">
    <div class="auth-form-side" style="padding: 2rem;">
        <form action="" method="post">
            <input type="hidden" name="id" value="<?php echo $e['id']; ?>">
            <div class="form-group">
                <label class="form-label">Exam Name</label>
                <input class="form-control" type="text" name="name" value="<?php echo $e['name']; ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Time Limit (Minutes)</label>
                <input class="form-control" type="number" name="time_limit" value="<?php echo $e['time_limit']; ?>" required>
            </div>
            <div class="form-group">
                <label class="form-label">Status</label>
                <select class="form-control" name="status">
                    <option value="1" <?php if($e['status']==1) echo 'selected'; ?>>Active</option>
                    <option value="0" <?php if($e['status']==0) echo 'selected'; ?>>Inactive</option>
                </select>
            </div>
            <input type="submit" class="btn btn-primary" value="Update Exam">
        </form>
    </div>
</div>

</div></body></html>
