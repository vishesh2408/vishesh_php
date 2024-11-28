<?php include 'inc/header.php'; ?>
<?php
Session::checkSession();
if (isset($_GET['q'])) {
    $quesnumber = (int) $_GET['q'];
} else {
    header("Location:exam.php");
}
$total = $exam->getTotalRows();
$question = $exam->getQuestionNumber($quesnumber);
?>

<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $process = $pro->getProcessData($_POST);
}
?>

<div class="container" style="max-width: 800px; margin: 0 auto; padding: 20px;">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 style="font-size: 28px; color: #333; margin-top: 30px;">Question <?php echo $question['quesNo'] . " of " . $total; ?></h1>
            <br/>
            <br/>
        </div>

        <div class="col-lg-3" style="flex: 0 0 25%;"></div>

        <div class="col-lg-6" style="flex: 0 0 50%; padding: 20px; background-color: #fff; border-radius: 8px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
            <form method="post" action="">
                <table style="width: 100%; border-collapse: collapse;">
                    <tr>
                        <td colspan="2">
                            <h3 style="font-size: 24px; margin: 20px 0;"><?php echo $question['quesNo'] . " : " . $question['ques']; ?></h3>
                        </td>
                    </tr>
                    <?php
                    $answer = $exam->getAnswer($quesnumber);
                    if ($answer) {
                        while ($result = $answer->fetch_assoc()) {
                    ?>
                            <tr>
                                <td>
                                    <div class="form-check" style="margin-bottom: 15px; padding: 10px; background-color: #fff; border-radius: 5px; box-shadow: 0 2px 5px rgba(0, 0, 0, 0.1);">
                                        <label class="form-check-label" style="font-size: 18px; cursor: pointer;">
                                            <input type="radio" name="ans" class="form-check-input" value="<?php echo $result['id']; ?>" style="margin-right: 10px; cursor: pointer; accent-color: #4CAF50; transition: background-color 0.3s ease;" /><?php echo $result['ans']; ?>
                                        </label>
                                    </div>
                                </td>
                            </tr>
                    <?php 
                        }
                    }
                    ?>
                    <tr>
                        <td>
                            <br/>
                            <input type="submit" name="submit" class="btn-next" value="Continue" style="background-color: #4CAF50; color: white; padding: 10px 20px; border: none; border-radius: 5px; cursor: pointer; transition: background-color 0.3s;" onmouseover="this.style.backgroundColor='#45a049'" onmouseout="this.style.backgroundColor='#4CAF50'" />
                            <input type="hidden" name="quesnumber" value="<?php echo $quesnumber; ?>" />
                        </td>
                    </tr>

                </table>
            </form>
            <br/>
            <br/>
        </div>

        <div class="col-lg-3" style="flex: 0 0 25%;"></div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>






<!-- <?php //include 'inc/header.php'; ?>
<?php
//  Session::checkSession();
//  if (isset($_GET['q'])) {
//  	$quesnumber = (int) $_GET['q'];
//  }else{
//  	header("Location:exam.php");
//  }
//  $total    = $exam->getTotalRows();
//  $question = $exam->getQuestionNumber($quesnumber);

?>
<?php
 //if ($_SERVER['REQUEST_METHOD'] == 'POST') {
 	//$process = $pro->getProcessData($_POST);
// }

 
?>

    <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="mt-5">Question <?php //echo $question['quesNo']." of ". $total; ?></h1>
                <br/>
                <br/>
            </div>


            <div class="col-lg-3">
                
            </div>

            <div class="col-lg-6">
                <form method="post" action="">
                    <table>
                        <tr>
                            <td colspan="2">
                                <h3>Question <?php //echo $question['quesNo']." : ".$question['ques']; ?></h3>
                            </td>
                        </tr>
                        <?php
                        // $answer = $exam->getAnswer($quesnumber);
                        // if ($answer) {
                        //     while ($result = $answer->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td>
                                        <div class="form-check">
                                            <label class="form-check-label">
                                                <input type="radio" name="ans" class="form-check-input" value="<?php //echo $result['id']; ?>" /><?php echo $result['ans']; ?>
                                            </label>
                                        </div>

<!-                                        <input type="radio" name="ans" value="--><?php //echo $result['id']; ?><!--" />--><?php //echo $result['ans']; ?>
                                    </td>
                                </tr>
                            <?php //} } ?>
                        <!-- <tr>
                            <td>
                                <br/>
                                <input type="submit" name="submit" class="btn btn-primary" value="Continue" />
                                <input type="hidden" name="quesnumber"
                                       value="<?php //echo $quesnumber; ?>" /> -->
                            <!-- </td>
                        </tr>

                    </table>
                </form>
                <br/>
                <br/>
            </div>

            <div class="col-lg-3">

            </div>
        </div>
    </div> -->

<?php //include 'inc/footer.php'; ?> 