<?php include 'inc/header.php'; ?>

<div style=" width: 100%;">
    <div style="display: flex; justify-content: center; align-items: center; margin-top: 30px;">
        <!-- Card Container -->
        <div style="display: flex; border: 1px solid #ddd; box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1); border-radius: 8px; overflow: hidden; max-width: 1000px; margin-right: 30px; margin-bottom: 30px;">
            <!-- Image Section -->
            <div style="flex: 1; padding: 20px;">
                <img src="img/loginn.png" alt="Registration Image" style="width: 530px; height: 550px;  border-radius: 8px; ">
            </div>
          
            <!-- Registration Form Section -->
            <div style="flex: 2; padding: 20px; margin-right: 40px; justify-content: center; align-items: center;">
                <h1 style="text-align: center; margin-bottom: 20px;">Online Examination System</h1>
                <p style="text-align: center; margin-bottom: 20px;">Complete MCQ Based Online Examination System!</p>

                <!-- Full Name Input -->
                <div style="margin-bottom: 10px;">
                    <label for="name" style="display: block;">Full Name</label>
                    <input type="text" id="name" name="name" placeholder="Enter Your Full Name" style="width: 100%; padding: 10px; margin: 5px 0; border-radius: 5px; border: 1px solid #ccc;">
                    <small style="display: block; font-size: 12px; color: #888;">Enter your full name (Spaces allowed).</small>
                </div>

                <!-- Username Input -->
                <div style="margin-bottom: 10px;">
                    <label for="userName" style="display: block;">Username</label>
                    <input type="text" id="userName" name="userName" placeholder="Enter Username (without spaces)" style="width: 100%; padding: 10px; margin: 5px 0; border-radius: 5px; border: 1px solid #ccc;">
                    <small style="display: block; font-size: 12px; color: #888;">Enter only the username</small>
                </div>

                <!-- Email Input -->
                <div style="margin-bottom: 10px;">
                    <label for="email" style="display: block;">Email Address</label>
                    <input type="email" id="email" name="email" placeholder="Enter Email" style="width: 100%; padding: 10px; margin: 5px 0; border-radius: 5px; border: 1px solid #ccc;">
                    <small style="display: block; font-size: 12px; color: #888;">We'll never share your email with anyone else.</small>
                </div>

                <!-- Password Input -->
                <div style="margin-bottom: 10px;">
                    <label for="password" style="display: block;">Password</label>
                    <input type="password" id="password" name="password" placeholder="Password" style="width: 100%; padding: 10px; margin: 5px 0; border-radius: 5px; border: 1px solid #ccc;">
                </div>

                <!-- Buttons -->
                <div style="display: flex; justify-content: space-between; align-items: center; margin-top: 20px;">
                    <button type="submit" id="registersubm" value="Signup" style="padding: 10px 20px; background-color: #28a745; border: none; color: white; border-radius: 5px; cursor: pointer;">
                        Register
                    </button>
                    <a href="index.php" style="padding: 10px 20px; background-color: #dc3545; color: white; border-radius: 5px; text-decoration: none; text-align: center; cursor: pointer;">
                        Already Registered? Login
                    </a>
                </div>
            </div>
        </div>
    </div>
</div>





<!-- 
<div class="container">
		<div class="row">
        <div class="col-lg-12 text-center">
				<h1 class="mt-5">Online Examination System</h1>
				<p class="lead">Complete MCQ Based Online Examination System!</p>
				<img src="img/regi.png" width="130px;"/>				
        </div>
        
        <div class="col-lg-2">
        
		</div>
		
		<div class="col-lg-8">
			<div class="form-group">
				<label for="exampleInputName">FullName</label>
				<input type="text" class="form-control" id="name" name="name" placeholder="Enter Your FullName">
				<small id="emailHelp" class="form-text text-muted">Enter your full name (Spaces allowed).</small>
	</div>
	
	<div class="form-group">
				<label for="exampleInputusername">Username</label>
				<input type="text" class="form-control" id="userName" name="userName" placeholder="Enter Username (without spaces)">
				<small id="emailHelp" class="form-text text-muted">Enter only the username</small>
			</div>

			<div class="form-group">
				<label for="exampleInputEmail1">Email Address</label>
				<input type="email" class="form-control" id="email" name="email" placeholder="Enter Email">
				<small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
			</div>
			<div class="form-group">
				<label for="exampleInputPassword1">Password</label>
				<input type="password" name="password" id="password" class="form-control" placeholder="Password">
			</div>
	<button type="submit" id="registersubm" value="Signup" class="btn btn-success">Register</button>
	<a class="btn btn-outline-danger" href="index.php">Already Registered? Login</a>
	</form>
	<br/><br/>
	<span id="state"></span>
		</div>

		<div class="col-lg-2"></div>
		</div>
  </div> -->


<?php include 'inc/footer.php'; ?>