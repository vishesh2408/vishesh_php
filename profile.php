<?php include 'inc/header.php'; ?>
<?php
  Session::checkSession();
  $userId = Session::get("userId");
?>
<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$userProfile = $user->getUserPData($userId, $_POST);
}
?>


<div style="width: 100%; max-width: 1200px; margin: 0 auto; padding: 20px;">
    <div style="display: flex; justify-content: space-between; flex-wrap: wrap; margin: 20px 0;">
        <div style="width: 100%; text-align: center;">
            <h1 style="margin-top: 50px; color: #333;">Update Your Profile</h1>
            <?php
            if (isset($userProfile)) {
                echo '<div style="background-color: #d1ecf1; color: #0c5460; padding: 10px; border-radius: 4px; margin-bottom: 20px;">' . $userProfile . '</div>';
            }
            ?>
        </div>

        <div style="width: 30%; padding: 10px;"></div>

        <div style="width: 30%; padding: 10px;">
            <div style="background-color: #fff; box-shadow: 0px 4px 8px rgba(0, 0, 0, 0.1); border-radius: 8px; padding: 20px; margin-bottom: 20px;">
                <form action="" method="post">
                    <?php
                    $getData = $user->getUserProfile($userId);
                    if ($getData) {
                        while ($result = $getData->fetch_assoc()) {
                            ?>
                            <div style="margin-bottom: 15px;">
                                <label for="name" style="font-weight: bold;">Name</label>
                                <input type="text" name="name" value="<?php echo $result['name']; ?>" id="name" style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;">
                            </div>
                            <div style="margin-bottom: 15px;">
                                <label for="userName" style="font-weight: bold;">User Name</label>
                                <input type="text" name="userName" value="<?php echo $result['userName']; ?>" id="userName" style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;">
                            </div>
                            <div style="margin-bottom: 15px;">
                                <label for="email" style="font-weight: bold;">Email</label>
                                <input type="email" name="email" value="<?php echo $result['email']; ?>" id="email" style="width: 100%; padding: 10px; margin-top: 5px; border: 1px solid #ccc; border-radius: 4px;">
                            </div>
                            <div style="margin-bottom: 15px;">
                                <button type="submit" style="padding: 10px 15px; background-color: #17a2b8; color: #fff; border: none; border-radius: 4px; cursor: pointer; transition: background-color 0.3s;">
                                    Update Info
                                </button>
                            </div>
                        <?php }
                    }
                    ?>
                </form>
            </div>
        </div>

        <div style="width: 30%; padding: 10px;"></div>
    </div>

    <div style="text-align: center; margin-top: 40px; color: #777;">
        <p style="margin: 0;">Contact Support | Terms & Conditions | Privacy Policy</p>
    </div>
</div>


    <!-- <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="mt-5">Update Your Profile</h1>
                <?php
                // if (isset($userProfile)) {
                //     echo $userProfile;
                // }
                ?>
                <br/>
            </div>


            <div class="col-lg-4">

                
                
            </div>

            <div class="col-lg-4">
                <form action="" method="post">
                    <?php
                    // $getData = $user->getUserProfile($userId);
                    // if ($getData) {
                    //     while ($result = $getData->fetch_assoc()) {
                            ?>
                            <table>
                                <tr>
                                    <td>Name</td>
                                    <td><input type="text" class="form-control" name="name" value="<?php //echo $result['name']; ?>" id="name"></td>
                                </tr>
                                <tr>
                                    <td>User Name </td>
                                    <td><input type="text" class="form-control" name="userName" value="<?php //echo $result['userName']; ?>" id="userName"></td>
                                </tr>
                                <tr>
                                    <td>Email</td>
                                    <td><input name="email" class="form-control" type="email" value="<?php //echo $result['email']; ?>" id="email"></td>
                                </tr>

                                <tr>
                                    <td></td>
                                    
                                    <td><input type="submit" id="profileUpdate" class="btn btn-info" value="Update Info">
                                    </td>
                                </tr>
                            </table>
                        <?php // }  } ?>
                        
                </form>
            </div>

            <div class="col-lg-4">

            </div>
        </div>
    </div> -->

<?php include 'inc/footer.php'; ?>