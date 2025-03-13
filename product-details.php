<?php
session_start();
include_once ("Methods/conn.php");
global $conn;
if ($_SERVER["REQUEST_METHOD"] == "GET") {
    if (isset($_GET['id'])) {
        $id = $_GET["id"];
        $upit="SELECT * FROM products WHERE product_id=:id";
        $x=$conn->prepare($upit);

        $x->bindParam(":id",$id);

        $x->execute();

        $product=$x->fetch();
//        var_dump($product);
        $upit2="SELECT GROUP_CONCAT(category_name) as categories FROM category c INNER JOIN products_category p ON c.category_id=p.category_id
                                    WHERE p.product_id=:id";

        $y=$conn->prepare($upit2);
        $y->bindParam(":id",$id);
        $y->execute();

        $categories=$y->fetch();


        $categoryNames = $categories->categories;


        $categoryArray = explode(',', $categoryNames);
    }else {
        echo ("<div style='color: red; text-align: center; font-size: 20px; font-family: \"Poppins\", sans-serif;'>Access denied. Please navigate to this page through the proper channels.</div>");
        exit(); // Stop script execution
    }
}



?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>Lugx Gaming - Product Detail</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">

    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-lugx-gaming.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="assets/css/mycss.css" type="text/css">
    <!--

    TemplateMo 589 lugx gaming

    https://templatemo.com/tm-589-lugx-gaming

    -->
</head>

<body>

<!-- ***** Preloader Start ***** -->
<?php include_once ("header.php")?>
<!-- ***** Header Area End ***** -->

<div class="page-heading header-text">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3><?=$product->product_name?></h3>
                <span class="breadcrumb"><a href="#">Home</a>  >  <a href="#">Shop</a>  >  <?=$product->product_name?></span>
            </div>
        </div>
    </div>
</div>

<div class="single-product section">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="left-image">
                    <img src="<?=$product->product_img?>" alt="<?=$product->alt?>" class="slika">
                </div>
            </div>
            <div class="col-lg-6 align-self-center">
                <h4><?=$product->product_name?></h4>
                <?php if($product->new_price!=null): ?>
                    <span class="price"><em>$<?=$product->old_price?></em> $<?=$product->new_price?></span>
                <?php else: ?>
                    <span class="price">$<?=$product->old_price?></span>
                <?php endif; ?>
                <p><?=$product->description?></p>
                <form id="qty" action="cart.php" method="GET">
                    <input type="hidden" name="product_id" value="<?=$product->product_id?>">

                    <input type="number" name="quantity" class="form-control" id="quantityInput" aria-describedby="quantity" value="1" min="1" max="5">
                    <button type="submit" id="addToCartBtn"><i class="fa fa-shopping-bag"></i> ADD TO CART</button>
                </form>

                <ul>
                    <li><span>Game ID:</span> <?=$product->game_id?></li>
                    <li><span>Genre:</span>
                        <?php

                        echo "$categoryNames";


                        ?>
                    </li>

                </ul>
            </div>
            <div class="col-lg-12">
                <div class="sep"></div>
            </div>
        </div>
    </div>
</div>




<?php include_once ("footer.php"); ?>

<!-- Scripts -->
<!-- Bootstrap core JavaScript -->
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/isotope.min.js"></script>
<script src="assets/js/owl-carousel.js"></script>
<script src="assets/js/counter.js"></script>
<script src="assets/js/custom.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>