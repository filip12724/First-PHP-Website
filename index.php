<?php
session_start();
include_once ("Methods/conn.php");
global $conn;

$upit = "SELECT product_id,product_name, product_img, alt, old_price, new_price,
                ((old_price - new_price) / old_price) * 100 AS discount_percentage
         FROM products
         ORDER BY discount_percentage DESC
         LIMIT 1;";

$biggeestDiscount=$conn->query($upit)->fetch();

$procentage=(($biggeestDiscount->old_price-$biggeestDiscount->new_price)/$biggeestDiscount->old_price)*100;
$finalProcentage=round($procentage);


$upitZaNajprodavanije = "
SELECT p.product_id,p.product_name, p.product_img, p.alt, GROUP_CONCAT(DISTINCT category.category_name) AS categories, SUM(op.quantity) AS total_quantity
FROM products p 
INNER JOIN products_category ON p.product_id = products_category.product_id
INNER JOIN category ON products_category.category_id = category.category_id
LEFT JOIN orders_products op ON p.product_id = op.product_id
GROUP BY p.product_id, p.product_name, p.product_img, p.alt
ORDER BY total_quantity DESC
LIMIT 6;
";


$mostSoldProcuts=$conn->query($upitZaNajprodavanije)->fetchAll();

$upit3 = "SELECT 
    p.product_id,
    p.product_name,
    p.product_img,
    p.alt,
    p.game_id,
    p.old_price,
    p.new_price,
    p.isTrending,
    p.description,
    GROUP_CONCAT(DISTINCT c.category_name ORDER BY c.category_name SEPARATOR ', ') AS category_names
FROM 
    products p
INNER JOIN 
    products_category pc ON p.product_id = pc.product_id
INNER JOIN 
    category c ON pc.category_id = c.category_id
WHERE 
    p.isTrending = 1
GROUP BY 
    p.product_id;";

$trendingProducts = $conn->query($upit3)->fetchAll();
//foreach ($trendingProducts as $x){
//var_dump($x);
//}
?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>    <title>Lugx Gaming Shop HTML5 Template</title>

    <!-- Bootstrap core CSS -->
    <link href="vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="assets/css/fontawesome.css">
    <link rel="stylesheet" href="assets/css/templatemo-lugx-gaming.css">
    <link rel="stylesheet" href="assets/css/owl.css">
    <link rel="stylesheet" href="assets/css/animate.css">
    <link rel="stylesheet"href="https://unpkg.com/swiper@7/swiper-bundle.min.css"/>
    <!--   //<link rel="stylesheet" href="assets/css/style.css" type="text/css"/>-->
    <link rel="stylesheet" href="assets/css/mycss.css" type="text/css"/>
</head>

<body>

<!-- ***** Preloader Start ***** -->
<?php include_once ("header.php")?>
<!-- ***** Header Area End ***** -->

<div class="main-banner">
    <div class="container">
        <div class="row">
            <div class="col-lg-6 align-self-center">
                <div class="caption header-text">
                    <h6>Welcome to lugx</h6>
                    <h2>BEST GAMING SITE EVER!</h2>
                    <div class="welcome-message">
                        <p>At Lugx Gaming, we're passionate about gaming just as much as you are. Step into a world where gaming transcends boundaries, where every click, every move, and every victory creates unforgettable experiences.</p>
                        <p>Explore our vast collection of video games curated for gamers of all ages and preferences. From action-packed adventures to immersive role-playing epics, we have something for everyone.</p>

                    </div>

                </div>
            </div>
            <div class="col-lg-4 offset-lg-2">
                <h4 id="main-product" class="active"><?=$biggeestDiscount->product_name?></h4>
                <div class="right-image">

                    <a href="product-details.php?id=<?=$biggeestDiscount->product_id?>"><img src="<?=$biggeestDiscount->product_img?>" alt="<?=$biggeestDiscount->alt?>"></a>

                    <span class="price"><em id="main-price">$<?=$biggeestDiscount->old_price?></em>$<?=$biggeestDiscount->new_price?></span>

                    <span class="offer">-<?=$finalProcentage?>%</span>

                </div>

            </div>
        </div>
    </div>
</div>

<div class="features">
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <a href="#">
                    <div class="item">
                        <div class="image">
                            <img src="assets/images/featured-01.png" alt="" style="max-width: 44px;">
                        </div>
                        <h4>Free Storage</h4>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="#">
                    <div class="item">
                        <div class="image">
                            <img src="assets/images/featured-02.png" alt="" style="max-width: 44px;">
                        </div>
                        <h4>User More</h4>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="#">
                    <div class="item">
                        <div class="image">
                            <img src="assets/images/featured-03.png" alt="" style="max-width: 44px;">
                        </div>
                        <h4>Reply Ready</h4>
                    </div>
                </a>
            </div>
            <div class="col-lg-3 col-md-6">
                <a href="#">
                    <div class="item">
                        <div class="image">
                            <img src="assets/images/featured-04.png" alt="" style="max-width: 44px;">
                        </div>
                        <h4>Easy Layout</h4>
                    </div>
                </a>
            </div>
        </div>
    </div>
</div>

<div class="section trending">
    <div class="container">
        <div class="row" id="trend">
            <div class="col-lg-6">
                <div class="section-heading">
                    <h6>Trending</h6>
                    <h2>Trending Games</h2>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="main-button">
                    <a href="shop.php">View All</a>
                </div>
            </div>
            <?php foreach ($trendingProducts as $trend): ?>
                <div class="col-lg-3 col-md-6">
                    <div class="item">
                        <div class="thumb">
                            <a href="product-details.php?id=<?=$trend->product_id?>"><img src="<?=$trend->product_img?>" alt="<?=$trend->alt?>"></a>
                            <?php if($trend->new_price == null): ?>
                                <span class="price">$<?=$trend->old_price?></span>
                            <?php else: ?>
                                <span class="price"><em>$<?=$trend->old_price?></em>$<?=$trend->new_price?></span>
                                <div class="discount">-<?=round((($trend->old_price - $trend->new_price) / $trend->old_price) * 100)?>%</div>
                            <?php endif; ?>
                        </div>
                        <div class="down-content">
                            <span class="category"><?=$trend->category_names?></span>
                            <h4><?=$trend->product_name?></h4>

                            <a href="product-details.php?id=<?=$trend->product_id?>"><i class="fa fa-shopping-bag"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</div>



<div class="section most-played">
    <div class="container">
        <div class="row">
            <div class="col-lg-6">
                <div class="section-heading">
                    <h6>TOP GAMES</h6>
                    <h2>Most Sold</h2>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="main-button">
                    <a href="shop.php">View All</a>
                </div>
            </div>
            <?php foreach ($mostSoldProcuts as $products):  ?>
                <div class="col-lg-2 col-md-6 col-sm-6">
                    <div class="item">
                        <div class="thumb">
                            <a href="product-details.php?id=<?=$products->product_id?>"><img src="<?=$products->product_img?>" alt="<?=$products->alt?>"></a>
                        </div>
                        <div class="down-content">
                            <span class="category"><?=$products->categories?></span>
                            <h4><?=$products->product_name?></h4>
                            <strong><span class="category"><?=round($products->total_quantity/3)?> Copies sold!</span></strong>
                            <a href="product-details.php?id=<?=$products->product_id?>">Explore</a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
</div>



<div class="section cta">
    <div class="container">
        <div class="row">
            <div class="col-lg-5">
                <div class="shop">
                    <div class="row">
                        <div class="col-lg-12">
                            <div class="section-heading">
                                <h6>Our Shop</h6>
                                <h2>Go Pre-Order Buy & Get Best <em>Prices</em> For You!</h2>
                            </div>
                            <p>Lorem ipsum dolor consectetur adipiscing, sed do eiusmod tempor incididunt.</p>
                            <div class="main-button">
                                <a href="shop.php">Shop Now</a>
                            </div>
                        </div>
                    </div>
                </div>
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