<?php

    include_once ("Methods/functions.php");

    if(isset($_SESSION['errors'])){
        $errors=$_SESSION['errors'];

        foreach ($errors as $field=>$error){
            echo "<p>Error in $field: $error</p>";
        }
        unset($_SESSION['errors']);
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

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="assets/css/mycss.css" type="text/css">
</head>
<body>
<!-- ***** Preloader Start ***** -->
<?php include_once ("header.php")?>
<!-- ***** Header Area End ***** -->

<div class="page-heading header-text">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Register</h3>
                <span class="breadcrumb"><a href="#">Home</a>  >   Register</span>
            </div>
        </div>
    </div>
</div>



<div class="formbold-main-wrapper">
    <!-- Author: FormBold Team -->
    <!-- Learn More: https://formbold.com -->
    <div class="formbold-form-wrapper">



        <form>
            <div class="formbold-form-title">
                <h2 class="">Register now</h2>
                <p>
                    Register to Access Your Cart Page and Start Shopping!
                </p>
            </div>

            <div class="formbold-input-flex">
                <div>
                    <label for="firstname" class="formbold-form-label">
                        First name
                    </label>
                    <input
                        type="text"
                        name="firstname"
                        id="firstname"
                        class="formbold-form-input"
                    />
                    <p id="fname-error" class="poruka" style="color:red"></p>
                </div>
                <div>
                    <label for="lastname" class="formbold-form-label"> Last name </label>
                    <input
                        type="text"
                        name="lastname"
                        id="lastname"
                        class="formbold-form-input"
                    />
                    <p id="lname-error" class="poruka" style="color:red"></p>
                    <div id="fname-error" class="error-message"></div>
                </div>
            </div>

            <div class="formbold-input-flex">
                <div>
                    <label for="email" class="formbold-form-label"> Email </label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="formbold-form-input"
                    />
                    <p id="email-error" class="poruka" style="color:red"></p>
                </div>
                <div>
                    <label for="phone" class="formbold-form-label"> Phone number </label>
                    <input
                        type="text"
                        name="phone"
                        id="phone"
                        class="formbold-form-input"
                    />
                    <p id="phone-error" class="poruka" style="color:red"></p>
                </div>
            </div>

            <div class="formbold-mb-3">
                <label for="address" class="formbold-form-label">
                    Street Address
                </label>
                <input
                    type="text"
                    name="address"
                    id="address"
                    class="formbold-form-input"
                />
                <p id="address-error" class="poruka" style="color:red"></p>
            </div>

            <div class="formbold-input-flex">
                <div>
                    <label for="state" class="formbold-form-label"> Password </label>
                    <input
                        type="password"
                        name="state"
                        id="password"
                        class="formbold-form-input"
                    />
                    <p id="passwd-error" class="poruka" style="color:red"></p>
                </div>
                <div>
                    <label for="country" class="formbold-form-label"> Repeat password </label>
                    <input
                        type="password"
                        name="country"
                        id="rpassword"
                        class="formbold-form-input"
                    />
                </div>
            </div>

            <button class="formbold-btn" id="btn" type="submit">Register Now</button>
            <div id="Message"></div>
        </form>
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
