<?php include __DIR__ . '/partials/header.php'; ?>

<div class="container" style="max-width: 800px; margin: 0 auto; padding: 2rem;">
    <div id="no-print" style="margin-bottom: 2rem;">
        <a href="/teacher/evaluation?tab=all" style="color: #94a3b8; text-decoration: none;">&larr; Back to Evaluation</a>
    </div>

    <div id="printable-area">
        <!-- Print Header (Visible only in print) -->
        <div class="print-header" style="text-align: center; margin-bottom: 2rem; display: none;">
            <div style="font-size: 2rem; font-weight: 800; color: #6366f1; display: flex; align-items: center; justify-content: center; gap: 10px;">
                <span>⚡</span> QuizNest
            </div>
            <p style="color: #666; font-size: 0.9rem; margin: 5px 0;">Excellence in Online Assessment</p>
        </div>

        <div class="card" style="background: #1a2335; border-radius: 16px; padding: 3rem; border: 1px solid rgba(255,255,255,0.05); text-align: center;">
            
            <div style="width: 80px; height: 80px; background: rgba(99, 102, 241, 0.1); border-radius: 50%; display: flex; align-items: center; justify-content: center; margin: 0 auto 1.5rem; color: #6366f1; font-size: 2rem;">
                🏆
            </div>

            <h1 style="color: #f8fafc; margin-bottom: 0.5rem;"><?php echo htmlspecialchars($result['exam_name']); ?></h1>
            <p style="color: #94a3b8; font-size: 1.1rem;">Report Card</p>

            <div style="margin: 2rem 0; padding: 2rem; background: rgba(255,255,255,0.02); border-radius: 12px; display: grid; grid-template-columns: 1fr 1fr; gap: 2rem; text-align: left;">
                <div>
                    <div style="color: #94a3b8; font-size: 0.9rem;">Student Name</div>
                    <div style="color: #f8fafc; font-size: 1.2rem; font-weight: 600;"><?php echo htmlspecialchars($result['user_name']); ?></div>
                </div>
                <div>
                    <div style="color: #94a3b8; font-size: 0.9rem;">Email</div>
                    <div style="color: #f8fafc; font-size: 1.1rem;"><?php echo htmlspecialchars($result['email']); ?></div>
                </div>
                <div>
                     <div style="color: #94a3b8; font-size: 0.9rem;">Date Taken</div>
                     <div style="color: #f8fafc; font-size: 1.1rem;"><?php echo date('M d, Y h:i A', strtotime($result['attempt_date'])); ?></div>
                </div>
                <div>
                     <div style="color: #94a3b8; font-size: 0.9rem;">Time Taken</div>
                     <div style="color: #f8fafc; font-size: 1.1rem;"><?php echo $result['time_taken']; ?></div>
                </div>
            </div>

            <div style="display: flex; justify-content: center; gap: 3rem; margin-bottom: 2rem;">
                <div>
                    <div style="font-size: 3.5rem; font-weight: 800; color: #10b981; line-height: 1;"><?php echo $result['score']; ?></div>
                    <div style="color: #94a3b8; margin-top: 5px;">Score Obtained</div>
                </div>
                <div style="border-left: 1px solid rgba(255,255,255,0.1);"></div>
                <div>
                    <div style="font-size: 3.5rem; font-weight: 800; color: #6366f1; line-height: 1;"><?php echo $result['total']; ?></div>
                    <div style="color: #94a3b8; margin-top: 5px;">Total Questions</div>
                </div>
            </div>

            <button onclick="window.print()" id="print-btn" class="btn btn-primary" style="padding: 0.8rem 2rem;">🖨️ Print Report</button>
        </div>

        <!-- Question Report Section -->
        <div class="question-report" style="margin-top: 3rem;">
            <h2 style="color: #f8fafc; margin-bottom: 1.5rem; text-align: center;">Question Paper & Correct Answers</h2>
            
            <?php 
            use App\Models\Exam;
            // Make sure we have instance if not passed (though we passed it in controller)
            if (!isset($examModel)) $examModel = new Exam();
            
            if (isset($questions) && $questions) {
            // Check if we have user answers detailing
            if (empty($userAnswers)) {
                echo "<div style='margin-bottom: 2rem; background: rgba(59, 130, 246, 0.1); border: 1px solid #3b82f6; color: #60a5fa; padding: 1rem; border-radius: 8px; font-size: 0.95rem; text-align: center;'>
                        ℹ️ Detailed answer history is not available for this attempt (it may be an older submission).
                      </div>";
            }
            
            while ($q = $questions->fetch_assoc()) {
            ?>
                <div style="background: #1a2335; margin-bottom: 1.5rem; padding: 1.5rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
                    <div style="color: #f8fafc; font-size: 1.1rem; font-weight: 500; margin-bottom: 1rem;">
                        <span style="color: #6366f1;">Q<?php echo $q['quesNo']; ?>.</span> <?php echo $q['ques']; ?>
                    </div>
                    
                    <div style="display: grid; grid-template-columns: 1fr 1fr; gap: 1rem;">
                        <?php 
                        $answers = $examModel->getAnswersByQuesNo($q['quesNo'], $q['exam_id']);
                        if ($answers) {
                            while ($ans = $answers->fetch_assoc()) {
                                $isCorrect = ($ans['rightAns'] == '1');
                                $userSelected = (isset($userAnswers[$q['quesNo']]) && $userAnswers[$q['quesNo']] == $ans['id']);
                                
                                $style = "padding: 0.8rem; border-radius: 8px; font-size: 0.95rem; border: 1px solid #334155; color: #94a3b8;";
                                $label = "";
                                
                                if ($isCorrect) {
                                    $style = "padding: 0.8rem; border-radius: 8px; font-size: 0.95rem; border: 1px solid #10b981; background: rgba(16, 185, 129, 0.1); color: #34d399; font-weight: 600;";
                                    $label = " ✓ (Correct)";
                                }
                                
                                if ($userSelected) {
                                    if ($isCorrect) {
                                         $label = " ✓ (Your Answer - Correct)";
                                    } else {
                                         $style = "padding: 0.8rem; border-radius: 8px; font-size: 0.95rem; border: 1px solid #ef4444; background: rgba(239, 68, 68, 0.1); color: #f87171; font-weight: 600;";
                                         $label = " ✗ (Your Answer - Wrong)";
                                    }
                                }
                        ?>
                            <div style="<?php echo $style; ?>">
                                <?php echo $ans['ans']; ?> 
                                <?php echo $label; ?>
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
                 echo "<p style='color: #94a3b8; text-align: center;'>No questions found for this exam.</p>";
            }
            ?>
        </div>
    </div>
</div>

<style>
@media print {
    body * {
        visibility: hidden;
    }
    #printable-area, #printable-area * {
        visibility: visible;
    }
    #printable-area {
        position: absolute;
        left: 0;
        top: 0;
        width: 100%;
    }
    .print-header {
        display: block !important;
    }
    #no-print, #print-btn {
        display: none !important;
    }
    .card, .question-report, .question-report > div {
        background: white !important;
        color: black !important;
        border: none !important; /* Remove dark borders */
        box-shadow: none !important;
    }
    .question-report > div {
        border-bottom: 1px solid #ddd !important; /* Add divider for print */
        margin-bottom: 2rem !important;
    }
    h1, h2, div, p, span {
        color: black !important;
    }
    /* Keep Correct Answer Green */
    div[style*="border: 1px solid #10b981"] {
        border: 2px solid #10b981 !important;
        background: #f0fdf4 !important;
        color: #166534 !important;
         -webkit-print-color-adjust: exact;
    }
}
</style>
</body>
</html>
