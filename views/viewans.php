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
?>


<div class="main-wrapper" style="align-items: flex-start; padding: 3rem 1rem;">
    <div style="width: 100%; max-width: 900px; margin: 0 auto;">
        
        <div style="text-align: center; margin-bottom: 3rem;">
            <h1 class="page-title" style="background: linear-gradient(to right, #c084fc 0%, #818cf8 100%); -webkit-background-clip: text; -webkit-text-fill-color: transparent;">Answer Key</h1>
            <p class="page-subtitle">Review all questions and correct answers</p>
        </div>

        <?php
        $getQues = $exam->getqueData();
        if ($getQues) {
            while ($question = $getQues->fetch_assoc()) {
                $examName = isset($question['exam_name']) ? $question['exam_name'] : 'General';
        ?>
        <div style="background: #1a2335; border-radius: 16px; padding: 2rem; margin-bottom: 1.5rem; border: 1px solid rgba(255,255,255,0.05); box-shadow: var(--shadow-lg); transition: transform 0.2s;">
            <div style="display: flex; justify-content: space-between; align-items: flex-start; margin-bottom: 1.5rem;">
                <h3 style="font-size: 1.25rem; color: #f8fafc; flex: 1; line-height: 1.5;">
                    <span style="color: #818cf8; font-weight: 700; margin-right: 0.5rem;">Q<?php echo $question['quesNo']; ?>.</span> <?php echo $question['ques']; ?>
                </h3>
            </div>
            
            <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(280px, 1fr)); gap: 1rem;">
                <?php
                $answer = $exam->getAnswer($question['quesNo'], $question['exam_id']);
                $userSelected = isset($_SESSION['user_answers'][$question['quesNo']]) ? $_SESSION['user_answers'][$question['quesNo']] : null;

                if ($answer) {
                    while ($result = $answer->fetch_assoc()) {
                        $isCorrect = ($result['rightAns'] == '1');
                        $isSelected = ($result['id'] == $userSelected);
                        
                        // Default Style
                        $style = "background: #0f172a; border: 1px solid #334155; color: #94a3b8; opacity: 0.8;";
                        $icon = "";

                        if ($isCorrect) {
                            $style = "background: rgba(16, 185, 129, 0.15); border: 1px solid #10b981; color: #34d399; font-weight: 600; box-shadow: 0 0 10px rgba(16, 185, 129, 0.1);";
                            $icon = "<span style='font-size: 1.2rem;'>✓</span>";
                        } elseif ($isSelected) {
                            $style = "background: rgba(239, 68, 68, 0.15); border: 1px solid #ef4444; color: #f87171; font-weight: 600;";
                             $icon = "<span style='font-size: 0.9rem;'>Your Answer (X)</span>";
                        }
                        
                        if ($isSelected && $isCorrect) {
                             $icon = "<span style='font-size: 1.2rem;'>✓ (Your Answer)</span>";
                        }
                ?>
                <div style="padding: 1rem 1.2rem; border-radius: 10px; font-size: 1rem; display: flex; justify-content: space-between; align-items: center; transition: all 0.2s; <?php echo $style; ?>">
                    <span><?php echo $result['ans']; ?></span>
                    <?php echo $icon; ?>
                </div>
                <?php 
                    }
                }
                ?>
            </div>
        </div>
        <?php 
            }
        } else {
             echo "<div style='text-align:center; color: #94a3b8; background: #1a2335; padding: 2rem; border-radius: 12px;'>No questions found to display.</div>";
        }
        ?>
        
        <div style="text-align: center; margin-top: 3rem;">
            <a href="exam" class="btn btn-primary" style="width: auto; padding: 1rem 3rem; font-size: 1.1rem; border-radius: 30px;">
                &larr; Back to Dashboard
            </a>
        </div>
    </div>
</div>
