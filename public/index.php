<?php
ob_start();
header("Cache-Control: no-cache, no-store, must-revalidate");
header("Pragma: no-cache");
header("Expires: 0");

ini_set('display_errors', 1); // SHOW ERRORS
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Handle static files for PHP built-in server
if (php_sapi_name() === 'cli-server') {
    $path = parse_url($_SERVER['REQUEST_URI'], PHP_URL_PATH);
    $file = __DIR__ . $path;
    if (is_file($file)) {
        return false; // serve the requested resource as-is.
    }
}

// Load Composer Autoloader
require_once __DIR__ . '/../vendor/autoload.php';

// Load Config
require_once __DIR__ . '/../config/config.php';

use App\Router;
use App\Lib\Session;

Session::init(); // Start Session Globally

$router = new Router();

// Define Routes
$router->get('/', 'HomeController@index');
$router->get('/index.php', 'HomeController@index');

$router->get('/register', 'AuthController@showRegister');
$router->get('/register.php', 'AuthController@showRegister'); 

$router->post('/getlogin.php', 'AuthController@login');
$router->post('/getregister.php', 'AuthController@register');

$router->get('/forgot-password', 'AuthController@showForgot');
$router->post('/forgot-password', 'AuthController@handleForgot');
$router->get('/reset-password', 'AuthController@showReset');
$router->post('/reset-password-action', 'AuthController@handleReset');

$router->get('/exam', 'ExamController@index');
$router->get('/starttest', 'ExamController@startTest');
$router->get('/test', 'ExamController@test');
$router->get('/test.php', 'ExamController@test'); // Legacy support
$router->post('/test', 'ExamController@test');
$router->get('/final', 'ExamController@final');
$router->get('/viewans', 'ExamController@viewAns');

$router->get('/profile', 'UserController@profile');
$router->post('/profile', 'UserController@profile');

$router->get('/landing', 'HomeController@landing');

// Admin Routes
$router->get('/admin', 'AdminController@dashboard');
$router->get('/admin/', 'AdminController@dashboard');
// $router->get('/admin/login', 'AdminController@login');
// $router->post('/admin/login', 'AdminController@login');
$router->get('/admin/dashboard', 'AdminController@dashboard');
$router->get('/admin/users', 'AdminController@users');
$router->get('/admin/exams', 'AdminController@exams');
$router->post('/admin/exams', 'AdminController@exams');
$router->get('/admin/exams/edit', 'AdminController@editExam');
$router->post('/admin/exams/edit', 'AdminController@editExamAction');

$router->get('/admin/quesadd', 'AdminController@quesAdd');
$router->post('/admin/quesadd', 'AdminController@quesAdd');
$router->get('/admin/queslist', 'AdminController@quesList');
$router->get('/admin/ques/edit', 'AdminController@editQues');
$router->post('/admin/ques/edit', 'AdminController@editQuesAction');

// Teacher Routes
$router->get('/teacher/dashboard', 'TeacherController@dashboard');
$router->get('/teacher/exams', 'TeacherController@exams');
$router->get('/teacher/create-exam', 'TeacherController@createExam');
$router->post('/teacher/create-exam', 'TeacherController@createExam');
$router->get('/teacher/question-bank', 'TeacherController@questionBank');
$router->get('/teacher/question-add', 'TeacherController@questionAdd');
$router->post('/teacher/question-add', 'TeacherController@questionAdd');
$router->get('/teacher/students', 'TeacherController@students');
$router->get('/teacher/monitoring', 'TeacherController@monitoring');
$router->get('/teacher/evaluation', 'TeacherController@evaluation');
$router->get('/teacher/analytics', 'TeacherController@analytics');
$router->get('/teacher/communication', 'TeacherController@communication');
$router->get('/teacher/groups', 'TeacherController@groups');
$router->post('/teacher/groups', 'TeacherController@groups');
$router->get('/teacher/groups/manage', 'TeacherController@manageGroup');
$router->get('/teacher/download-results', 'TeacherController@downloadResults');
$router->get('/teacher/result-view', 'TeacherController@viewResult');

// Dispatch
$router->dispatch();
