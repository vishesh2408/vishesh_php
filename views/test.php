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

// Block Back Button Re-entry
if (isset($_SESSION['exam_completed']) && $_SESSION['exam_completed'] === true) {
    // If they strictly requested Q1, we allow it (Retake).
    // Otherwise (Q2, Q3...), redirect to final.
    if (!isset($_GET['q']) || $_GET['q'] != 1) {
        header("Location:final");
        exit();
    }
}

if (isset($_GET['q']) && $_GET['q'] == 1) {
    // Reset server timer on Q1 load
    $_SESSION['exam_start_time_server'] = time();
    // Allow new attempt
    if(isset($_SESSION['exam_completed'])) unset($_SESSION['exam_completed']);
    
    // Also ensuring score is reset happens usually elsewhere or we rely on explicit start
    // But Process.php resets it if unset.
    // Ideally we'd unset score here too if it's a restart.
    if(isset($_SESSION['score'])) unset($_SESSION['score']);
    if(isset($_SESSION['user_answers'])) unset($_SESSION['user_answers']);
}

$examId = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : (isset($_POST['exam_id']) ? (int)$_POST['exam_id'] : 1);

if (isset($_GET['q'])) {
    $quesnumber = (int) $_GET['q'];
} else {
    header("Location:exam");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $process = $pro->getProcessData($_POST);
}

$total    = $exam->getTotalRows($examId);
$question = $exam->getQuestionNumber($quesnumber, $examId);

if (!$question) {
    // If trying to access non-existent Q (e.g. reload after finish), go to final?
    // Or just show error.
    // Usually Process redirects to final if q == total.
    echo "<div class='container'><p>Question not found.</p><a href='exam'>Back to Exams</a></div>";
    include __DIR__ . '/partials/footer.php';
    exit();
}
?>

<style>
    /* Direct Embed Debug/Fix - FORCE VISIBILITY */
    body {
        color: #f1f5f9 !important; /* Force global white text */
    }
    .test-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1.5rem;
    }
    .question-progress {
        font-size: 1.2rem;
        font-weight: 700;
        color: #cbd5e1 !important; /* Light Grey */
        opacity: 0.9;
    }
    .question-text {
        font-size: 1.5rem;
        font-weight: 600;
        color: #ffffff !important; /* Pure White */
        margin-bottom: 2rem;
        line-height: 1.5;
    }
    .option-card {
        display: flex !important;
        align-items: center;
        padding: 1.2rem;
        margin-bottom: 1rem;
        background: #0f172a;
        border: 2px solid #334155;
        border-radius: 12px;
        cursor: pointer;
        transition: all 0.2s;
        width: 100%;
        box-sizing: border-box;
    }
    .option-card:hover {
        border-color: #6366f1;
        background: rgba(99, 102, 241, 0.1);
    }
    .option-card.selected {
        border-color: #a855f7 !important;
        background: rgba(168, 85, 247, 0.15) !important;
    }
    .custom-radio {
        width: 24px;
        height: 24px;
        min-width: 24px; /* Prevent shrinking */
        border: 2px solid #94a3b8;
        border-radius: 50%;
        margin-right: 1.2rem;
        position: relative;
    }
    .option-card.selected .custom-radio {
        background: #a855f7;
        border-color: #a855f7;
    }
    .option-text {
        font-size: 1.1rem;
        color: #f1f5f9 !important;
    }
    .test-card {
        background: #1a2335;
        padding: 2.5rem;
        border-radius: 16px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
        border: 1px solid rgba(255,255,255,0.05);
    }
</style>

 <div class="container" style="max-width: 800px; margin: 0 auto; padding: 20px;">
    
    <div class="test-header">
        <div class="question-progress">Question <?php echo $question['quesNo']; ?> of <?php echo $total; ?></div>
        <div id="exam-timer" style="font-size: 1.2rem; font-weight: 700; color: #f87171; background: rgba(248, 113, 113, 0.1); padding: 0.5rem 1rem; border-radius: 8px; border: 1px solid rgba(248, 113, 113, 0.2);">
            ⏱️ <span id="time-display">00:00</span>
        </div>
    </div>

    <div class="test-card">
        <form method="post" action="">
            <input type="hidden" name="exam_id" value="<?php echo $examId; ?>">
            
            <h3 class="question-text"><?php echo $question['quesNo'] . ". " . $question['ques']; ?></h3>
            
            <div class="options-grid">
            <?php
            $answer = $exam->getAnswer($quesnumber, $examId);
            if ($answer) {
                while ($result = $answer->fetch_assoc()) {
            ?>
                <label class="option-card" onclick="selectOption(this)">
                    <div class="custom-radio"></div>
                    <input type="radio" name="ans" required value="<?php echo $result['id']; ?>" style="display:none;" />
                    <span class="option-text"><?php echo $result['ans']; ?></span>
                </label>
            <?php 
                }
            }
            ?>
            </div>
            
            <div style="margin-top: 2rem;">
                <input type="submit" name="submit" value="Next Question" class="btn btn-primary btn-block" />
                <input type="hidden" name="quesnumber" value="<?php echo $quesnumber; ?>" />
            </div>
        </form>
    </div>
</div>

<script>
function selectOption(element) {
    // Remove selected class from all options
    document.querySelectorAll('.option-card').forEach(el => el.classList.remove('selected'));
    // Add selected class to clicked option
    element.classList.add('selected');
    // Select the radio button inside
    const radio = element.querySelector('input[type="radio"]');
    if (radio) radio.checked = true;
}

// --- Timer Logic ---
document.addEventListener('DOMContentLoaded', function() {
    const EXAM_DURATION_MINS = 30;
    const END_TIME_KEY = 'exam_end_time';
    const examId = "<?php echo $examId; ?>"; // Unique key per exam if needed
    const quesNo = "<?php echo $question['quesNo']; ?>";
    
    // Clear timer if this is a fresh start (Question 1) AND referrer was NOT test.php (very basic check)
    // Better: If Q1 and no time set, set it.
    
    const START_TIME_KEY = 'exam_start_time';
    let endTime = localStorage.getItem(END_TIME_KEY);
    
    // Force reset if Question 1
    if (quesNo == "1") {
        const now = new Date().getTime();
        endTime = now + (EXAM_DURATION_MINS * 60 * 1000);
        localStorage.setItem(END_TIME_KEY, endTime);
        localStorage.setItem(START_TIME_KEY, now);
        // Clear previous finish time
        localStorage.removeItem('exam_finish_time');
    } 
    else if (!endTime) {
        // Fallback for Q > 1 with no timer (rare)
        const now = new Date().getTime();
        endTime = now + (EXAM_DURATION_MINS * 60 * 1000);
        localStorage.setItem(END_TIME_KEY, endTime);
        localStorage.setItem(START_TIME_KEY, now);
    }

    const timerDisplay = document.getElementById('time-display');
    const timerContainer = document.getElementById('exam-timer');

    function updateTimer() {
        const now = new Date().getTime();
        const distance = endTime - now;

        if (distance < 0) {
            clearInterval(interval);
            timerDisplay.innerText = "00:00";
            alert("Time's up! Submitting exam...");
            // Clear storage
            localStorage.removeItem(END_TIME_KEY);
            // Redirect to finish
            window.location.href = "final";
            return;
        }

        // Calculations
        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

        // Styling for low time (last 5 mins)
        if (minutes < 5) {
            timerContainer.style.background = "rgba(239, 68, 68, 0.2)";
            timerContainer.style.animation = "pulse 1s infinite";
        }

        timerDisplay.innerText = 
            (minutes < 10 ? "0" + minutes : minutes) + ":" + 
            (seconds < 10 ? "0" + seconds : seconds);
    }

    const interval = setInterval(updateTimer, 1000);
    updateTimer(); // Initial call
});
</script>

<style>
@keyframes pulse {
    0% { opacity: 1; transform: scale(1); }
    50% { opacity: 0.8; transform: scale(1.05); }
    100% { opacity: 1; transform: scale(1); }
}
</style>