<?php include __DIR__ . '/partials/header.php'; ?>

<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 1rem;">
    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 2rem;">
        <div>
            <h1 class="page-title" style="margin: 0; text-align: left;">Live Monitoring</h1>
            <p style="color: #94a3b8; margin: 5px 0 0 0;">Real-time exam session tracking</p>
        </div>
        <div style="display: flex; gap: 10px;">
             <span style="display: flex; align-items: center; gap: 5px; color: #4ade80; background: rgba(74, 222, 128, 0.1); padding: 5px 12px; border-radius: 20px; font-size: 0.85rem;">
                 <span style="width: 8px; height: 8px; background: #4ade80; border-radius: 50%; box-shadow: 0 0 10px #4ade80;"></span> Live
             </span>
        </div>
    </div>

    <!-- Live Stats Row -->
    <div style="display: grid; grid-template-columns: repeat(3, 1fr); gap: 1.5rem; margin-bottom: 2rem;">
        <div class="card" style="background: #1a2335; border: 1px solid rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 12px; display: flex; align-items: center; gap: 1rem;">
            <div style="background: rgba(34, 211, 238, 0.1); color: #22d3ee; padding: 10px; border-radius: 8px; font-size: 1.5rem;">👨‍💻</div>
            <div>
                <div style="font-size: 1.5rem; font-weight: 700; color: white;"><?php echo $stats['active_students']; ?></div>
                <div style="color: #94a3b8; font-size: 0.9rem;">Total Active Students</div>
            </div>
        </div>
        <div class="card" style="background: #1a2335; border: 1px solid rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 12px; display: flex; align-items: center; gap: 1rem;">
            <div style="background: rgba(244, 114, 182, 0.1); color: #f472b6; padding: 10px; border-radius: 8px; font-size: 1.5rem;">📝</div>
            <div>
                <div style="font-size: 1.5rem; font-weight: 700; color: white;"><?php echo $stats['active_exams']; ?></div>
                <div style="color: #94a3b8; font-size: 0.9rem;">Enabled Exams</div>
            </div>
        </div>
        <div class="card" style="background: #1a2335; border: 1px solid rgba(255,255,255,0.05); padding: 1.5rem; border-radius: 12px; display: flex; align-items: center; gap: 1rem;">
            <div style="background: rgba(251, 191, 36, 0.1); color: #fbbf24; padding: 10px; border-radius: 8px; font-size: 1.5rem;">⚠️</div>
            <div>
                <div style="font-size: 1.5rem; font-weight: 700; color: white;"><?php echo $stats['alerts']; ?></div>
                <div style="color: #94a3b8; font-size: 0.9rem;">Alerts</div>
            </div>
        </div>
    </div>

    <!-- Active Sessions / Recent Activity Table -->
    <div class="card" style="background: #1a2335; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); overflow: hidden;">
        <div style="padding: 1.5rem; border-bottom: 1px solid rgba(255,255,255,0.05);">
            <h3 style="margin: 0; color: #f8fafc; font-size: 1.1rem;">Recent Activity</h3>
        </div>
        
        <?php if (!empty($stats['recent_activity'])) { ?>
            <table style="width: 100%; border-collapse: collapse; color: #f8fafc;">
                <thead>
                    <tr style="background: rgba(255,255,255,0.05); text-align: left;">
                        <th style="padding: 1rem; font-weight: 600;">Student</th>
                        <th style="padding: 1rem; font-weight: 600;">Exam</th>
                        <th style="padding: 1rem; font-weight: 600;">Score</th>
                        <th style="padding: 1rem; font-weight: 600;">Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($stats['recent_activity'] as $act) { 
                        $pct = ($act['total'] > 0) ? round(($act['score'] / $act['total']) * 100) : 0;
                        $color = ($pct >= 50) ? '#4ade80' : '#f87171';
                    ?>
                    <tr style="border-bottom: 1px solid rgba(255,255,255,0.05);">
                        <td style="padding: 1rem;"><?php echo $act['student_name']; ?></td>
                        <td style="padding: 1rem; color: #cbd5e1;"><?php echo $act['exam_name']; ?></td>
                        <td style="padding: 1rem;">
                            <span style="color: <?php echo $color; ?>; font-weight: bold;"><?php echo $act['score']; ?>/<?php echo $act['total']; ?> (<?php echo $pct; ?>%)</span>
                        </td>
                        <td style="padding: 1rem; color: #94a3b8; font-size: 0.9rem;">
                            <?php echo date('M d, H:i', strtotime($act['attempt_date'])); ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        <?php } else { ?>
            <div style="padding: 3rem; text-align: center;">
                <div style="font-size: 3rem; margin-bottom: 1rem; opacity: 0.5;">📡</div>
                <h3 style="color: #f8fafc; margin-bottom: 0.5rem;">System Idle</h3>
                <p style="color: #94a3b8; max-width: 400px; margin: 0 auto;">No recent exam activity recorded.</p>
            </div>
        <?php } ?>
    </div>
</div>
</body>
</html>
