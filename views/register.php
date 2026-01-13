<?php include __DIR__ . '/partials/header.php'; ?>

<div class="main-wrapper">
    <div class="auth-container animate-fade-in">
        <!-- Image Side -->
        <div class="auth-image-side">
            <img src="/img/regi.png" alt="Register Illustration">
        </div>
        
        <!-- Form Side -->
        <div class="auth-form-side">
            <h1 class="page-title">Create Account</h1>
            <p class="page-subtitle">Join QuizNest today!</p>
            
            <form id="regForm" action="post">
                <div class="form-group">
                    <label for="name" class="form-label">Full Name</label>
                    <input type="text" class="form-control" id="name" name="name" placeholder="Enter your full name">
                </div>
                
                <div class="form-group">
                    <label for="userName" class="form-label">Username</label>
                    <input type="text" class="form-control" id="userName" name="userName" placeholder="Choose a username">
                </div>
                
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Create a password">
                </div>
                
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email">
                </div>

                <div class="form-group" style="display: flex; gap: 1rem;">
                    <div style="flex: 1;">
                        <label for="institution" class="form-label">Institution (Optional)</label>
                        <input type="text" class="form-control" id="institution" name="institution" placeholder="University/School">
                    </div>
                    <div style="flex: 1;">
                        <label for="institution_id" class="form-label">Roll No. / ID</label>
                        <input type="text" class="form-control" id="institution_id" name="institution_id" placeholder="e.g. 2024001">
                    </div>
                </div>
                
                <button type="submit" id="registersubm" class="btn btn-primary">Sign Up</button>
            </form>
            
             <div class="auth-footer">
                Already have an account? <a href="/">Log In</a>
            </div>
            
            <div id="state"></div>
        </div>
    </div>
</div>
