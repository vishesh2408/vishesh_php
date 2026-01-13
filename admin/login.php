<?php
$filepath = realpath(dirname(__FILE__));
include_once ($filepath . '/inc/loginheader.php');
include_once ($filepath . '/../classes/Admin.php');
$ad = new Admin();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $adminData = $ad->getAdminData($_POST);
}
?>

<div style="display: flex; align-items: center; justify-content: center; height: 100vh; background-color: #f4f4f4;">
    <!-- Left Image Section -->
    <div style="flex: 1; display: flex; margin-left:150px;">
        <img src="login1.png" alt="Admin Login Image" style="max-width: 100%; height: 600px; border-radius: 8px;">
    </div>

    <!-- Right Form Section -->
    <div style="flex: 1; max-width: 400px; background-color: #ffffff; height: 520px;margin-right:150px; padding: 30px; border-radius: 10px; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.2);">
        <h1 style="text-align: center; color: #333; margin-bottom: 20px;">Login - Administration Panel</h1>
        <form action="" method="post">
            <div style="margin-bottom: 15px;">
                <label for="adminUser" style="display: block; font-weight: bold; margin-bottom: 5px;">Username</label>
                <input type="text" name="adminUser" id="adminUser" placeholder="Enter Username" 
                       style="width: 100%; padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px;">
            </div>
            <div style="margin-bottom: 20px;">
                <label for="adminPass" style="display: block; font-weight: bold; margin-bottom: 5px;">Password</label>
                <input type="password" name="adminPass" id="adminPass" placeholder="Enter Password" 
                       style="width: 100%; padding: 10px; font-size: 16px; border: 1px solid #ccc; border-radius: 5px;">
            </div>
            <button type="submit" name="login" value="Login" 
                    style="width: 100%; padding: 10px; font-size: 16px; color: #fff; background-color: #d9534f; border: none; border-radius: 5px; cursor: pointer;">
                Log In
            </button>
        </form>
        <?php if (isset($adminData)): ?>
            <div style="margin-top: 15px; color: red; font-weight: bold; text-align: center;">
                <?php echo $adminData; ?>
            </div>
        <?php endif; ?>
    </div>
</div>


    <!-- <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="mt-5">Login - Administration Panel</h1> <br>
                
            </div>

            <div class="col-lg-3">
               
            </div>

            <div class="col-lg-6">
                <form action="" method="post">
                    <div class="form-group">
                        <label for="exampleInputEmail1">Username</label>
                        <input type="text" class="form-control" name="adminUser" placeholder="Enter Username">
                    </div>
                    <div class="form-group">
                        <label for="exampleInputPassword1">Password</label>
                        <input type="password" name="adminPass" class="form-control" placeholder="Enter Password">
                    </div>
                    <button type="submit" name="login" value="Login" class="btn btn-danger">Log In</button>
                </form>
                <br/>

                <?php
                // if (isset($adminData)) {
                //     echo $adminData;
                // }
                ?>
            </div>

            <div class="col-lg-3">

            </div>
        </div>
    </div> -->
<?php include '../inc/footer.php'; ?>