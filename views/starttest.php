<?php 
include __DIR__ . '/partials/header.php';
use App\Models\User;
use App\Models\Exam;
use App\Models\Process;
use App\Lib\Session;
$user = new User();
$exam = new Exam();
$pro  = new Process();
$fm   = new \App\Helpers\Format();
?>
<?php
  Session::checkSession();
  
  $examId = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 1;
  $exDetails = $exam->getExamById($examId);
  $total    = $exam->getTotalRows($examId);
  
  $firstQues = $exam->getqueData($examId)->fetch_assoc();
?>



<div style="width: 100%; text-align: center; margin-top: 50px; max-width: 800px; margin: 80px auto; background: #1a2335; padding: 3rem; border-radius: 12px; box-shadow: var(--shadow-xl); color: #f1f5f9;">
    <h1 class="page-title" style="font-size: 3.5rem; margin-bottom: 1rem;"><?php echo isset($exDetails['name']) ? $exDetails['name'] : 'Exam'; ?></h1>
    <p style="font-size: 20px; font-weight: bold; color: #94a3b8;">Test Your Knowledge</p>
    <br/>

    <div style="display: flex; justify-content: center; gap: 2rem; margin-bottom: 2rem;">
        <div style="text-align: center;">
            <div style="font-size: 2rem; font-weight: bold; color: #f1f5f9;"><?php echo $total; ?></div>
            <div style="color: #cbd5e1;">Questions</div>
        </div>
        <div style="text-align: center;">
            <div style="font-size: 2rem; font-weight: bold; color: #f1f5f9;"><?php echo isset($exDetails['time_limit']) ? $exDetails['time_limit'] : 30; ?>m</div>
            <div style="color: #cbd5e1;">Duration</div>
        </div>
    </div>

    <?php if ($total > 0 && $firstQues) { ?>
    <form action="/test" method="get">
        <input type="hidden" name="exam_id" value="<?php echo $examId; ?>">
        <input type="hidden" name="q" value="<?php echo $firstQues['quesNo']; ?>">
        
        <!-- Also init Score/Process session here if needed? 
             Usually process is handled in test.php via Process model. 
             But Process model needs to know we are starting a specific exam.
        -->
        
        <button type="submit" class="btn btn-primary" style="width: auto; padding: 15px 40px; font-size: 1.2rem;">
            <span style="margin-right: 10px;">&#x25B6;</span> Start Exam
        </button>
    </form>
    <?php } else { ?>
        <p class="alert-error" style="display: inline-block;">No questions in this exam yet.</p>
    <?php } ?>

    <br/>
    <br/>
    <a href="/exam" style="color: var(--text-muted); text-decoration: none;">&larr; Back to Exams</a>
</div>

<?php include __DIR__ . '/partials/footer.php'; ?>