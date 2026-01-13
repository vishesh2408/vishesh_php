<?php 
include __DIR__ . '/partials/header.php';
use App\Models\Exam;
$exam = new Exam();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id = (int)$_POST['id'];
    $msg = $exam->updateQuestion($id, $_POST);
} else {
    $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
}

$q = $exam->getQuestionById($id);
if (!$q) {
    echo "<div class='admin-wrapper'><h3>Question Not Found</h3></div>";
    exit;
}

// Get Answers
$answers = [];
$ansRes = $exam->getAnswersByQuesNo($q['quesNo'], $q['exam_id']);
$rightAns = 0;
$i = 1;
if ($ansRes) {
    while($row = $ansRes->fetch_assoc()) {
        $answers[$i] = $row['ans'];
        if ($row['rightAns'] == '1') $rightAns = $i;
        $i++;
    }
}
?>

<div class="admin-header">
    <h1 class="admin-title">Edit Question</h1>
    <a href="/admin/queslist" class="action-btn btn-info">Back to Questions</a>
</div>

<?php if (isset($msg)) echo $msg; ?>

<div style="max-width: 800px; margin: 0 auto;">
    <div class="auth-container" style="min-height: auto; flex-direction: column; padding: 0;">
        <div class="auth-form-side" style="padding: 2rem;">
            <form action="" method="post">
                <input type="hidden" name="id" value="<?php echo $q['id']; ?>">
                <input type="hidden" name="exam_id" value="<?php echo $q['exam_id']; ?>">
                <input type="hidden" name="quesNo" value="<?php echo $q['quesNo']; ?>">

                <div class="form-group">
                    <label class="form-label">Question Text</label>
                    <input class="form-control" type="text" name="ques" value="<?php echo htmlspecialchars($q['ques']); ?>" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <?php for($k=1; $k<=4; $k++) { ?>
                    <div class="form-group">
                        <label class="form-label">Choice <?php echo $k; ?></label>
                        <input class="form-control" type="text" name="ans<?php echo $k; ?>" value="<?php echo isset($answers[$k]) ? htmlspecialchars($answers[$k]) : ''; ?>" required>
                    </div>
                    <?php } ?>
                </div>

                <div class="form-group">
                    <label class="form-label">Correct Option Number (1-4)</label>
                    <input class="form-control" type="number" name="rightAns" min="1" max="4" value="<?php echo $rightAns; ?>" required>
                </div>

                <div style="margin-top: 1rem;">
                    <input type="submit" class="btn btn-primary" value="Update Question">
                </div>
            </form>
        </div>
    </div>
</div>
</div></body></html>
