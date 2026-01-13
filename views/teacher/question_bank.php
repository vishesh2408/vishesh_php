<?php
include __DIR__ . '/partials/header.php';
use App\Models\Exam;
$exam = new Exam();

// Handle Delete Logic
if (isset($_GET['delque'])) {
    $delId = (int)$_GET['delque'];
    $delresult = $exam->deleteQuestion($delId);
}

// Filter Logic
$filterExamId = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 0;
$examsList = $exam->getExams(100); 
?>

<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 1rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 class="page-title" style="margin: 0; text-align: left;">Question Bank</h1>
            <p style="color: #94a3b8; margin: 5px 0 0 0;">Manage questions for your exams</p>
        </div>
        <a href="/teacher/question-add" class="btn btn-primary" style="width: auto;">+ Add New Question</a>
    </div>

    <?php if (isset($delresult)) echo $delresult; ?>

    <!-- Filter Card -->
    <div style="background: #1a2335; padding: 1.5rem; border-radius: 12px; margin-bottom: 2rem; border: 1px solid rgba(255,255,255,0.05); display: flex; align-items: center; gap: 1rem;">
        <label style="color: #f8fafc; font-weight: 500;">Filter by Exam:</label>
        <form method="get" action="" style="display: flex; flex-grow: 1;">
            <select name="exam_id" onchange="this.form.submit()" style="flex-grow: 1; max-width: 300px; padding: 0.8rem; border-radius: 8px; border: 1px solid rgba(255,255,255,0.1); background: rgba(0,0,0,0.2); color: white; cursor: pointer;">
                <option value="0">Show All Questions</option>
                <?php 
                if ($examsList) {
                    while ($row = $examsList->fetch_assoc()) {
                        $selected = ($row['id'] == $filterExamId) ? 'selected' : '';
                        echo "<option value='{$row['id']}' $selected>{$row['name']}</option>";
                    }
                }
                ?>
            </select>
        </form>
    </div>

    <!-- Questions Table -->
    <div class="card" style="background: #1a2335; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); overflow: hidden;">
        <table style="width: 100%; border-collapse: collapse; color: #f8fafc;">
            <thead>
                <tr style="background: rgba(255,255,255,0.05); text-align: left;">
                    <th style="padding: 1rem; font-weight: 600; width: 80px;">No.</th>
                    <th style="padding: 1rem; font-weight: 600; width: 250px;">Exam</th>
                    <th style="padding: 1rem; font-weight: 600;">Question Content</th>
                    <th style="padding: 1rem; font-weight: 600; width: 150px;">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $questionData = $exam->getqueData($filterExamId);
                if ($questionData) {
                    while ($result = $questionData->fetch_assoc()) {
                        $examName = isset($result['exam_name']) ? $result['exam_name'] : '-';
                ?>
                <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                    <td style="padding: 1rem; color: #94a3b8;">#<?php echo $result['quesNo']; ?></td>
                    <td style="padding: 1rem;">
                        <span style="font-size: 0.85rem; background: rgba(99, 102, 241, 0.2); color: #818cf8; padding: 4px 10px; border-radius: 20px;"><?php echo $examName; ?></span>
                    </td>
                    <td style="padding: 1rem; line-height: 1.5;"><?php echo $result['ques']; ?></td>
                    <td style="padding: 1rem;">
                        <!-- TODO: Add Edit Page -->
                        <!-- <a href="/teacher/question-edit?id=<?php echo $result['id']; ?>" style="color: #60a5fa; text-decoration: none; margin-right: 15px;">Edit</a> -->
                        <a onclick="return confirm('Delete Question?')" href="?delque=<?php echo $result['id']; ?>" style="color: #f87171; text-decoration: none;">Delete</a>
                    </td>
                </tr>
                <?php } } else { ?>
                    <tr>
                        <td colspan="4" style="text-align: center; padding: 3rem;">
                            <div style="font-size: 2rem; margin-bottom: 1rem;">📭</div>
                            <p style="color: #94a3b8;">No questions found for this selection.</p>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>

</body>
</html>
