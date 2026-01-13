<?php include 'inc/header.php'; ?>
<?php
  Session::checkSession();
  $question = $exam->getQuestion();
  $total    = $exam->getTotalRows();
?>


<div style="width: 100%; text-align: center; margin-top: 50px;">
    <h1 style="font-size: 36px; margin-top: 50px;">Welcome to Online Examination</h1>
    <p style="font-size: 20px; font-weight: bold;">Test Your Knowledge</p>
    <br/>

    <p style="font-size: 20px; font-weight: bold;">Total Number Of Question: <b><?php echo $total; ?></b></p>
    <p style="font-size: 20px; font-weight: bold;">Question Type: Multiple Choice (MCQ)</p>

    <form action="test.php" method="get">
        <input type="hidden" name="q" value="<?php echo $question['quesNo']; ?>">
        <button type="submit" style="padding: 15px 30px; font-size: 20px; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; margin-top: 20px;">
            <span class="fa fa-arrow-right" style="margin-right: 10px;"></span> Proceed
        </button>
    </form>

    <br/>
    <br/>
</div>


    <!-- <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="mt-5">Welcome to Online Examination</h1>
                <p class="lead">Test Your Knowledge</p>
                <br/>

                <p class="lead">Total Number Of Question: </strong><b><?php echo $total; ?></b></p>
                <p></p><strong>Question Type: </strong>Multiple Choice (MCQ)</p>

                <a href="test.php?q=<?php //echo $question['quesNo']; ?>" class="btn btn-success btn-lg">
                    <span class="fa fa-arrow-right"></span> Proceed
                </a>

                <br/>
                <br/>
            </div>
        </div>
    </div> -->

<?php include 'inc/footer.php'; ?>