<?php include 'inc/header.php'; ?>
<?php
 Session::checkSession();
$total    = $exam->getTotalRows(); 
?>

<div class="container" style="width: 100%; padding: 20px; max-width: 1200px; margin: 0 auto;">
    <div class="row" style="display: flex; flex-wrap: wrap; justify-content: center; gap: 20px;">
        
        <!-- Main Title Section -->
        <div style="text-align: center; flex-basis: 100%; margin-top: 50px;">
            <h1 style="font-size: 30px; color: #333;">All Question & Answer - Total <?php echo $total; ?> Questions</h1>
        </div>
        
        <!-- Empty Column (for spacing) -->
        <div style="flex-basis: 10%;"></div>

        <!-- Main Content Area for Questions -->
        <div style="flex-basis: 80%; max-width: 800px;">
            <form method="post" action="starttest.php">
                <table style="width: 100%; border-collapse: collapse; margin-top: 30px;">
                    <?php
                    $getQues = $exam->getqueData();
                    if ($getQues) {
                        while ($question = $getQues->fetch_assoc()) {
                            ?>
                            <tr>
                                <td colspan="2">
                                    <h5 style="font-size: 18px; color: #333;">Ques. <?php echo $question['quesNo']." : ".$question['ques']; ?></h5>
                                </td>
                            </tr>
                            <?php
                            $quesnumber = $question['quesNo'];
                            $answer = $exam->getAnswer($quesnumber);
                            if ($answer) {
                                $counter = 1; // For assigning unique radio button name
                                while ($result = $answer->fetch_assoc()) {
                                    ?>
                                    <tr>
                                        <td>
                                            <input type="radio" name="ques<?php echo $quesnumber; ?>" value="<?php echo $counter; ?>" style="margin-right: 10px;" 
                                            <?php echo ($result['rightAns'] == '1') ? 'style="background-color: green;"' : ''; ?> />
                                            <?php
                                            if ($result['rightAns'] == '1') {
                                                echo "<span style='color: green; font-weight: bold;'>".$result['ans']." (Correct Ans)</span>";
                                            } else {
                                                echo $result['ans'];
                                            }
                                            ?>
                                        </td>
                                    </tr>
                                    <?php 
                                    $counter++; 
                                }
                            }
                        }
                    }
                    ?>
                </table>

                <!-- Interactive Start Exam Button -->
                <a href="starttest.php" style="
                    display: inline-block;
                    background-color: #28a745;
                    color: white;
                    padding: 15px 30px;
                    text-align: center;
                    font-size: 18px;
                    font-weight: bold;
                    border-radius: 5px;
                    text-decoration: none;
                    transition: background-color 0.3s ease, transform 0.3s ease;
                    box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
                    margin-top: 20px;
                " 
                onmouseover="this.style.backgroundColor='#218838'; this.style.transform='scale(1.05)';"
                onmouseout="this.style.backgroundColor='#28a745'; this.style.transform='scale(1)';">
                    <span class="fa fa-arrow-right" style="margin-right: 10px;"></span> Start Exam
                </a>
            </form>
        </div>

        <!-- Empty Column (for spacing) -->
        <div style="flex-basis: 10%;"></div>
    </div>
</div>

<?php include 'inc/footer.php'; ?>




















<!-- <?php //include 'inc/header.php'; ?>
<?php
//  Session::checkSession();
// $total    = $exam->getTotalRows(); 
?>


<div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="mt-5">All Question & Answer - Total <?php //echo $total; ?> Questions</h1>
                <br/>
                <br/></div>

                <div class="col-lg-3">
                
                </div>

                <div class="col-lg-6">
                    <table>
                        <?php
                        // $getQues = $exam->getqueData();
                        // if ($getQues) {
                        //     while ($question = $getQues->fetch_assoc()) {
                                ?>
                                <tr>
                                    <td colspan="2">
                                        <h5>Ques. <?php //echo $question['quesNo']." : ".$question['ques']; ?></h5>
                                    </td>
                                </tr>
                                <?php
                                // $quesnumber = $question['quesNo'];
                                // $answer = $exam->getAnswer($quesnumber);
                                // if ($answer) {
                                //     while ($result = $answer->fetch_assoc()) {
                                        ?>
                                        <tr>
                                            <td>
                                                <input type="radio" /><?php
                                                // if ($result['rightAns'] == '1') {
                                                //     echo "<span style='color:green;font-weight: bold;'>".$result['ans']." (Correct Ans)</span>";
                                                // }else{
                                                //     echo $result['ans'];
                                                // }
                                                ?>
                                            </td>
                                        </tr>
                                    <?php //} } ?>
                            <?php// } } ?>
                    </table>
    
    
                    <a href="starttest.php" class="btn btn-success btn-lg">
                        <span class="fa fa-arrow-right"></span> Start Exam
                    </a>
                    <br/>
                    <br/>
                </div>

                <div class="col-lg-3">

                </div>
            </div>
        </div>
    </div>
<?php //include 'inc/footer.php'; ?> -->