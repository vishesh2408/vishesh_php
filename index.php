<?php include 'inc/header.php'; ?>
<?php
  Session::checkLogin();
?>


<div style="display: flex; justify-content: center; align-items: center; min-height: 100vh; background-color: #f0f0f0; margin=top:5px;">
    <!-- Card Container -->
    <div style="display: flex; background-color: white; border-radius: 10px; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); width: 80%; max-width: 1400px;">
        
        <!-- Image Section -->
        <div style="flex: 1; padding: 20px; display: flex; justify-content: center; align-items: center;">
            <img src="img/loginn.png" alt="Logo" style="max-width: 100%; border-radius: 8px;">
        </div>
        
        <!-- Login Form Section -->
        <div style="flex: 1; padding: 20px; display: flex; flex-direction: column; justify-content: center; align-items: center;">
            <h1 style="text-align: center; font-family: Verdana, sans-serif; color: #333;">Online Examination System</h1>
            <p class="lead" style="font-family: Verdana, sans-serif; color: #666; text-align: center;">Simple MCQ Based Online Examination System!</p>
            
            <!-- Form -->
            <form id="loginForm" action="index.php" method="post" style="width: 100%; max-width: 350px;">
                <div style="margin-bottom: 15px;">
                    <label for="email" style="font-family: Verdana, sans-serif; color: #333; font-weight: bold;">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email" style="width: 100%; padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #ccc;">
                </div>
                
                <div style="margin-bottom: 15px;">
                    <label for="password" style="font-family: Verdana, sans-serif; color: #333; font-weight: bold;">Password</label>
                    <input type="password" name="password" id="password" class="form-control" placeholder="Password" style="width: 100%; padding: 10px; font-size: 16px; border-radius: 5px; border: 1px solid #ccc;">
                </div>
                
                <button type="submit" id="loginsubm" value="Signup" class="btn" style="width: 100%; padding: 10px; background-color: #4CAF50; color: white; font-size: 16px; border-radius: 5px; border: none; cursor: pointer;">Log In</button>
            </form>
            
            <p style="margin-top: 20px; text-align: center;">
                <a href="register.php" style="text-decoration: none; color: #007BFF; font-family: Verdana, sans-serif;">New User? Signup for Free</a>
            </p>

            <!-- Error Messages -->
            <span class="empty" style="display: none; color: red; font-family: Verdana, sans-serif;">Fields must not be empty</span>
            <span class="disable" style="display: none; color: red; font-family: Verdana, sans-serif;">User ID Disabled!</span>
            <span class="error" style="display: none; color: red; font-family: Verdana, sans-serif;">Email or Password did not match.</span>
        </div>
    </div>
</div>



<!-- 
<div class="container">
    <div class="text-center">
        <h1>Online Examination System</h1>
        <p class="lead">Simple MCQ Based Online Examination System!</p>
        <img src="img/bgtest.png" alt="Logo"/>
    </div>

    <div class="form-section">
        <form id="loginForm" action="index.php" method="post"> 
            <div class="form-group">
                <label for="email">Email Address</label>
                <input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="password" id="password" class="form-control" placeholder="Password">
            </div>
            <button type="submit" id="loginsubm" value="Signup" class="btn">Log In</button>
        </form>
        <br/>
        <p><a class="btn btn-outline-info" href="register.php">New User? Signup for Free</a></p>
        <span class="empty">Fields must not be empty</span>
        <span class="disable">User ID Disable!</span>
        <span class="error">Email or Password did not match.</span>
    </div>
</div> -->

<script>
    // Form validation on submit
    document.getElementById('loginForm').addEventListener('submit', function(event) {
        event.preventDefault(); // Prevent the form from submitting

        // Get form values
        const email = document.getElementById('email').value.trim();
        const password = document.getElementById('password').value.trim();
        const emptyMessage = document.querySelector('.empty');
        const errorMessage = document.querySelector('.error');
        const disableMessage = document.querySelector('.disable');

        // Reset error messages
        emptyMessage.style.display = 'none';
        errorMessage.style.display = 'none';
        disableMessage.style.display = 'none';

        // Validate fields
        if (email === '' || password === '') {
            emptyMessage.style.display = 'inline-block';
        } else if (email === 'disabled@example.com') { // Example for user ID disable
            disableMessage.style.display = 'inline-block';
        } else {
            // Simulate email and password validation (you can replace this with server-side validation)
            if (email === 'test@example.com' && password === 'password123') {
                // Proceed with form submission (uncomment next line to allow submission)
                // this.submit();
                alert("Logged in successfully!");
            } else {
                errorMessage.style.display = 'inline-block';
            }
        }
    });
</script>
      
	   
<?php include 'inc/footer.php'; ?>