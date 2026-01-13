<?php
include __DIR__ . '/partials/header.php';
use App\Models\Exam;
$exam = new Exam();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $addQuestion = $exam->getAddQuestion($_POST);
    $selectedAndActiveExamId = (int)$_POST['exam_id'];
} else {
    $selectedAndActiveExamId = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 0;
}

$examsList = $exam->getExams(100); 

// Pre-select first if none selected
if ($selectedAndActiveExamId == 0 && $examsList && $examsList->num_rows > 0) {
     $first = $examsList->fetch_assoc();
     $selectedAndActiveExamId = $first['id'];
     $examsList->data_seek(0);
}

// Get Question Number
$total = $exam->getTotalRows($selectedAndActiveExamId);
$next = $total + 1;
?>

<div class="container" style="max-width: 800px; margin: 0 auto; padding: 1rem;">
    <div style="margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between;">
         <h1 class="page-title" style="margin: 0; text-align: left;">Add New Question</h1>
         <a href="/teacher/question-bank" style="color: #94a3b8; text-decoration: none;">&larr; Back to Questions</a>
    </div>

    <?php if (isset($addQuestion)) echo $addQuestion; ?>

    <div class="card" style="background: #1a2335; border-radius: 12px; padding: 2rem; border: 1px solid rgba(255,255,255,0.05);">
        
        <!-- Exam Select -->
        <form method="get" action="" id="examSelectForm" style="margin-bottom: 2rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 2rem;">
            <div class="form-group">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; color: #818cf8; font-weight: 600;">Select Assessment / Exam</label>
                <select name="exam_id" onchange="document.getElementById('examSelectForm').submit()" style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid #818cf8; background: rgba(129, 140, 248, 0.1); color: white; cursor: pointer;">
                    <?php 
                    if ($examsList) {
                        while ($row = $examsList->fetch_assoc()) {
                            $selected = ($row['id'] == $selectedAndActiveExamId) ? 'selected' : '';
                            echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                        }
                    }
                    ?>
                </select>
                <p style="color: #94a3b8; font-size: 0.85rem; margin-top: 0.5rem;">The question will be added to this exam pack.</p>
            </div>
        </form>

        <!-- Question Form -->
        <form action="" method="post">
            <input type="hidden" name="exam_id" value="<?php echo $selectedAndActiveExamId; ?>">
             
            <div style="margin-bottom: 1.5rem; background: rgba(0,0,0,0.2); padding: 1rem; border-radius: 8px;">
                <label class="form-label" style="color: #94a3b8;">Question Number</label>
                <div style="color: white; font-size: 1.5rem; font-weight: 700;">#<?php echo $next; ?></div>
                <input type="hidden" name="quesNo" value="<?php echo $next; ?>">
            </div>

            <div class="form-group" style="margin-bottom: 1.5rem;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; color: #f8fafc;">Question Content</label>
                <textarea class="form-control" name="ques" placeholder="Type your question here..." required style="width: 100%; padding: 1rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2); color: white; min-height: 100px; font-family: inherit;"></textarea>
            </div>

            <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1.5rem; margin-bottom: 2rem;">
                <div class="form-group">
                    <label class="form-label" style="display: block; margin-bottom: 0.5rem; color: #f8fafc;">Option 1</label>
                    <input class="form-control" type="text" name="ans1" placeholder="Answer A" required style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2); color: white;">
                </div>
                <div class="form-group">
                    <label class="form-label" style="display: block; margin-bottom: 0.5rem; color: #f8fafc;">Option 2</label>
                    <input class="form-control" type="text" name="ans2" placeholder="Answer B" required style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2); color: white;">
                </div>
                <div class="form-group">
                    <label class="form-label" style="display: block; margin-bottom: 0.5rem; color: #f8fafc;">Option 3</label>
                    <input class="form-control" type="text" name="ans3" placeholder="Answer C" required style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2); color: white;">
                </div>
                <div class="form-group">
                    <label class="form-label" style="display: block; margin-bottom: 0.5rem; color: #f8fafc;">Option 4</label>
                    <input class="form-control" type="text" name="ans4" placeholder="Answer D" required style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2); color: white;">
                </div>
            </div>

            <div class="form-group" style="margin-bottom: 2rem;">
                <label class="form-label" style="display: block; margin-bottom: 0.5rem; color: #4ade80;">Correct Answer</label>
                <select name="rightAns" class="form-control" required style="width: 100%; padding: 0.8rem; border-radius: 8px; border: 1px solid #4ade80; background: rgba(74, 222, 128, 0.1); color: white;">
                    <option value="1">Option 1</option>
                    <option value="2">Option 2</option>
                    <option value="3">Option 3</option>
                    <option value="4">Option 4</option>
                </select>
            </div>

            <div style="text-align: right;">
                <input type="submit" class="btn btn-primary" value="Save Question" style="padding: 0.8rem 2rem; font-size: 1rem;">
            </div>
        </form>
    </div>
</div>

</body>
</html>
