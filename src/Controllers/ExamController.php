<?php
namespace App\Controllers;

class ExamController {
    public function index() {
        include __DIR__ . '/../../views/exam.php';
    }

    public function startTest() {
        include __DIR__ . '/../../views/starttest.php';
    }

    public function test() {
        include __DIR__ . '/../../views/test.php';
    }

    public function final() {
        include __DIR__ . '/../../views/final.php';
    }

    public function viewAns() {
        include __DIR__ . '/../../views/viewans.php';
    }
}
