<?php include __DIR__ . '/partials/header.php'; ?>

<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 1rem;">
    <div style="margin-bottom: 2rem;">
        <h1 class="page-title" style="margin: 0; text-align: left;">Evaluation & Grading</h1>
        <p style="color: #94a3b8; margin: 5px 0 0 0;">Review exam submissions and provide feedback</p>
    </div>

    <?php 
    $tab = isset($_GET['tab']) ? $_GET['tab'] : 'pending'; 
    $activeStyle = "color: #f8fafc; border-bottom: 2px solid #6366f1; padding-bottom: 1rem; text-decoration: none; font-weight: 500;";
    $inactiveStyle = "color: #94a3b8; padding-bottom: 1rem; text-decoration: none;";
    ?>

    <!-- Tabs -->
    <div style="display: flex; gap: 1rem; margin-bottom: 2rem; border-bottom: 1px solid rgba(255,255,255,0.1); padding-bottom: 1rem;">
        <a href="?tab=pending" style="<?php echo $tab == 'pending' ? $activeStyle : $inactiveStyle; ?>">Pending Review</a>
        <a href="?tab=graded" style="<?php echo $tab == 'graded' ? $activeStyle : $inactiveStyle; ?>">Graded</a>
        <a href="?tab=all" style="<?php echo $tab == 'all' ? $activeStyle : $inactiveStyle; ?>">All Submissions</a>
    </div>

    <?php 
    // Filter logic: Currently all attempts are "auto-graded". 
    // So 'pending' should show empty. 'graded' and 'all' show the list.
    $showList = ($tab != 'pending');
    
    if ($showList && isset($attempts) && $attempts) { ?>
         <div class="card" style="background: #1a2335; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); overflow: hidden;">
            <table style="width: 100%; border-collapse: collapse; color: #f8fafc;">
                <thead>
                    <tr style="background: rgba(255,255,255,0.05); text-align: left;">
                        <th style="padding: 1rem; font-weight: 600;">Student</th>
                        <th style="padding: 1rem; font-weight: 600;">Exam</th>
                        <th style="padding: 1rem; font-weight: 600;">Score</th>
                        <th style="padding: 1rem; font-weight: 600;">Date</th>
                        <th style="padding: 1rem; font-weight: 600;">Status</th>
                        <th style="padding: 1rem; font-weight: 600;">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $attempts->fetch_assoc()) { 
                        $scorePercent = ($row['total'] > 0) ? round(($row['score'] / $row['total']) * 100) : 0;
                        $color = $scorePercent >= 50 ? '#4ade80' : '#f87171'; // Green Pass, Red Fail
                    ?>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td style="padding: 1rem; font-weight: 500;">
                            <?php echo $row['user_name'] ?? 'Unknown'; ?>
                        </td>
                        <td style="padding: 1rem;"><?php echo $row['exam_name']; ?></td>
                        <td style="padding: 1rem;">
                            <span style="font-weight: 700; color: <?php echo $color; ?>"><?php echo $row['score']; ?>/<?php echo $row['total']; ?></span>
                        </td>
                        <td style="padding: 1rem; color: #94a3b8; font-size: 0.9rem;">
                            <?php echo date('M d, Y h:i A', strtotime($row['attempt_date'])); ?>
                        </td>
                        <td style="padding: 1rem;">
                             <span style="background: rgba(255,255,255,0.05); padding: 4px 8px; border-radius: 4px; font-size: 0.85rem;">Auto-Graded</span>
                        </td>
                        <td style="padding: 1rem;">
                            <a href="/teacher/result-view?id=<?php echo $row['id']; ?>" class="btn btn-primary" style="padding: 0.4rem 1rem; font-size: 0.85rem; width: auto; text-decoration: none;">View Details</a>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    <?php } else { ?>
        <div class="card" style="background: #1a2335; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); text-align: center; padding: 4rem 2rem;">
            <div style="font-size: 3rem; margin-bottom: 1rem;">✅</div>
            <h3 style="color: #f8fafc; margin-bottom: 0.5rem;">All Caught Up!</h3>
            <p style="color: #94a3b8;">There are no grading records found.</p>
        </div>
    <?php } ?>
</div>
</body>
</html>
