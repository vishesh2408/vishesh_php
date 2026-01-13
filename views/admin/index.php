<?php 
    include __DIR__ . '/partials/header.php';
    // Get Stats
    $userCount = $db->link->query("SELECT COUNT(*) as c FROM tbl_user WHERE role=0")->fetch_assoc()['c'];
    $adminCount = $db->link->query("SELECT COUNT(*) as c FROM tbl_user WHERE role=1")->fetch_assoc()['c'];
    $quesCount = $db->link->query("SELECT COUNT(*) as c FROM tbl_ques")->fetch_assoc()['c'];
?>

<div class="admin-header">
    <h1 class="admin-title">Dashboard Overview</h1>
</div>

<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-info">
            <h3>Registered Students</h3>
            <p><?php echo $userCount; ?></p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">❓</div>
        <div class="stat-info">
            <h3>Total Questions</h3>
            <p><?php echo $quesCount; ?></p>
        </div>
    </div>
    
    <div class="stat-card">
        <div class="stat-icon">🛡️</div>
        <div class="stat-info">
            <h3>Administrators</h3>
            <p><?php echo $adminCount; ?></p>
        </div>
    </div>
</div>

<div class="table-container">
    <h3 style="margin-bottom: 1rem;">Recent Questions</h3>
    <?php
    $query = "SELECT * FROM tbl_ques ORDER BY quesNo DESC LIMIT 5";
    $result = $db->select($query);
    if ($result) {
    ?>
    <table class="custom-table">
        <thead>
            <tr>
                <th width="10%">No.</th>
                <th>Question</th>
                <th width="15%">Action</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($result as $row) { ?>
            <tr>
                <td><?php echo $row['quesNo']; ?></td>
                <td><?php echo $row['ques']; ?></td>
                <td>
                    <a class="action-btn btn-danger" onclick="return confirm('Remove Question?')" href="delques.php?delques=<?php echo $row['quesNo']; ?>">Remove</a>
                </td>
            </tr>
        <?php } ?>
        </tbody>
    </table>
    <?php } else { echo "<p>No questions found.</p>"; } ?>
</div>

<?php // include __DIR__ . '/partials/footer.php'; // Footer not needed in dash if wrapper used ?>
</div> <!-- Closing admin-wrapper -->
</body>
</html>