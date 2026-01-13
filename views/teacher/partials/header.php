<?php 
use App\Lib\Session;
// Ensure session is started/checked. In a real app, use a specific checkTeacherSession()
// Session::checkTeacherSession(); 
$name = Session::get("name");
$img = Session::get("image");
?>
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Teacher Dashboard - QuizNest</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="/css/modern_style.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="teacher-portal user-logged-in">

<nav class="navbar">
    <div class="nav-container">
        <a href="/teacher/dashboard" class="nav-brand">
            <span>🎓</span> QuizNest <span style="font-size: 0.8rem; opacity: 0.7; margin-left: 10px; font-weight: normal;">Teacher</span>
        </a>
        
        <button id="navToggle" class="nav-toggle" onclick="toggleNav()">☰</button>
        
        <ul id="navbarResponsive" class="nav-links">
            <li><a href="/teacher/dashboard" class="nav-link">Dashboard</a></li>
            <li><a href="/teacher/exams" class="nav-link">Exams</a></li>
            <li><a href="/teacher/groups" class="nav-link">Groups</a></li>
            <li><a href="/teacher/students" class="nav-link">Students</a></li>
            <li><a href="/teacher/analytics" class="nav-link">Reports</a></li>
            
            <!-- Profile Dropdown -->
            <li class="profile-menu-item">
                <div class="profile-trigger" onclick="toggleProfileDropdown(event)">
                    <?php if ($img && $img != '') { ?>
                         <div class="profile-avatar" style="background: url('<?php echo $img; ?>') center/cover no-repeat; border: 2px solid #fff;"></div>
                    <?php } else { ?>
                        <div class="profile-avatar">
                            <?php echo strtoupper(substr($name ?? 'T', 0, 1)); ?>
                        </div>
                    <?php } ?>
                 </div>
                 
                 <ul class="dropdown-menu" id="profileDropdown">
                    <li class="dropdown-header">
                        <strong><?php echo $name ?? 'Teacher'; ?></strong>
                        <span style="font-size: 0.8rem; color: #94a3b8; display: block;">Educator</span>
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

<div class="main-wrapper" style="display: block; padding-top: 2rem;">
