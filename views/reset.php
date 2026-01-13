<?php include __DIR__ . '/partials/header.php'; ?>
<?php $token = $_GET['token'] ?? ''; ?>
<div class="main-wrapper">
    <div class="auth-container animate-fade-in" style="min-height: 380px;">
        <div class="auth-image-side">
            <img src="/img/loginn.png" alt="Reset Password">
        </div>
        <div class="auth-form-side">
            <h1 class="page-title">Reset Password</h1>
            <p class="page-subtitle">Enter your new password</p>
            
            <form id="resetForm">
                <input type="hidden" id="token" value="<?php echo htmlspecialchars($token); ?>">
                <div class="form-group">
                    <label for="password" class="form-label">New Password</label>
                    <input type="password" class="form-control" id="password" placeholder="New Password" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Update Password</button>
            </form>
            
            <div id="message" style="margin-top: 15px; text-align: center; display:none;"></div>
        </div>
    </div>
</div>

<script>
document.getElementById('resetForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const token = document.getElementById('token').value;
    const password = document.getElementById('password').value;
    const msg = document.getElementById('message');
    
    $.ajax({
        type: "POST",
        url: "/reset-password-action",
        data: {token: token, password: password},
        success: function(response) {
            if (response.trim() == "success") {
                msg.style.display = 'block';
                msg.style.color = 'green';
                msg.innerHTML = 'Password updated successfully! Redirecting...';
                setTimeout(() => window.location = '/', 2000);
            } else {
                msg.style.display = 'block';
                msg.style.color = 'red';
                msg.innerHTML = 'Failed to reset password. Token may be invalid.';
            }
        }
    });
});
</script>
