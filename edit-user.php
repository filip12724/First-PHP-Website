<?php
session_start();
include_once("Methods/functions.php");
include_once("Methods/conn.php");
isAdmin();
if(isset($_GET['id'])){
    $id=$_GET['id'];
}
global $conn;

$query="SELECT * FROM customers WHERE customer_id=:id";

$x=$conn->prepare($query);

$x->bindParam(":id",$id);

$x->execute();

$customer=$x->fetch();

if(isset($_GET['customerError'])){
    $error=$_GET['customerError'];
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
    <link rel="stylesheet" href="assets/css/admin.css" type="text/css">
</head>
<body>
<!-- ***** Preloader Start ***** -->
<?php include_once("header.php") ?>
<!-- ***** Header Area End ***** -->

<div class="page-heading header-text">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>EDIT PRODUCT</h3>
                <span class="breadcrumb"><a href="#">Home</a>  > Edit product</span>
            </div>
        </div>
    </div>
</div>

  <?php if(!empty($error)): ?>
  <p class="alert alert-danger"><?=$error?></p>
  <?php endif; ?>
<div class="edit-product-container">
    <form action="confirmUpdate.php?type=customer" method="POST">
        <input type="hidden" name="customerId" value="<?=$customer->customer_id?>">

        <label for="productName" class="input-label">Customer Name:</label>
        <input type="text" id="productName" name="customerName" class="input-field" value="<?=$customer->customer_fname?>">

        <label for="productImage" class="input-label">Customer Last Name:</label>
        <input type="text" id="productImage" name="customerLname" class="input-field" value="<?=$customer->customer_lname?>">

        <label for="gameId" class="input-label">Email</label>
        <input type="text" id="gameId" name="email" class="input-field" value="<?=$customer->email?>">

        <label for="oldPrice" class="input-label">Phone Number</label>
        <input type="text" id="oldPrice" name="phone" class="input-field" value="<?=$customer->phone?>">

        <label for="newPrice" class="input-label">Address</label>
        <input type="text" id="newPrice" name="address" class="input-field" value="<?=$customer->street_address?>">
        <div class="button-container">
            <button type="submit">Save Changes</button>
        </div>
    </form>
</div>




<?php include_once("footer.php") ?>


<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/isotope.min.js"></script>
<script src="assets/js/owl-carousel.js"></script>
<script src="assets/js/counter.js"></script>
<script src="assets/js/custom.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>

