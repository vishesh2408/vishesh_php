<?php 
    $filepath = realpath(dirname(__FILE__));
    include_once ($filepath.'/inc/header.php');
    include_once ($filepath.'/../classes/Exam.php');
    $exam = new Exam();
?>
<?php
  if (isset($_GET['delque'])) {
    $quesNo = (int)$_GET['delque'];
    $delresult = $exam->getdelresult($quesNo);
  }
?>

<div class="container" style="width: 100%; padding: 20px;">
    <div class="row" style="display: flex; justify-content: center;">
        <div class="col-lg-12 text-center" style="text-align: center;">
            <?php
            if (isset($delresult)) {
                echo $delresult;
            }
            ?>
            <h1 style="margin-top: 50px; font-size: 24px;">Question List</h1>
            <br/>
        </div>

        <div class="col-lg-12" style="width: 100%; padding: 0;">
            <table style="width: 100%; border-collapse: collapse; margin-top: 20px; border: 1px solid #ddd;">
                <thead>
                    <tr style="margin-bottom: 10px">
                        <th style="width: 10%; padding: 8px; text-align: left; border-bottom: 1px solid #ddd;">#</th>
                        <th style="width: 70%; padding: 8px; text-align: left; border-bottom: 1px solid #ddd;">Question</th>
                        <th style="width: 20%; padding: 8px; text-align: left; border-bottom: 1px solid #ddd;">ACTION</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $questionData = $exam->getqueData();
                    if ($questionData) {
                        $i = 0;
                        while ($result = $questionData->fetch_assoc()) {
                            $i++;
                    ?>
                        <tr>
                            <td style="padding: 8px;"><?php echo $i; ?></td>
                            <td style="padding: 8px;"><?php echo $result['ques']; ?></td>
                            <td style="padding: 8px;"><a onclick="return confirm('Are you sure to Delete.')" href="?delque=<?php echo $result['quesNo']; ?>" style="background-color: #dc3545; color: white; padding: 8px 15px; text-decoration: none; border-radius: 5px; text-align: center; margin-bottom: 10px;">Remove</a></td>
                        </tr>
                    <?php } } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php include '../inc/footer.php'; ?>
















<?php 
    // $filepath = realpath(dirname(__FILE__));
	// include_once ($filepath.'/inc/header.php');
	// include_once ($filepath.'/../classes/Exam.php');
	// $exam = new Exam();
?>
<?php
//   if (isset($_GET['delque'])) {
//     $quesNo = (int)$_GET['delque'];
//     $delresult = $exam->getdelresult($quesNo);
  //}
?>

    <!-- <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center"> -->
                <?php
                // if (isset($delresult)) {
                //     echo $delresult;
                // }
                ?>
                <!-- <h1 class="mt-5">Question List</h1>
                <br/>
            </div>


            <div class="col-lg-12">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th width="10%">#</th>
                        <th width="70%">Question</th>
                        <th width="20%">ACTION</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    // $questionData = $exam->getqueData();
                    // if ($questionData) {
                    //     $i = 0;
                    //     while ($result = $questionData->fetch_assoc()) {
                    //         $i++;

                            ?>
                            <tr>
                                <td><?php
                                // echo $i; 
                                 ?>
                                 </td>
                                <td><?php 
                                //echo $result['ques']; 
                                ?></td>
                                <td><a class="btn btn-danger" onclick="return confirm('Are you sure to Delete.')" href="?delque=<?php 
                                //echo $result['quesNo']; 
                                ?>">Remove</a>
                                </td>
                            </tr> -->
                        <?php 
                   // } } 
                    ?>
                    <!-- </tbody>
                </table>

            </div>
        </div>
    </div> -->

<?php
 //include '../inc/footer.php';
  ?>