<?php 
include __DIR__ . '/partials/header.php';
use App\Models\Exam;
$exam = new Exam();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $addQuestion = $exam->getAddQuestion($_POST);
    // After adding, keep the same exam selected
    $selectedAndActiveExamId = (int)$_POST['exam_id'];
} else {
    // Get from GET or default
    $selectedAndActiveExamId = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 0;
}

// Get Active Exams
$examsList = $exam->getExams(); 

// If no valid ID yet, pick first
if ($selectedAndActiveExamId == 0 && $examsList && $examsList->num_rows > 0) {
     $first = $examsList->fetch_assoc();
     $selectedAndActiveExamId = $first['id'];
     $examsList->data_seek(0);
}

// Get Total
$total = $exam->getTotalRows($selectedAndActiveExamId);
$next = $total + 1;
?>

<div class="admin-header">
    <h1 class="admin-title">Add New Question</h1>
    <a href="queslist" class="action-btn btn-info">View All Questions</a>
</div>

<?php if (isset($addQuestion)) echo $addQuestion; ?>

<div style="max-width: 800px; margin: 0 auto;">
    <div class="auth-container" style="min-height: auto; flex-direction: column; padding: 0;">
        <div class="auth-form-side" style="padding: 2rem;">
            
             <form method="get" action="" id="examSelectForm" style="margin-bottom: 2rem; border-bottom: 1px solid #eee; padding-bottom: 1rem;">
                <div class="form-group">
                    <label class="form-label" style="color: var(--primary-color);">Select Exam to Add Question To:</label>
                    <select name="exam_id" class="form-control" onchange="document.getElementById('examSelectForm').submit()" style="border-color: var(--primary-color);">
                        <?php 
                        if ($examsList) {
                            while ($row = $examsList->fetch_assoc()) {
                                $selected = ($row['id'] == $selectedAndActiveExamId) ? 'selected' : '';
                                echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                            }
                        }
                        ?>
                    </select>
                </div>
            </form>

            <form action="" method="post" name="tbl_ans">
                 <input type="hidden" name="exam_id" value="<?php echo $selectedAndActiveExamId; ?>">
                 
                <div class="form-group">
                    <label class="form-label">Question No: <strong><?php echo $next; ?></strong></label>
                    <input type="hidden" name="quesNo" value="<?php echo $next; ?>">
                </div>

                <div class="form-group">
                    <label class="form-label">Question Text</label>
                    <input class="form-control" type="text" name="ques" placeholder="Enter Question" required>
                </div>

                <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                    <div class="form-group">
                        <label class="form-label">Choice 1</label>
                        <input class="form-control" type="text" name="ans1" placeholder="Option 1" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Choice 2</label>
                        <input class="form-control" type="text" name="ans2" placeholder="Option 2" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Choice 3</label>
                        <input class="form-control" type="text" name="ans3" placeholder="Option 3" required>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Choice 4</label>
                        <input class="form-control" type="text" name="ans4" placeholder="Option 4" required>
                    </div>
                </div>

                <div class="form-group">
                    <label class="form-label">Correct Option Number (1-4)</label>
                    <input class="form-control" type="number" name="rightAns" min="1" max="4" required>
                </div>

                <div style="margin-top: 1rem;">
                    <input type="submit" class="btn btn-primary" value="Save Question">
                </div>
            </form>
        </div>
    </div>
</div>

</div> <!-- Close wrapper -->
</body>
</html>