<!-- Footer -->
<footer id="footer" style="background-color: #2c3e50; color: #ecf0f1; padding: 40px 20px; font-family: Verdana, sans-serif; margin-bottom: 0;">
  <div class="container" style="max-width: 1200px; margin: auto;">
    <div class="row" style="display: flex; justify-content: space-between;">

      <!-- About Section -->
      <div class="col-md-3" style="flex: 1; margin: 10px;">
        <h5 style="color: #ffffff;">WEEKEND</h5>
        <p style="color: #bdc3c7;">Top learning experiences that create more talent in the world.</p>
      </div>

      <!-- Product Links -->
      <div class="col-md-2" style="flex: 1; margin: 10px;">
        <h5 style="color: #ffffff;">Product</h5>
        <ul class="quick-links" style="list-style: none; padding: 0;">
          <li><a href="#" style="color: #bdc3c7; text-decoration: none;">Overview</a></li>
          <li><a href="#" style="color: #bdc3c7; text-decoration: none;">Features</a></li>
          <li><a href="#" style="color: #bdc3c7; text-decoration: none;">Solutions</a></li>
          <li><a href="#" style="color: #bdc3c7; text-decoration: none;">Tutorials</a></li>
          <li><a href="#" style="color: #bdc3c7; text-decoration: none;">Pricing</a></li>
        </ul>
      </div>

      <!-- Company Links -->
      <div class="col-md-2" style="flex: 1; margin: 10px;">
        <h5 style="color: #ffffff;">Company</h5>
        <ul class="quick-links" style="list-style: none; padding: 0;">
          <li><a href="#" style="color: #bdc3c7; text-decoration: none;">About us</a></li>
          <li><a href="#" style="color: #bdc3c7; text-decoration: none;">Careers</a></li>
          <li><a href="#" style="color: #bdc3c7; text-decoration: none;">Press</a></li>
          <li><a href="#" style="color: #bdc3c7; text-decoration: none;">News</a></li>
        </ul>
      </div>

      <!-- Social Links -->
      <div class="col-md-2" style="flex: 1; margin: 10px;">
        <h5 style="color: #ffffff;">Social</h5>
        <ul class="quick-links" style="list-style: none; padding: 0;">
          <li><a href="#" style="color: #bdc3c7; text-decoration: none;">Twitter</a></li>
          <li><a href="#" style="color: #bdc3c7; text-decoration: none;">LinkedIn</a></li>
          <li><a href="#" style="color: #bdc3c7; text-decoration: none;">GitHub</a></li>
          <li><a href="#" style="color: #bdc3c7; text-decoration: none;">Dribbble</a></li>
        </ul>
      </div>

      <!-- Legal Links -->
      <div class="col-md-2" style="flex: 1; margin: 10px;">
        <h5 style="color: #ffffff;">Legal</h5>
        <ul class="quick-links" style="list-style: none; padding: 0;">
          <li><a href="#" style="color: #bdc3c7; text-decoration: none;">Terms</a></li>
          <li><a href="#" style="color: #bdc3c7; text-decoration: none;">Privacy</a></li>
          <li><a href="#" style="color: #bdc3c7; text-decoration: none;">Cookies</a></li>
          <li><a href="#" style="color: #bdc3c7; text-decoration: none;">Contact</a></li>
        </ul>
      </div>

      <!-- Social Icons in Bottom Right -->
      <div class="social-container" style="position: fixed; bottom: 20px; right: 20px;">
        <ul class="social" style="display: flex; list-style: none; padding: 0; margin: 0;">
          <li style="margin-left: 10px;"><a href="#"><i class="fa fa-instagram"></i></a></li>
          <li style="margin-left: 10px;"><a href="#"><i class="fa fa-linkedin"></i></a></li>
          <li style="margin-left: 10px;"><a href="#"><i class="fa fa-github"></i></a></li>
        </ul>
      </div>

    </div>

    <div class="footer-bottom" style="margin-top: 20px; text-align: center; border-top: 1px solid #7f8c8d; padding-top: 10px;">
      <p style="color: #bdc3c7;">© 2024 Examly. All rights reserved.</p>
    </div>

  </div>

  <!-- jQuery for Interactive Elements -->
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://kit.fontawesome.com/a076d05399.js" crossorigin="anonymous"></script> <!-- Add Font Awesome -->
  <script>
    $(document).ready(function() {
      // Hover effect to change link color
      $('.quick-links a').hover(
        function() {
          $(this).css('color', '#1abc9c');
        }, function() {
          $(this).css('color', '#bdc3c7');
        }
      );

      // Fade in social icons on page load
      $('.social li a').hide().fadeIn(2000);

      // Click effect for social icons
      $('.social li a').click(function() {
        $(this).css('color', '#e74c3c');
      });
    });
  </script>
</footer>
