<?php
  use App\Lib\Session;
  // Session::checkLogin(); 
  if (Session::get("login") == true) {
     // Debugging Mode
     // echo "Redirecting..."; header("Location: /exam"); exit();
  }
?>
<?php include __DIR__ . '/partials/header.php'; ?>

<div class="main-wrapper">
    <div class="auth-container animate-fade-in">
        <!-- Image Side -->
        <div class="auth-image-side">
            <img src="img/loginn.png" alt="Login Illustration">
        </div>
        
        <!-- Form Side -->
        <div class="auth-form-side">
            <h1 class="page-title">Welcome Back</h1>
            <p class="page-subtitle">Bridging the Gap Between Learning and Mastery</p>
            
            <form id="loginForm" action="index.php" method="post">
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Enter your password">
                    <div style="text-align: right; margin-top: 5px;">
                        <a href="/forgot-password" style="font-size: 0.9rem; color: #6366f1; text-decoration: none;">Forgot Password?</a>
                    </div>
                </div>
                
                <button type="submit" id="loginsubm" value="Signup" class="btn btn-primary">Log In</button>
            </form>
            
            <div class="auth-footer">
                New User? <a href="register">Create an account</a>
            </div>

            <div class="alert-error empty">Fields must not be empty</div>
            <div class="alert-error disable">User ID Disabled!</div>
            <div class="alert-error error">Email or Password did not match.</div>
        </div>
    </div>
</div>

<script>
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault();
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();
        const emptyMessage = document.querySelector('.empty');
        const errorMessage = document.querySelector('.error');
        const disableMessage = document.querySelector('.disable');

        emptyMessage.style.display = 'none';
        errorMessage.style.display = 'none';
        disableMessage.style.display = 'none';

        if (email === '' || password === '') {
            emptyMessage.style.display = 'block';
            setTimeout(function(){ $('.empty').fadeOut(); }, 4000);
        } else {
             $.ajax({
				type: "POST",
				url: "getlogin.php", // This needs to be available in public/ or handled by router
				data: {email:email,password:password},
				success: function(data){
					if($.trim(data) == "empty"){
						$(".empty").show();
						setTimeout(function(){ $(".empty").fadeOut(); },4000);
					}else if($.trim(data) == "disable"){
						$(".disable").show();
						setTimeout(function(){ $(".disable").fadeOut(); },4000);
					}else if($.trim(data) == "error"){
						$(".error").show();
						setTimeout(function(){ $(".error").fadeOut(); },4000);
					}else{
						window.location.href = $.trim(data);
					}
				}
			});
        }
    });
</script>
