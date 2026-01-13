<?php 
    $filepath = realpath(dirname(__FILE__));
	include_once ($filepath.'/inc/header.php');
	include_once ($filepath.'/../classes/User.php');
	$user = new User();
?>

<?php 
 if (isset($_GET['dis'])) {
 	$disid = (int)$_GET['dis'];
 	$disuser = $user->disableUser($disid);
 }

 if (isset($_GET['ena'])) {
 	$enaid = (int)$_GET['ena'];
 	$enauser = $user->enaUser($enaid);
 }
  if (isset($_GET['del'])) {
 	$delid = (int)$_GET['del'];
 	$deluser = $user->delUser($delid);
 }
?>

<div style="max-width: 1200px; margin: 0 auto; padding: 20px;">
    <div style="text-align: center;">
        <h1 style="font-size: 36px; color: #333; margin-bottom: 30px;">Manage Users</h1>
    </div>

    <div style="overflow-x: auto;">
        <div style="border: 1px solid #ddd; border-radius: 10px; padding: 20px;">
            <table style="width: 100%; border-collapse: collapse;">
                <thead>
                    <tr>
                        <th style="border-bottom: 2px solid #ddd; padding: 12px; text-align: left;">#</th>
                        <th style="border-bottom: 2px solid #ddd; padding: 12px; text-align: left;">NAME</th>
                        <th style="border-bottom: 2px solid #ddd; padding: 12px; text-align: left;">USERNAME</th>
                        <th style="border-bottom: 2px solid #ddd; padding: 12px; text-align: left;">EMAIL</th>
                        <th style="border-bottom: 2px solid #ddd; padding: 12px; text-align: left;">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $userData = $user->getUserData();
                    if ($userData) {
                        $i = 0;
                        while ($result = $userData->fetch_assoc()) {
                            $i++;
                    ?>
                            <tr style="background-color: #f9f9f9; border-bottom: 1px solid #ddd;">
                                <td style="padding: 12px;">
                                    <?php
                                        if ($result['status'] == '1') {
                                            echo "<span style='color: red;'>".$i."</span>";
                                        }else{
                                            echo $i;
                                        }
                                    ?>
                                </td>
                                <td style="padding: 12px;"><?php echo $result['name']; ?></td>
                                <td style="padding: 12px;"><?php echo $result['userName']; ?></td>
                                <td style="padding: 12px;"><?php echo $result['email']; ?></td>
                                <td style="padding: 12px;">
                                    <a href="?del=<?php echo $result['userId']; ?>" onclick="return confirm('Are you sure you want to delete?')" 
                                       style="padding: 10px 20px; background-color: #e74c3c; color: white; text-decoration: none; border-radius: 5px; transition: background-color 0.3s;">
                                       Remove
                                    </a>
                                </td>
                            </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    // Hover effect for rows
    document.querySelectorAll('table tr').forEach(function(row) {
        row.addEventListener('mouseover', function() {
            row.style.backgroundColor = '#f1f1f1';
        });
        row.addEventListener('mouseout', function() {
            row.style.backgroundColor = '#f9f9f9';
        });
    });

    // Hover effect for "Remove" buttons
    document.querySelectorAll('a').forEach(function(button) {
        button.addEventListener('mouseover', function() {
            button.style.backgroundColor = '#c0392b';
        });
        button.addEventListener('mouseout', function() {
            button.style.backgroundColor = '#e74c3c';
        });
    });
</script>


<?php include '../inc/footer.php'; ?>














<!-- <?php 
    // $filepath = realpath(dirname(__FILE__));
	// include_once ($filepath.'/inc/header.php');
	// include_once ($filepath.'/../classes/User.php');
	// $user = new User();
?>
<?php 
//  if (isset($_GET['dis'])) {
//  	$disid = (int)$_GET['dis'];
//  	$disuser = $user->disableUser($disid);
//  }

//  if (isset($_GET['ena'])) {
//  	$enaid = (int)$_GET['ena'];
//  	$enauser = $user->enaUser($enaid);
//  }
//   if (isset($_GET['del'])) {
//  	$delid = (int)$_GET['del'];
//  	$deluser = $user->delUser($delid);
//  }
?>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="mt-5">Manage Users</h1>
                <br/>
            </div>


            <div class="col-lg-12">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>#</th>
                        <th>NAME</th>
                        <th>USERNAME</th>
                        <th>EMAIL</th>
                        <th>ACTION</th>
                    </tr>
                    </thead>
                <tbody>
                    <?php
                    // $userData = $user->getUserData();
                    // if ($userData) {
                    //     $i = 0;
                    //     while ($result = $userData->fetch_assoc()) {
                    //         $i++;

                            ?>
                            <tr>
                                <td><?php
                                    // if ($result['status'] == '1') {
                                    //     echo "<span class='error'>".$i."</span>";
                                    // }else{
                                    //     echo $i;
                                    // }


                                    ?></td>
                                <td><?php //echo $result['name']; ?></td>
                                <td><?php //echo $result['userName']; ?></td>
                                <td><?php //echo $result['email']; ?></td>
                                <td>
                                    <a class="btn btn-danger" onclick="return confirm('Are you sure to Delete?')" href="?del=<?php //echo $result['userId']; ?>">Remove</a>
                                </td>
                            </tr>
                        <?php //} } ?>
                <tbody>
                </table>

            </div>
        </div>
    </div>






<?php //include '../inc/footer.php'; ?> -->