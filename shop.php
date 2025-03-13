<?php
session_start();
include_once("Methods/conn.php");
global $conn;

$results_per_page = 8;

$total_products_query = "SELECT COUNT(*) as total FROM products";
$total_products_result = $conn->query($total_products_query);
$total_products = $total_products_result->fetch(PDO::FETCH_ASSOC)['total'];

$total_pages = ceil($total_products / $results_per_page);

$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

$starting_limit_number = ($current_page - 1) * $results_per_page;



$products_query = "SELECT 
                        p.product_id,
                        p.product_name,
                        p.product_img,
                        p.alt,
                        p.old_price,
                        p.new_price,
                        GROUP_CONCAT(DISTINCT c.category_name ORDER BY c.category_name SEPARATOR ', ') AS category_names
                    FROM 
                        products p
                    INNER JOIN 
                        products_category pc ON p.product_id = pc.product_id
                    INNER JOIN 
                        category c ON pc.category_id = c.category_id
                    GROUP BY 
                        p.product_id
                    LIMIT $starting_limit_number, $results_per_page";

$products = $conn->query($products_query)->fetchAll();

?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>Lugx Gaming - Shop Page</title>

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
                <h3>Our Shop</h3>
                <span class="breadcrumb"><a href="#">Home</a> > Our Shop</span>
            </div>
        </div>
    </div>
</div>

<div class="section trending">
    <div class="container">


        <div class="row trending-box">


            <?php foreach ($products as $product): ?>
                <div class="col-lg-3 col-md-6 align-self-center mb-30 trending-items col-md-6 adv">
                    <div class="item">
                        <div class="thumb">
                            <a href="product-details.php?id=<?=urlencode($product->product_id)?>"><img src="<?=$product->product_img?>" alt=""></a>
                            <?php if($product->new_price == null): ?>
                                <span class="price">$<?=$product->old_price?></span>
                            <?php else: ?>
                                <span class="price"><em>$<?=$product->old_price?></em>$<?=$product->new_price?></span>
                                <div class="discount">-<?=round((($product->old_price - $product->new_price) / $product->old_price) * 100)?>%</div>
                            <?php endif; ?>

                        </div>
                        <div class="down-content">
                            <span class="category"><?=$product->category_names?></span>
                            <h4><?=$product->product_name?></h4>
                            <a href="product-details.php?id=<?=$product->product_id?>"><i class="fa fa-shopping-bag"></i></a>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>

        </div>
    </div>
</div>
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php for ($page = 1; $page <= $total_pages; $page++): ?>
            <li class="page-item <?php if ($page == $current_page) echo 'active'; ?>">
                <a class="page-link" href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>
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