<?php
namespace App\Controllers;

class AdminController {
    public function dashboard() {
        include __DIR__ . '/../../views/admin/index.php';
    }
    public function login() {
        include __DIR__ . '/../../views/admin/login.php';
    }
    public function users() {
         include __DIR__ . '/../../views/admin/users.php';
    }
    public function exams() {
         include __DIR__ . '/../../views/admin/exams.php';
    }
    public function quesAdd() {
         include __DIR__ . '/../../views/admin/quesadd.php';
    }
    public function quesList() {
         include __DIR__ . '/../../views/admin/queslist.php';
    }
    
    public function editExam() {
        include __DIR__ . '/../../views/admin/exam_edit.php';
    }
    public function editExamAction() {
         include __DIR__ . '/../../views/admin/exam_edit.php';
    }
    
    public function editQues() {
        include __DIR__ . '/../../views/admin/ques_edit.php';
    }
    public function editQuesAction() {
        include __DIR__ . '/../../views/admin/ques_edit.php';
    }
}
