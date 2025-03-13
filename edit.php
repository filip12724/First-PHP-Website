<?php
session_start();
include_once("Methods/functions.php");
include_once("Methods/conn.php");
isAdmin();
if(isset($_GET['id'])){
    $id=$_GET['id'];
}
global $conn;
$query="SELECT * FROM products WHERE product_id=:id";

$x=$conn->prepare($query);
$x->bindParam(":id",$id);

$x->execute();

$product=$x->fetch();


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



<div class="edit-product-container">
    <form action="confirmUpdate.php?type=product" method="POST">
        <input type="hidden" name="productId" value="<?=$product->product_id?>">

        <label for="productName" class="input-label">Product Name:</label>
        <input type="text" id="productName" name="productName" class="input-field" value="<?=$product->product_name?>">

        <label for="productImage" class="input-label">Product Image:</label>
        <input type="text" id="productImage" name="productImage" class="input-field" value="<?=$product->product_img?>">

        <label for="gameId" class="input-label">Game ID:</label>
        <input type="text" id="gameId" name="gameId" class="input-field" value="<?=$product->game_id?>">

        <label for="oldPrice" class="input-label">Old Price:</label>
        <input type="text" id="oldPrice" name="oldPrice" class="input-field" value="<?=$product->old_price?>">

        <label for="newPrice" class="input-label">New Price:</label>
        <input type="text" id="newPrice" name="newPrice" class="input-field" value="<?=$product->new_price==null ? null : $product->new_price?>">

        <label class="input-label">Is Trending:</label>
        <div class="radio-container">
            <label for="Yes" class="radio-label">Yes</label>
            <input type="radio" id="Yes" name="isTrending" class="input-field radio" value="1" <?=$product->isTrending==1 ? "checked" : "" ?>>

            <label for="No" class="radio-label">No</label>
            <input type="radio" id="No" name="isTrending" class="input-field radio" value="0" <?=$product->isTrending==0 ? "checked" : "" ?>>
        </div>

        <label for="description" class="input-label">Description:</label>
        <textarea id="description" name="description" class="input-field" rows="4"><?=$product->description?></textarea>

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

