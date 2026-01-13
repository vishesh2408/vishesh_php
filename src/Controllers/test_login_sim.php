<?php
// Simulate Login Request
$_SERVER['REQUEST_METHOD'] = 'POST';
$_POST['email'] = 'visheshyadav62@gmail.com';
$_POST['password'] = 'users123';

require_once __DIR__ . '/../../vendor/autoload.php';
require_once __DIR__ . '/../../config/config.php';

use App\Controllers\AuthController;

echo "--- Simulating Login ---\n";
$auth = new AuthController();
$auth->login();
echo "\n--- End Simulation ---\n";
