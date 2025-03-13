<?php
session_start();
include_once ("Methods/functions.php");
if(isset($_SESSION['user'])){
    header("Location: index.php");

}
if(isset($_GET['message'])) {
    $message = $_GET['message'];

}

?>

<!DOCTYPE html>
<html lang="en">
<head>

    <link href="assets/css/style.css" type="text/css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>Lugx Gaming Shop HTML5 Template</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-lugx-gaming.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>

</head>
<body>
<!-- ***** Preloader Start ***** -->
<?php include_once ("header.php")?>
<!-- ***** Header Area End ***** -->

<div class="page-heading header-text">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Log in</h3>
                <span class="breadcrumb"><a href="#">Home</a>  >   Log in</span>
            </div>
        </div>
    </div>
</div>



<div class="formbold-main-wrapper">
    <!-- Author: FormBold Team -->
    <!-- Learn More: https://formbold.com -->
    <div id="formica">
    <div class="formbold-form-wrapper">

        <?php if(isset($_GET['message'])): ?>
        <p class="alert alert-danger"><?=$message?></p>
        <?php endif; ?>
        <form>
            <div class="formbold-form-title">
                <h2 class="">Log In</h2>
            </div>

            <div class="formbold-input-flex">
                <div>
                    <label for="emailLog" class="formbold-form-label">
                        Email
                    </label>
                    <input
                        type="email"
                        name="email"
                        id="emailLog"
                        class="formbold-form-input"
                    />
                    <p id="email-errorLog" style="color:red"></p>
                </div>
            </div>

            <div class="formbold-input-flex">
                <div>
                    <label for="passwdLog" class="formbold-form-label"> Password </label>
                    <input
                        type="password"
                        name="password"
                        id="passwdLog"
                        class="formbold-form-input"
                    />
                    <p id="email-errorLog" style="color:red"></p>
                </div>

            </div>


            <button class="formbold-btn" id="btnLog" type="submit" >Log in</button>


        </form>

        <span id="nesto">Dont have an account? <a href="register.php">Create one!</a></span>

    </div>
    </div>
</div>




<?php include_once ("footer.php") ?>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/isotope.min.js"></script>
<script src="assets/js/owl-carousel.js"></script>
<script src="assets/js/counter.js"></script>
<script src="assets/js/custom.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>
