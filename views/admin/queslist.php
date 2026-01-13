<?php 
include __DIR__ . '/partials/header.php';
use App\Models\Exam;
$exam = new Exam();

if (isset($_GET['delque'])) {
    $delId = (int)$_GET['delque']; // This is actually ID now, wait, getdelresult used quesNo
    // I should update getdelresult to use ID, but I didn't update logic fully in model yet.
    // I updated deleteQuestion($id) in model. Use that instead.
    $delresult = $exam->deleteQuestion($delId);
}

// Filter Exam
$filterExamId = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : 0;
// Get Active Exams for filter
$examsList = $exam->getExams(); 

?>

<div class="admin-header">
    <h1 class="admin-title">Manage Questions</h1>
    <a href="quesadd" class="btn btn-primary" style="width: auto; padding: 0.5rem 1rem;">+ Add Question</a>
</div>

<?php if (isset($delresult)) echo $delresult; ?>

<div class="table-container">
    <div style="padding: 1rem; border-bottom: 1px solid var(--border-color); display: flex; align-items: center; gap: 1rem;">
        <label>Filter by Exam:</label>
        <form method="get" action="" style="display: flex;">
             <select name="exam_id" class="form-control" onchange="this.form.submit()" style="width: auto; padding: 0.4rem 2rem 0.4rem 1rem;">
                <option value="0">All Exams</option>
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

    <table class="custom-table">
        <thead>
            <tr>
                <th width="10%">No.</th>
                <th>Exam</th>
                <th>Question</th>
                <th width="15%">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php
        $questionData = $exam->getqueData($filterExamId); // Updated method accepts examId
        if ($questionData) {
            
            while ($result = $questionData->fetch_assoc()) {
                // If filtering by ALL, showing exam name is useful.
                $examName = isset($result['exam_name']) ? $result['exam_name'] : '-';
        ?>
            <tr>
                <td><?php echo $result['quesNo']; ?></td>
                <td><span style="font-size: 0.85rem; background:#f3f4f6; padding: 2px 6px; border-radius: 4px;"><?php echo $examName; ?></span></td>
                <td><?php echo $result['ques']; ?></td>
                <td>
                    <a class="action-btn btn-info" href="ques/edit?id=<?php echo $result['id']; ?>">Edit</a>
                    <a class="action-btn btn-danger" onclick="return confirm('Delete Question?')" href="?delque=<?php echo $result['id']; ?>">Remove</a>
                </td>
            </tr>
        <?php } } else { ?>
            <tr><td colspan="4" style="text-align:center;">No questions found.</td></tr>
        <?php } ?>
        </tbody>
    </table>
</div>

</div> <!-- Close wrapper -->
</body>
</html>