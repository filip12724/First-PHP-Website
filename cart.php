<?php
session_start();

include_once ("Methods/functions.php");
include_once ("Methods/conn.php");

if(isset($_SESSION['user'])){
    $user=$_SESSION['user'];
} else {
    header("Location: log-in.php?message=You must be logged in to access the cart feature on our website");
    exit;
}

global $conn;

if (isset($_GET['product_id']) && isset($_GET['quantity'])) {
    $product_id = $_GET['product_id'];
    $quantity = $_GET['quantity'];
    $product_exists = false;
    foreach ($_SESSION['cart'] as $key => $item) {
        if ($item['product_id'] == $product_id) {
            $_SESSION['cart'][$key]['quantity'] = (int)$_SESSION['cart'][$key]['quantity'] + (int)$quantity;
            $product_exists = true;
            break;
        }
    }

    if (!$product_exists) {
        $_SESSION['cart'][] = array(
            'product_id' => $product_id,
            'quantity' => $quantity
        );
    }

    header("Location: ".$_SERVER['PHP_SELF']);
}

$cartProducts = array();

if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    foreach($_SESSION['cart'] as $item) {
        $product_id = $item['product_id'];
        $quantity = $item['quantity'];

        $query = "SELECT product_id,product_name, product_img, alt, old_price, new_price
                    FROM products WHERE product_id=:id";

        $stmt = $conn->prepare($query);
        $stmt->bindParam(":id", $product_id);
        $stmt->execute();
        $cartProduct = $stmt->fetch();

        $cartProducts[] = array(
            'product' => $cartProduct,
            'quantity' => $quantity
        );
    }
    $totalPrice = 0;

    foreach ($cartProducts as $cartItem) {
        if ($cartItem['product']->new_price == null) {
            $totalPrice += intval($cartItem['product']->old_price) * intval($cartItem['quantity']);
        } else {
            $totalPrice += intval($cartItem['product']->new_price) * intval($cartItem['quantity']);
        }
    }
}

if (isset($_GET['error'])) {
    $error = $_GET['error'];
}
if(isset($_GET['message'])){
    $message=$_GET['message'];
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
    <link rel="stylesheet" href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <link rel="stylesheet" href="assets/css/style.css" type="text/css"/>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"/>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.bundle.min.js"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.min.js"/>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"/>
    <link href="assets/css/mycss.css" rel="stylesheet" type="text/css"/>
</head>
<body>
<!-- ***** Preloader Start ***** -->
<div id="js-preloader" class="js-preloader">
    <div class="preloader-inner">
        <span class="dot"></span>
        <div class="dots">
            <span></span>
            <span></span>
            <span></span>
        </div>
    </div>
</div>
<!-- ***** Preloader End ***** -->
<!-- ***** Header Area Start ***** -->
<?php include_once ("header.php")?>
<!-- ***** Header Area End ***** -->
<div class="page-heading header-text">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>Cart</h3>
                <span class="breadcrumb"><a href="#">Home</a>  >  <a href="#">Shop</a>  >  Cart</span>
            </div>
        </div>
    </div>
</div>
<div class="card">

    <div class="row">
        <div class="col-md-8 cart">
            <div class="title">
                <div class="row">
                    <div class="col"><h4><b>Shopping Cart</b></h4></div>
                </div>
            </div>
            <?php if(isset($error)): ?>
                <p class="alert alert-danger"><?=$error?></p>
            <?php endif; ?>

            <form id="checkoutForm" action="checkout_process.php" method="POST">
                <?php foreach ($cartProducts as $index => $cartItem): ?>
                    <?php if (!empty($cartItem['quantity'])): ?>
                        <div class="row border-top border-bottom">
                            <div class="row main align-items-center">
                                <div class="col-auto">
                                    <img class="img-fluid" src="<?= $cartItem['product']->product_img ?>" alt="<?= $cartItem['product']->alt ?>">
                                </div>
                                <div class="col">
                                    <div class="row text-muted"><?= $cartItem['product']->product_name ?></div>
                                </div>
                                <div class="col">
                                    <a class="quantity-label" >
                                        <?= $cartItem['quantity'] ?>
                                    </a>
                                </div>

                                <?php if ($cartItem['product']->new_price == null): ?>
                                    <div class="col">$ <?= $cartItem['product']->old_price * $cartItem['quantity'] ?>
                                        <button class="close-button" style="width: 30px" data-index="<?= $index ?>">X</button>
                                    </div>
                                <?php else: ?>
                                    <div class="col">$<?= $cartItem['product']->new_price * $cartItem['quantity'] ?>
                                        <button class="close-button" style="width: 30px" data-index="<?= $index ?>">X</button>
                                    </div>
                                <?php endif; ?>
                            </div>
                        </div>

                    <?php endif; ?>

                <?php endforeach; ?>
                <p>Enter your address here</p>
                <input id="code" name="address" placeholder="Enter your address" value="<?= $user->street_address ?>">
                <div class="back-to-shop"><a href="shop.php">&leftarrow;<span class="text-muted">Back to shop</span></a></div>
            </form>
        </div>
        <div class="col-md-4 summary">
            <div><h5><b>Summary</b></h5></div>

            <div>

            </div>
            <div class="row" style="border-top: 1px solid rgba(0,0,0,.1); padding: 2vh 0;">
                <div class="col">TOTAL PRICE</div>
                <?php if(empty($totalPrice)): ?>

                    <span name="totalPrice">$0</span>
                <?php else: ?>
                    <span name="totalPrice">$<?=$totalPrice?></span>
                <?php endif; ?>
            </div>
            <button type="submit" form="checkoutForm" class="btn">BUY NOW</button>
        </div>
    </div>

</div>
<?php if(isset($_GET['message'])): ?>
    <p class="alert"><?=$message?></p>
<?php endif; ?>

<?php if(isset($_GET['error'])): ?>
    <p class="alert"><?=$error?></p>
<?php endif; ?>

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
