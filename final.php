<?php include 'inc/header.php'; ?>
<?php
  Session::checkSession();
?>

<div style="width: 100%; padding: 20px; text-align: center;">
    <h1 style="margin-top: 50px; font-size: 2.5em; font-family: Verdana, sans-serif;">Congratulations! You have just completed the test.</h1>
    <p style="font-size: 1.2em; font-family: Verdana, sans-serif; color: #555;">Check your final score. You can also check the correct answers.</p>
    <br/>

    <div style="padding: 20px; border: 2px solid #f44336; background-color: #f8d7da; border-radius: 10px; margin: 20px auto; width: fit-content;">
        <h1 style="color: #d32f2f; font-family: Verdana, sans-serif;">
            Final Score:
            <?php
            if (isset($_SESSION['score'])) {
                echo $_SESSION['score'];
                unset($_SESSION['score']);
            }
            ?>
        </h1>
    </div>
    <br/>
    <br/>
    <button onclick="window.location.href='viewans.php'" style="padding: 15px 30px; font-size: 1.2em; background-color: #28a745; color: white; border: none; border-radius: 5px; cursor: pointer; font-family: Verdana, sans-serif;">
        <span style="font-size: 1.5em; margin-right: 10px;">✔</span> View Answer
    </button>
    <button onclick="window.location.href='starttest.php'" style="padding: 15px 30px; font-size: 1.2em; background-color: #17a2b8; color: white; border: none; border-radius: 5px; cursor: pointer; font-family: Verdana, sans-serif; margin-left: 20px;">
        <span style="font-size: 1.5em; margin-right: 10px;">➡</span> Start Test
    </button>
    <br/>
    <br/>
</div>




<!-- 
<div class="container">
    <div class="row">
        <div class="col-lg-12 text-center">
            <h1 class="mt-5">Congratulations! You have just completed test.</h1>
            <p class="lead">Check your final score. You can also check the correct answers.</p>
            <br/>

            <div class="jumbotron">
            <h1 class="text-danger">Final Score:
                    <?php
                    // if (isset($_SESSION['score'])) {
                    //     echo $_SESSION['score'];
                    //     unset($_SESSION['score']);
                    // }
                    ?>
                </h1></div>
            <br/>
            <br/>
            <a class="btn btn-outline-success btn-lg" href="viewans.php"><span class="fa fa-check-circle"></span> View Answer</a>
            <a class="btn btn-outline-info btn-lg" href="starttest.php"><span class="fa fa-arrow-right"></span> Start Test</a>
            <br/>
            <br/>
        </div>
    </div>
</div> -->
<?php include 'inc/footer.php'; ?>