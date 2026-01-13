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

<div class="main-wrapper">
    <div class="auth-container" style="max-width: 500px; min-height: auto; flex-direction: column; padding: 3rem; text-align: center; border-radius: 24px;">
        
        <div style="font-size: 4rem; margin-bottom: 0.5rem; animation: float 3s ease-in-out infinite;">🎉</div>
        <h1 class="page-title" style="margin-bottom: 0.5rem;">Test Completed!</h1>
        <p class="page-subtitle">Great job completing the assessment.</p>

        <?php
        // Fetch Exam Details for this session to checks auto-evaluate
        // We need exam_id. Assuming it was set in session or passed. 
        // Actually, final.php doesn't receive exam_id in GET usually. 
        // We can get it from the last attempt or session if stored.
        // Let's rely on tbl_attempts check for the latest attempt by user.
        
        $userId = Session::get("userId");
        $lastAttempt = $pro->getLastAttempt($userId);
        $showScore = true; // Default
        
        if ($lastAttempt) {
             $examData = $exam->getExamById($lastAttempt['examId']);
             if ($examData && isset($examData['auto_evaluate']) && $examData['auto_evaluate'] == 0) {
                 $showScore = false;
             }
        }
        ?>

        <?php if ($showScore) { ?>
            <div style="background: linear-gradient(135deg, var(--primary-color) 0%, var(--secondary-color) 100%); padding: 2rem; border-radius: 20px; color: white; margin: 2rem 0; box-shadow: 0 10px 20px rgba(99, 102, 241, 0.3); transform: scale(1.02);">
                <div style="font-size: 1.1rem; opacity: 0.9; font-weight: 500;">Your Final Score</div>
                <div style="font-size: 4.5rem; font-weight: 800; line-height: 1;">
                    <?php
                    if (isset($_SESSION['score'])) {
                        echo $_SESSION['score'];
                    } else {
                        echo "0";
                    }
                    ?>
                </div>
                <!-- Time Stats -->
                <div id="time-stats" style="margin-top: 1rem; padding-top: 1rem; border-top: 1px solid rgba(255,255,255,0.2); display: flex; justify-content: center; gap: 2rem;">
                    <div>
                        <div style="font-size: 0.9rem; opacity: 0.8;">Time Taken</div>
                        <div id="time-taken-display" style="font-size: 1.2rem; font-weight: 700;">--:--</div>
                    </div>
                </div>
            </div>
        <?php } else { ?>
            <div style="background: #1a2335; padding: 2rem; border-radius: 20px; color: #f8fafc; margin: 2rem 0; border: 1px solid rgba(255,255,255,0.05);">
                <div style="font-size: 3rem; margin-bottom: 1rem;">📤</div>
                <h2 style="margin-bottom: 0.5rem;">Submitted for Review</h2>
                <p style="color: #94a3b8;">Your exam has been submitted successfully effectively. The result will be declared after manual evaluation.</p>
            </div>
        <?php } ?>

        <script>
        document.addEventListener('DOMContentLoaded', function() {
            const startTime = localStorage.getItem('exam_start_time');
            if (startTime) {
                // Freeze the finish time on first load to prevent incrementing on refresh
                let finishTime = localStorage.getItem('exam_finish_time');
                if (!finishTime) {
                    finishTime = new Date().getTime();
                    localStorage.setItem('exam_finish_time', finishTime);
                }
                
                const duration = parseInt(finishTime) - parseInt(startTime);
                
                // Format
                const secondsTotal = Math.floor(duration / 1000);
                let mins = Math.floor(secondsTotal / 60);
                let secs = secondsTotal % 60;
                
                // Cap at 30 mins just in case
                if (mins > 30) { mins = 30; secs = 0; }
                
                document.getElementById('time-taken-display').innerText = 
                    (mins < 10 ? "0" + mins : mins) + ":" + (secs < 10 ? "0" + secs : secs);
            } else {
                 document.getElementById('time-taken-display').innerText = "N/A";
            }
            
            // Cleanup moved to start of new test (test.php) to allow stats persistence on refresh
        });
        </script>

        <div style="display: flex; gap: 1rem; flex-direction: column;">
             <?php if ($showScore) { ?>
             <a href="viewans" class="btn btn-outline" style="margin-top: 0;">Review Answers</a>
             <?php } ?>
             <a href="exam" class="btn btn-primary">Back to Dashboard</a>
        </div>
        
    </div>
</div>

<style>
@keyframes float {
    0% { transform: translateY(0px); }
    50% { transform: translateY(-10px); }
    100% { transform: translateY(0px); }
}
</style>
