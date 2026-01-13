<?php 
    include_once ("../lib/Session.php");
    Session::checkAdminSession();
    include_once ("../lib/Database.php");
    include_once ("../helpers/Format.php");
	$db  = new Database();
	$fm  = new Format(); 
?>
<?php
header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: pre-check=0, post-check=0, max-age=0"); 
header("Pragma: no-cache"); 
header("Expires: Mon, 6 Dec 1977 00:00:00 GMT"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
?>







<!doctype html>
<html>
<head>
    <title>Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

</head>
<body style="font-family: Verdana, sans-serif; margin: 0; padding: 0;">
<?php
if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    Session::destroy();
    header("Location:login.php");
    exit();
}
?>

<script>
// Function to toggle menu visibility (using vanilla JavaScript)
function toggleMenu() {
    const navHeader = document.querySelector('.collapsenavbar');
    navHeader.classList.toggle('active');
}

// jQuery code to handle responsiveness and dynamic toggle
$(document).ready(function() {
    // Using jQuery to toggle the navbar visibility on small screens
    $(".navbartoggle1").click(function() {
        $(".collapsenavbar").toggleClass("active");
    });
});
</script>

<nav style="background-color: #333; color: #fff; padding: 10px; position: relative; height: 50px;">
    <div style="display: flex; justify-content: space-between; align-items: center; max-width: 1200px; margin: 0 auto;">
        <a href="/exam" style="color: #fff; text-decoration: none; font-size: 24px; font-weight: bold;">Online Examination System</a>
        <button class="navbartoggle1" type="button" onclick="toggleMenu()" style="background: none; border: none; color: #fff; font-size: 24px; cursor: pointer;">☰</button>
        <div class="collapsenavbar" id="navbarresponsive" style="display: flex; width: 100%; flex-direction: column; position: absolute; top: 50px; left: 0; background-color: #333; z-index: 1; display: none;">
            <ul style="list-style: none; margin: 0; padding: 0; display: flex; flex-direction: column; width: 100%;">
                <li style="width: 100%;"><a href="index.php" style="text-decoration: none; color: #fff; padding: 15px; display: block; text-align: center; background-color: #333; transition: background-color 0.3s;">Home</a></li>
                <li style="width: 100%;"><a href="users.php" style="text-decoration: none; color: #fff; padding: 15px; display: block; text-align: center; background-color: #333; transition: background-color 0.3s;">Manage Users</a></li>
                <li style="width: 100%;"><a href="quesadd.php" style="text-decoration: none; color: #fff; padding: 15px; display: block; text-align: center; background-color: #333; transition: background-color 0.3s;">Add Question</a></li>
                <li style="width: 100%;"><a href="queslist.php" style="text-decoration: none; color: #fff; padding: 15px; display: block; text-align: center; background-color: #333; transition: background-color 0.3s;">Manage Question</a></li>
                <li style="width: 100%;"><a href="?action=logout" style="text-decoration: none; color: #fff; padding: 15px; display: block; text-align: center; background-color: #333; transition: background-color 0.3s;">Logout</a></li>
            </ul>
        </div>
    </div>
</nav>











<!-- <!doctype html>
<html>
<head>
    <title>Admin</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
 
    <link href="../css/footer.css" rel="stylesheet">
  
    <style>
  


        </style>
</head>
<body>
<?php
// if (isset($_GET['action']) && $_GET['action'] == 'logout') {
//     Session::destroy();
//     header("Location:login.php");
//     exit();
// }
?>

<script>
function toggleMenu() {
    const navHeader = document.querySelector('.navheader');
    navHeader.classList.toggle('active');
}

    </script> -->

<!-- Navigation -->
<!-- <nav class="navheader">
    <div class="container3">
        <a class="navbrand" href="/exam">Online Examination System</a>
        <button class="navbartoggle1" type="button" onclick="toggleMenu()">
            <span class="navbartogglericon"></span>
        </button>
        <div class="collapsenavbar" id="navbarresponsive">
            <ul class="navbarul">
                <li class="nav-item"><a class="nav-link" href="index.php">Home</a></li>
                <li class="nav-item"><a class="nav-link" href="users.php">Manage Users</a></li>
                <li class="nav-item"><a class="nav-link" href="quesadd.php">Add Question</a></li>
                <li class="nav-item"><a class="nav-link" href="queslist.php">Manage Question</a></li>
                <li class="nav-item"><a class="nav-link" href="?action=logout">Logout</a></li>
            </ul>
        </div>
    </div>
</nav> -->

