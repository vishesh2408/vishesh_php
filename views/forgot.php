<?php include __DIR__ . '/partials/header.php'; ?>
<div class="main-wrapper">
    <div class="auth-container animate-fade-in" style="min-height: 380px;">
        <div class="auth-image-side">
            <img src="/img/loginn.png" alt="Forgot Password">
        </div>
        <div class="auth-form-side">
            <h1 class="page-title">Forgot Password</h1>
            <p class="page-subtitle">Enter your email to reset password</p>
            
            <form id="forgotForm">
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your registered email" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Send Reset Link</button>
                
                <a href="/" class="btn btn-outline">Back to Login</a>
            </form>
            
            <div id="message" style="margin-top: 15px; text-align: center; display:none;"></div>
        </div>
    </div>
</div>

<script>
document.getElementById('forgotForm').addEventListener('submit', function(e) {
    e.preventDefault();
    const email = document.getElementById('email').value;
    const msg = document.getElementById('message');
    
    $.ajax({
        type: "POST",
        url: "/forgot-password", // Check route
        data: {email: email},
        success: function(response) {
            if (response.startsWith("success")) {
                const token = response.split("|")[1];
                msg.style.display = 'block';
                msg.className = 'alert-success';
                // Simulation of email
                msg.innerHTML = `Link generated (Simulated): <br><a href="/reset-password?token=${token}">Click here to Reset</a>`;
            } else {
                msg.style.display = 'block';
                msg.className = 'alert-error';
                msg.innerHTML = 'Email not found or error occurred.';
                msg.style.display = 'block'; // Ensure visibility
            }
        }
    });
});
</script>
