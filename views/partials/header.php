<?php
// Note: Autoloader and Session::init() are now handled by the bootstrap/entry point (index.php) or base controller.
// However, since this is a partial view, we assume Session is active.

// We need to use namespaces if we reference classes directly here.
use App\Lib\Session;
use App\Database\Database;
use App\Helpers\Format;
// use App\Models\User... if needed

// In a strict MVC, logic like initializing models shouldn't happen in the view (header).
// But for this quick refactor matching the previous style:
// $db   = new Database();
// $fm   = new Format();
// ...
// We'll skip object initialization here. The View should only display data passed to it or check Session.

header("Cache-Control: no-store, no-cache, must-revalidate"); 
header("Cache-Control: pre-check=0, post-check=0, max-age=0"); 
header("Pragma: no-cache"); 
header("Expires: Mon, 6 Dec 1977 00:00:00 GMT"); 
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");

if (isset($_GET['action']) && $_GET['action'] == 'logout') {
    Session::destroy();
    header("Location: /");
    exit();
}
?>
<!doctype html>
<html>
<head>
    <title>Online Exam System</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/modern_style.css?v=<?php echo time(); ?>">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
    <script src="/js/main.js"></script>
</head>
<body class="<?php echo (Session::get("login") == true) ? 'user-logged-in' : ''; ?>">

<!-- Navigation -->
<nav class="navbar">
    <div class="nav-container">
        <a href="<?php echo (Session::get("login") == true) ? 'exam' : '/landing'; ?>" class="nav-brand">
            <span>✨</span> QuizNest
        </a>
        
        <button id="navToggle"  class="nav-toggle" onclick="toggleNav()">☰</button>
        
        <ul id="navbarResponsive" class="nav-links">
            <?php
                $login = Session::get("login");
                if ($login == true) {
            ?>
                <!-- Profile Dropdown -->
                <li><a href="exam" class="btn-action">Exams</a></li>

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
                            <span style="font-size: 0.8rem; color: #94a3b8; display: block;">User</span>
                        </li>
                        <li><div class="dropdown-divider"></div></li>
                        <li><a href="profile" class="dropdown-item">👤 Profile</a></li>
                        <!-- <li><a href="exam" class="dropdown-item">📚 Exams</a></li> -->
                        <li><a href="profile" class="dropdown-item">⚙️ Settings</a></li>
                        <li><div class="dropdown-divider"></div></li>
                        <li><a href="?action=logout" class="dropdown-item logout-item">🚪 Logout</a></li>
                     </ul>
                </li>
            <?php } else { ?>
                <li><a href="/" class="nav-link nav-btn">Login</a></li>
            <?php } ?>
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
