<?php
namespace App\Controllers;

class HomeController {
    public function index() {
        // Logic to check session or load view
        include __DIR__ . '/../../views/home.php';
    }

    public function landing() {
        include __DIR__ . '/../../views/landingpage.php';
    }
}
