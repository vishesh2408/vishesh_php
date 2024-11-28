<?php 
    $filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'../inc/header.php');
?>

<div style="max-width: 100%; padding: 20px; font-family: Verdana, sans-serif; background: linear-gradient(90deg, hsla(46, 73%, 75%, 1) 0%, hsla(176, 73%, 88%, 1) 100%);">

            
    <div style="display: flex; justify-content: center; flex-direction: column; align-items: center;">
        <h1 style="margin-top: 50px; text-align: center;">Welcome to Exam Control Panel - Admin</h1>
        
        <div style="padding: 20px; background-color: #f8f9fa; border-radius: 10px; margin-top: 20px; width: 100%; max-width: 600px; text-align: center;">
            <h1 style="font-size: 24px; color: #333;">Controls</h1>
            <a href="index.php" style="display: inline-block; padding: 10px 20px; margin: 5px; color: #28a745; border: 2px solid #28a745; border-radius: 5px; text-decoration: none; font-size: 18px;">🏠 Home</a>
            <a href="users.php" style="display: inline-block; padding: 10px 20px; margin: 5px; color: #17a2b8; border: 2px solid #17a2b8; border-radius: 5px; text-decoration: none; font-size: 18px;">👤 Manage Users</a>
            <a href="quesadd.php" style="display: inline-block; padding: 10px 20px; margin: 5px; color: #007bff; border: 2px solid #007bff; border-radius: 5px; text-decoration: none; font-size: 18px;">❓ Add Question</a>
            <a href="queslist.php" style="display: inline-block; padding: 10px 20px; margin: 5px; color: #343a40; border: 2px solid #343a40; border-radius: 5px; text-decoration: none; font-size: 18px;">📋 Manage Question</a>
            <a href="?action=logout" style="display: inline-block; padding: 10px 20px; margin: 5px; color: #dc3545; border: 2px solid #dc3545; border-radius: 5px; text-decoration: none; font-size: 18px;">🚪 Logout</a>
        </div>
    </div>
</div>

<?php include '../inc/footer.php'; ?>