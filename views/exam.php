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

<div style="width: 100%; padding: 2rem; margin: 0;">
    <div class="page-title" style="text-align: center; margin-bottom: 0.5rem;">Available Exams</div>
    <div class="page-subtitle" style="text-align: center; margin-bottom: 2rem;">Select an exam to start testing your knowledge</div>
    
    <?php
    $page = isset($_GET['page']) && $_GET['page'] > 0 ? (int)$_GET['page'] : 1;
    $limit = 6; // Items per page
    $offset = ($page - 1) * $limit;
    
    $totalExams = $exam->getTotalExams();
    $totalPages = ceil($totalExams / $limit);
    ?>

    <div style="display: flex; flex-wrap: wrap; gap: 1.5rem; justify-content: flex-start; width: 100%;">
        <?php 
        $exams = $exam->getExams($limit, $offset);
        if ($exams) {
            while ($row = $exams->fetch_assoc()) {
                if ($row['status'] == 0) continue; // Skip inactive
                $qCount = $exam->getTotalRows($row['id']);
                ?>
                <div style="background: #1a2335; padding: 2rem; border-radius: 12px; box-shadow: var(--shadow-md); transition: transform 0.3s; display: flex; flex-direction: column; justify-content: space-between; flex: 0 0 320px; max-width: 100%; border: 1px solid rgba(255,255,255,0.05);">
                    <div>
                        <h3 style="font-size: 1.5rem; color: var(--primary-color); margin-bottom: 0.5rem;"><?php echo $row['name']; ?></h3>
                        <div style="color: var(--text-muted); font-size: 0.95rem; margin-bottom: 1.5rem;">
                            <div style="display: flex; align-items: center; gap: 0.5rem; margin-bottom: 0.25rem;">
                                <span>⏱</span> <?php echo $row['time_limit']; ?> Minutes
                            </div>
                            <div style="display: flex; align-items: center; gap: 0.5rem;">
                                <span>❓</span> <?php echo $qCount; ?> Questions
                            </div>
                        </div>
                    </div>
                    
                    <?php 
                    $now = new DateTime();
                    $start = !empty($row['start_time']) ? new DateTime($row['start_time']) : null;
                    $end = !empty($row['end_time']) ? new DateTime($row['end_time']) : null;
                    $isScheduled = isset($row['is_scheduled']) && $row['is_scheduled'] == 1;
                    
                    $btnState = 'active';
                    $btnMsg = 'Start Exam';
                    
                    if ($isScheduled) {
                        if ($start && $now < $start) {
                            $btnState = 'disabled';
                            $btnMsg = 'Starts: ' . $start->format('M d, H:i');
                        } elseif ($end && $now > $end) {
                            $btnState = 'disabled';
                            $btnMsg = 'Expired';
                        }
                    }
                    
                    if ($qCount > 0 && $btnState == 'active') { ?>
                        <a href="starttest?exam_id=<?php echo $row['id']; ?>" class="btn btn-primary">Start Exam</a>
                    <?php } elseif ($btnState == 'disabled') { ?>
                         <button disabled class="btn btn-outline" style="opacity: 0.6; cursor: not-allowed; border-color: var(--text-muted); color: var(--text-muted);"><?php echo $btnMsg; ?></button>
                    <?php } else { ?>
                         <button disabled class="btn btn-outline" style="opacity: 0.6; cursor: not-allowed;">Coming Soon</button>
                    <?php } ?>
                </div>
                <?php
            }
        } else {
            echo "<p style='text-align: left; width: 100%; color: var(--text-muted);'>No exams available at the moment.</p>";
        }
        ?>
    </div>
    
    <!-- Pagination -->
    <?php if ($totalPages > 1) { ?>
    <div style="margin-top: 3rem; display: flex; justify-content: center; gap: 0.5rem;">
        <?php if ($page > 1) { ?>
            <a href="?page=<?php echo $page-1; ?>" class="btn btn-outline" style="padding: 0.5rem 1rem;">&laquo; Prev</a>
        <?php } ?>
        
        <?php for($i=1; $i<=$totalPages; $i++) { ?>
            <a href="?page=<?php echo $i; ?>" class="btn <?php echo ($i == $page) ? 'btn-primary' : 'btn-outline'; ?>" style="padding: 0.5rem 1rem;"><?php echo $i; ?></a>
        <?php } ?>
        
        <?php if ($page < $totalPages) { ?>
            <a href="?page=<?php echo $page+1; ?>" class="btn btn-outline" style="padding: 0.5rem 1rem;">Next &raquo;</a>
        <?php } ?>
    </div>
    <?php } ?>
</div>

