<?php include __DIR__ . '/partials/header.php'; ?>
<?php
if (isset($_GET['del'])) {
    $id = (int)$_GET['del'];
    $delExam = $exam->deleteExam($id);
}

if (isset($_GET['publish'])) {
    $id = (int)$_GET['publish'];
    $pubMsg = $exam->publishResults($id);
}
?>

<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 1rem;">
    <div style="margin-bottom: 2rem; display: flex; align-items: center; justify-content: space-between;">
         <h1 class="page-title" style="margin: 0;">Manage Exams</h1>
    </div>

    <?php
    if (isset($delExam)) echo $delExam;
    if (isset($pubMsg)) echo $pubMsg;
    ?>
    <?php if (isset($exams) && $exams) { ?>
        <div class="card" style="background: #1a2335; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse; color: #f8fafc;">
                <thead>
                    <tr style="background: rgba(255,255,255,0.05); text-align: left;">
                        <th style="padding: 1rem; font-weight: 600;">ID</th>
                        <th style="padding: 1rem; font-weight: 600;">Exam Name</th>
                        <th style="padding: 1rem; font-weight: 600;">Time Limit</th>
                        <th style="padding: 1rem; font-weight: 600;">Status</th>
                        <th style="padding: 1rem; font-weight: 600;">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $exams->fetch_assoc()) { 
                        $statusClass = $row['status'] == 1 ? 'color: #4ade80;' : 'color: #94a3b8;';
                        $statusText = $row['status'] == 1 ? 'Active' : 'Disabled';
                    ?>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td style="padding: 1rem;"><?php echo $row['id']; ?></td>
                        <td style="padding: 1rem; font-weight: 500;"><?php echo $row['name']; ?></td>
                        <td style="padding: 1rem;"><?php echo $row['time_limit']; ?> mins</td>
                        <td style="padding: 1rem; <?php echo $statusClass; ?>"><?php echo $statusText; ?></td>
                        <td style="padding: 1rem;">
                            <a href="/teacher/exam-edit?id=<?php echo $row['id']; ?>" style="color: #60a5fa; text-decoration: none; margin-right: 15px;">Edit</a>
                            <?php if(isset($row['auto_evaluate']) && $row['auto_evaluate'] == 0) { ?>
                                <a href="?publish=<?php echo $row['id']; ?>" class="btn btn-outline" style="padding: 0.3rem 0.8rem; font-size: 0.8rem; border-color: #facc15; color: #facc15; margin-right: 15px; text-decoration: none;">📢 Publish Results</a>
                            <?php } ?>
                            <a href="/teacher/download-results?exam_id=<?php echo $row['id']; ?>" class="btn btn-outline" style="padding: 0.3rem 0.8rem; font-size: 0.8rem; border-color: #22d3ee; color: #22d3ee; text-decoration: none;">Download Results</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="card" style="background: #1a2335; border-radius: 12px; padding: 2rem; border: 1px solid rgba(255,255,255,0.05); text-align: center;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">📝</div>
            <h3 style="color: #f8fafc; margin-bottom: 0.5rem;">No Exams Found</h3>
            <p style="color: #94a3b8;">You haven't created any exams yet. Click the button above to get started.</p>
        </div>
    <?php } ?>
</div>

</body>
</html>
