<?php include __DIR__ . '/partials/header.php'; ?>

<div class="container" style="max-width: 1200px; margin: 0 auto; padding: 1rem;">
    <div style="margin-bottom: 2rem;">
        <h1 class="page-title" style="margin: 0; text-align: left;">Performance Analytics</h1>
        <div style="display: flex; justify-content: space-between; align-items: flex-end;">
            <p style="color: #94a3b8; margin: 5px 0 0 0;">Insights into student performance and exam difficulty</p>
            <form action="" method="get" style="display: flex; gap: 0.5rem; align-items: center;">
                <select name="exam_id" onchange="this.form.submit()" style="background: #1a2335; border: 1px solid rgba(255,255,255,0.1); color: #fff; padding: 0.5rem 1rem; border-radius: 8px;">
                    <option value="">All Exams</option>
                    <?php 
                    if (isset($allExams)) {
                        while($e = $allExams->fetch_assoc()) {
                            $selected = (isset($_GET['exam_id']) && $_GET['exam_id'] == $e['id']) ? 'selected' : '';
                            echo "<option value='".$e['id']."' $selected>".htmlspecialchars($e['name'])."</option>";
                        }
                    }
                    ?>
                </select>
                <!-- <button type="submit" class="btn btn-primary" style="padding: 0.5rem 1rem;">Filter</button> -->
            </form>
        </div>
    </div>

    <!-- Key Metrics -->
    <div style="display: grid; grid-template-columns: repeat(auto-fit, minmax(250px, 1fr)); gap: 1.5rem; margin-bottom: 2rem;">
        <div class="card" style="background: #1a2335; padding: 1.5rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
            <div style="color: #94a3b8; font-size: 0.9rem; margin-bottom: 0.5rem;">Average Score</div>
            <div style="font-size: 2rem; font-weight: 700; color: #f8fafc;"><?php echo $stats['avg_score']; ?>%</div>
            <!-- <div style="color: #4ade80; font-size: 0.8rem; margin-top: 0.5rem;">↑ 2.5% vs last month</div> -->
        </div>
        <div class="card" style="background: #1a2335; padding: 1.5rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
            <div style="color: #94a3b8; font-size: 0.9rem; margin-bottom: 0.5rem;">Total Attempts</div>
            <div style="font-size: 2rem; font-weight: 700; color: #f8fafc;"><?php echo $stats['total_attempts']; ?></div>
        </div>
        <div class="card" style="background: #1a2335; padding: 1.5rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
            <div style="color: #94a3b8; font-size: 0.9rem; margin-bottom: 0.5rem;">Pass Rate</div>
            <div style="font-size: 2rem; font-weight: 700; color: #f8fafc;"><?php echo $stats['pass_rate']; ?>%</div>
        </div>
        <div class="card" style="background: #1a2335; padding: 1.5rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05);">
            <div style="color: #94a3b8; font-size: 0.9rem; margin-bottom: 0.5rem;">Top Performer</div>
            <div style="font-size: 1.5rem; font-weight: 700; color: #f8fafc;"><?php echo $stats['top_student']; ?></div>
            <div style="color: #facc15; font-size: 0.8rem;"><?php echo $stats['top_student_score']; ?>% Avg</div>
        </div>
    </div>

    <!-- Charts -->
    <div style="display: grid; grid-template-columns: 2fr 1fr; gap: 1.5rem;">
        <div class="card" style="background: #1a2335; padding: 1.5rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); min-height: 350px;">
            <h3 style="color: #f8fafc; margin-bottom: 1rem; font-size: 1.1rem;">Score Distribution</h3>
            <canvas id="scoreChart"></canvas>
        </div>
        <div class="card" style="background: #1a2335; padding: 1.5rem; border-radius: 12px; border: 1px solid rgba(255,255,255,0.05); min-height: 350px;">
             <h3 style="color: #f8fafc; margin-bottom: 1rem; font-size: 1.1rem;">Most Difficult Exams</h3>
             <canvas id="topicChart"></canvas>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
const ctx1 = document.getElementById('scoreChart').getContext('2d');
const scoreChart = new Chart(ctx1, {
    type: 'bar',
    data: {
        labels: ['< 40%', '40% - 60%', '60% - 80%', '> 80%'],
        datasets: [{
            label: 'Students',
            data: <?php echo json_encode($chartData['score_dist']); ?>,
            backgroundColor: [
                'rgba(248, 113, 113, 0.6)',
                'rgba(250, 204, 21, 0.6)',
                'rgba(96, 165, 250, 0.6)',
                'rgba(74, 222, 128, 0.6)'
            ],
            borderColor: [
                'rgba(248, 113, 113, 1)',
                'rgba(250, 204, 21, 1)',
                'rgba(96, 165, 250, 1)',
                'rgba(74, 222, 128, 1)'
            ],
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                grid: { color: 'rgba(255, 255, 255, 0.1)' },
                ticks: { color: '#94a3b8' }
            },
            x: {
                grid: { display: false },
                ticks: { color: '#94a3b8' }
            }
        }
    }
});

const ctx2 = document.getElementById('topicChart').getContext('2d');
const topicChart = new Chart(ctx2, {
    type: 'doughnut',
    data: {
        labels: <?php echo json_encode(array_column($chartData['difficult_topics'], 'name')); ?>,
        datasets: [{
            label: 'Avg Score',
            data: <?php echo json_encode(array_column($chartData['difficult_topics'], 'score')); ?>,
            backgroundColor: [
                'rgba(239, 68, 68, 0.7)',
                'rgba(249, 115, 22, 0.7)',
                'rgba(234, 179, 8, 0.7)',
                'rgba(168, 85, 247, 0.7)',
                'rgba(59, 130, 246, 0.7)'
            ],
            borderWidth: 0
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { 
                position: 'bottom',
                labels: { color: '#94a3b8' }
            }
        }
    }
});
</script>

</body>
</html>
