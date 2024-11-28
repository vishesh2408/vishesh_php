<?php include 'inc/header.php'; ?>
<?php
  Session::checkSession();
?>

    <!-- <div class="container">
        <div class="row">
            <div class="col-lg-12 text-center">
                <h1 class="mt-5">You can start your exam</h1>
                <p class="lead">Take your time. Click Start Exam when you are ready.</p>
                <img src="img/takeTest.png" height="200" width="200"/>
                <br/>
                <br/>

                <a href="starttest.php" class="btn btn-success btn-lg">
                    <span class="fa fa-arrow-right"></span> Start Exam Now!
                </a>
                <br/>
                <br/>
            </div>
        </div>
    </div> -->

    <div style="width: 100%; display: flex; justify-content: space-between; align-items: center; padding: 20px; margin-bottom:50px">
    <!-- Left Column for Image -->
    <div style="flex: 1; text-align: left;">
        <img src="img/takeTest.png" alt="Start Exam Image" style="height: 200px; width: 200px;"/>
    </div>

    <!-- Right Column for Content -->
    <div style="flex: 1; text-align: right; margin-right:60px">
        <h1 style="margin-top: 5rem;">You can start your exam</h1>
        <p style="font-size: 1.25rem; color: #555; ">Take your time. Click Start Exam when you are ready.</p>
        <a href="starttest.php" style="display: inline-block; background-color: #28a745; color: white; padding: 15px 30px; font-size: 1.2rem; text-decoration: none; border-radius: 5px; cursor: pointer; margin-left:30px">
            <span style="margin-right: 10px;">&#x2192;</span> Start Exam Now!
        </a>
    </div>
</div>


<?php include 'inc/footer.php'; ?>