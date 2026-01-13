<?php

$filepath = realpath(dirname(__FILE__));
include_once ($filepath.'/../lib/Session.php');
Session::init();

include_once ($filepath.'/../lib/Database.php');
include_once ($filepath.'/../helpers/Format.php');
spl_autoload_register(function($class){
	include_once "classes/".$class.".php";
});

$db   = new Database();
$fm   = new Format();
$exam = new Exam();
$user = new User();
$pro  = new Process();

header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: pre-check=0, post-check=0, max-age=0"); 
header("Pragma: no-cache"); 
header("Expires: Mon, 6 Dec 1977 00:00:00 GMT"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
?>
<?php
  if (isset($_GET['action']) && $_GET['action'] == 'logout') {
  	     Session::destroy();
  	     header("Location:index.php");
  	     exit();
  }
?>







    <!doctype html>
<html>
<head>
    <title>Online Exam System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="js/main.js"></script>
</head>
<body style="font-family: Verdana; margin: 0; padding: 0;">

<!-- Navigation -->
<nav style="background-color: #333; color: #fff; padding: 10px 0; width: 100%; height:50px">
    <div style="display: flex; justify-content: space-between; align-items: center; max-width: 1200px; margin: 0 auto; padding: 0 15px; margin-top:10px;">
        <a href="" style="color: #fff; text-decoration: none; font-size: 18px;">Online Examination System</a>
        
        <!-- Toggler for small screens -->
        <button id="navToggle" onclick="toggleNav()" style="background: none; border: none; color: #fff; font-size: 20px; display: none; cursor: pointer;">☰</button>
        
        <ul id="navbarResponsive" style="list-style: none; margin: 0; padding: 0; display: flex; gap: 15px;">
            <?php
                $login = Session::get("login");
                if ($login == true) {
            ?>
                <li style="display: inline;"><a href="#" style="color: #fff; text-decoration: none;">Welcome <strong><?php echo Session::get("name"); ?></strong></a></li>
                <li style="display: inline;"><a href="profile.php" style="color: #fff; text-decoration: none;">Profile</a></li>
                <li style="display: inline;"><a href="exam.php" style="color: #fff; text-decoration: none;">Exam</a></li>
                <li style="display: inline;"><a href="?action=logout" style="color: #fff; text-decoration: none;">Logout</a></li>
            <?php } else { ?>
                <li style="display: inline;"><a href="index.php" style="color: #fff; text-decoration: none;">Login</a></li>
                <li style="display: inline;"><a href="register.php" style="color: #fff; text-decoration: none;">Register</a></li>
                <li style="display: inline;"><a href="admin/" style="color: #fff; text-decoration: none;">Admin</a></li>
            <?php } ?>
        </ul>
    </div>
</nav>

<script>
function toggleNav() {
    const nav = document.getElementById('navbarResponsive');
    nav.style.display = nav.style.display === 'flex' ? 'none' : 'flex';
}

window.addEventListener('resize', () => {
    const nav = document.getElementById('navbarResponsive');
    nav.style.display = window.innerWidth > 768 ? 'flex' : 'none';
});

window.addEventListener('load', () => {
    const nav = document.getElementById('navbarResponsive');
    nav.style.display = window.innerWidth > 768 ? 'flex' : 'none';
    document.getElementById('navToggle').style.display = window.innerWidth <= 768 ? 'block' : 'none';
});
</script>


