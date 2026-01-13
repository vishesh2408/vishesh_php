<?php
namespace App\Controllers;

use App\Models\Exam;
use App\Models\User;

class TeacherController {
    public function dashboard() {
        include __DIR__ . '/../../views/teacher/index.php';
    }

    public function createExam() {
        include __DIR__ . '/../../views/teacher/exam_create.php';
    }

    public function exams() {
        $examModel = new Exam();
        $exams = $examModel->getExams(100); // Fetch up to 100 exams
        include __DIR__ . '/../../views/teacher/exams.php';
    }

    public function questionBank() {
        include __DIR__ . '/../../views/teacher/question_bank.php';
    }

    public function questionAdd() {
        include __DIR__ . '/../../views/teacher/question_add.php';
    }

    public function students() {
         include __DIR__ . '/../../views/teacher/students.php';
    }

    public function monitoring() {
         $userModel = new User();
         $stats = $userModel->getMonitoringStats();
         include __DIR__ . '/../../views/teacher/monitoring.php';
    }

    public function evaluation() {
         $userModel = new User();
         $attempts = $userModel->getAllAttempts(50);
         include __DIR__ . '/../../views/teacher/evaluation.php';
    }
    
    public function analytics() {
         $userModel = new User();
         $examModel = new Exam();
         
         $filterExamId = isset($_GET['exam_id']) ? (int)$_GET['exam_id'] : null;
         
         $stats = $userModel->getAnalytics($filterExamId);
         $chartData = $userModel->getChartData($filterExamId);
         $allExams = $examModel->getExams(100);
         
         include __DIR__ . '/../../views/teacher/analytics.php';
    }

    public function communication() {
         include __DIR__ . '/../../views/teacher/communication.php';
    }

    public function groups() {
        include __DIR__ . '/../../views/teacher/groups.php';
    }

    public function manageGroup() {
        include __DIR__ . '/../../views/teacher/group_manage.php';
    }

    public function downloadResults() {
        if (!isset($_GET['exam_id'])) {
            die("Exam ID missing.");
        }
        $examId = (int)$_GET['exam_id'];
        
        $examModel = new Exam();
        $examData = $examModel->getExamById($examId);
        if (!$examData) die("Exam not found.");
        
        $userModel = new User();
        // Fetch All Attempts for this exam with user details
        $attempts = $userModel->getAttemptsByExam($examId);
        
        // CSV Headers
        $filename = "Results_" . preg_replace('/[^a-zA-Z0-9]/', '_', $examData['name']) . "_" . date('Y-m-d') . ".csv";
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');
        
        $output = fopen('php://output', 'w');
        fputcsv($output, ['Student Name', 'Registration ID', 'Institution', 'Score', 'Total Questions', 'Time Taken', 'Completion Date']);
        
        if ($attempts) {
            while ($row = $attempts->fetch_assoc()) {
                $studentName = !empty($row['name']) ? $row['name'] : $row['userName'];
                fputcsv($output, [
                    $studentName,
                    $row['institution_id'] ?? 'N/A', 
                    $row['institution'] ?? 'N/A',
                    $row['score'],
                    $row['total'],
                    $row['time_taken'],
                    $row['attempt_date']
                ]);
            }
        }
        fclose($output);
        exit();
    }

    public function viewResult() {
        if (!isset($_GET['id'])) {
            die("Attempt ID missing.");
        }
        $attemptId = (int)$_GET['id'];
        $userModel = new User();
        $examModel = new Exam();
        
        $result = $userModel->getAttemptById($attemptId);
        
        if (!$result) die("Result not found.");
        
        $questions = $examModel->getqueData($result['examId']);
        $userAnswers = $userModel->getUserAnswers($attemptId);
        
        include __DIR__ . '/../../views/teacher/result_view.php';
    }
}
