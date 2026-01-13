<?php 
use App\Lib\Session;
use App\Database\Database;
use App\Helpers\Format;
Session::checkAdminSession();
$db  = new Database();
$fm  = new Format(); 

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    Session::destroy();
    header("Location: /"); 
    exit();
}
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Admin Panel - QuizNest</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/modern_style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body>

<nav class="navbar">
    <div class="nav-container">
        <a href="dashboard" class="nav-brand">
            <span>✨</span> QuizNest <span style="font-size: 0.8rem; opacity: 0.7; margin-left: 10px; font-weight: normal;">Admin</span>
        </a>
        
        <button id="navToggle" class="nav-toggle" onclick="toggleNav()">☰</button>
        
        <ul id="navbarResponsive" class="nav-links">
            <li><a href="dashboard" class="nav-link">Dashboard</a></li>
            <li><a href="users" class="nav-link">Users</a></li>
            <li><a href="exams" class="nav-link">Exams</a></li>
            <li><a href="queslist" class="nav-link">Questions</a></li>
            <li><a href="quesadd" class="nav-link nav-btn" style="background: var(--primary-color); color: white !important;">+ Add Question</a></li>
            
            <!-- Profile Dropdown for Admin -->
            <li class="profile-menu-item">
                <div class="profile-trigger" onclick="toggleProfileDropdown(event)">
                    <?php 
                        $name = Session::get("name");
                        $img = Session::get("image");
                        if ($img && $img != '') {
                    ?>
                         <div class="profile-avatar" style="background: url('<?php echo $img; ?>') center/cover no-repeat; border: 2px solid #fff;"></div>
                    <?php } else { ?>
                        <div class="profile-avatar">
                            <?php echo strtoupper(substr($name, 0, 1)); ?>
                        </div>
                    <?php } ?>
                 </div>
                 
                 <ul class="dropdown-menu" id="profileDropdown">
                    <li class="dropdown-header">
                        <strong><?php echo $name; ?></strong>
                        <span style="font-size: 0.8rem; color: #94a3b8; display: block;">Administrator</span>
                    </li>
                    <li><div class="dropdown-divider"></div></li>
                    <li><a href="/profile" class="dropdown-item">👤 Profile</a></li>
                    <li><div class="dropdown-divider"></div></li>
                    <li><a href="?action=logout" class="dropdown-item logout-item">🚪 Logout</a></li>
                 </ul>
            </li>
        </ul>
    </div>
</nav>

<script>
function toggleNav() {
    const nav = document.getElementById('navbarResponsive');
    nav.classList.toggle('active');
}

function toggleProfileDropdown(event) {
    if(event) event.stopPropagation();
    const dropdown = document.getElementById('profileDropdown');
    dropdown.classList.toggle('show');
}

// Close dropdown when clicking outside
window.onclick = function(event) {
    if (!event.target.matches('.profile-trigger') && !event.target.matches('.profile-avatar')) {
        var dropdowns = document.getElementsByClassName("dropdown-menu");
        for (var i = 0; i < dropdowns.length; i++) {
            var openDropdown = dropdowns[i];
            if (openDropdown.classList.contains('show')) {
                openDropdown.classList.remove('show');
            }
        }
    }
}
</script>

<div class="admin-wrapper" class="animate-fade-in">
