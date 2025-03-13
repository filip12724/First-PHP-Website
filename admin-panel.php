<?php
session_start();
include_once("Methods/functions.php");
include_once("Methods/conn.php");

isAdmin();
global $conn;

$results_per_page = 8;

$total_products_query = "SELECT COUNT(*) as total FROM products";
$total_products_result = $conn->query($total_products_query);
$total_products = $total_products_result->fetch(PDO::FETCH_ASSOC)['total'];

$total_pages = ceil($total_products / $results_per_page);

$current_page = isset($_GET['page']) ? $_GET['page'] : 1;

$starting_limit_number = ($current_page - 1) * $results_per_page;

$query = "SELECT * FROM products LIMIT $starting_limit_number, $results_per_page";
$products = $conn->query($query)->fetchAll();

$query2="SELECT * FROM customers c INNER JOIN roles r ON c.role_id=r.role_id";
$customers=$conn->query($query2)->fetchAll();


if(isset($_GET['success'])) {
    $successMessage = $_GET['success'];
} elseif(isset($_GET['error'])) {
    $errorMessage = $_GET['error'];
}
$query3="SELECT * FROM contact";
$messages=$conn->query($query3)->fetchAll();
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
<?php include_once ("header.php")?>
<!-- ***** Header Area End ***** -->

<div class="page-heading header-text">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>ADMIN PANEL</h3>
                <span class="breadcrumb"><a href="#">Home</a>  >  Admin Panel</span>
            </div>
        </div>
    </div>
</div>


<div class="centered-container">

    <div class="add-product-button">

        <button><a href="Methods/addProduct.php">Add Product</a></button>

    </div>

</div>

<table id="productTable" class="zebra">

    <thead>
    <tr>
        <th>Product ID</th>
        <th>Product Name</th>
        <th>Product Image</th>
        <th>Game ID</th>
        <th>Old Price</th>
        <th>New Price</th>
        <th>Is Trending</th>
        <th>Description</th>
        <th>Edit</th>
        <th>Delete</th>
    </tr>
    </thead>
    <tbody>
    <!-- Row 1 -->
    <?php foreach ($products as $product):  ?>
    <tr>

        <td><?=$product->product_id?></td>
        <td><?=$product->product_name?></td>
        <td><img src="<?=$product->product_img?>" alt="<?=$product->alt?>"></td>
        <td><?=$product->game_id?></td>
        <td>$<?=$product->old_price?></td>
        <td><?=$product->new_price == null ? "N/A" : "$" . $product->new_price?></td>
        <td><?=$product->isTrending ? "Yes" : "No" ?></td>
        <td><?=$product->description?></td>
        <td>
            <button><a href="edit.php?id=<?=$product->product_id?>">Edit</a></button>
        </td>
        <td>
            <button><a href="delete.php?id=<?=$product->product_id?>">Delete</a></button>
        </td>
    </tr>
    <?php  endforeach; ?>
    </tbody>
</table>
<nav aria-label="Page navigation">
    <ul class="pagination justify-content-center">
        <?php for ($page = 1; $page <= $total_pages; $page++): ?>
            <li class="page-item <?php if ($page == $current_page) echo 'active'; ?>">
                <a class="page-link" href="?page=<?php echo $page; ?>"><?php echo $page; ?></a>
            </li>
        <?php endfor; ?>
    </ul>
</nav>
<div class="centered-container">

    <div class="add-product-button">

        <h2>Customers</h2>

    </div>

</div>
<table id="customerTable" class="zebra">
    <thead>
    <tr>
        <th>Customer ID</th>
        <th>Name</th>
        <th>Last Name</th>
        <th>Email</th>
        <th>Phone Number</th>
        <th>Address</th>
        <th>Role</th>
        <th>Edit</th>
        <th>Delete</th>
        <!-- Add more columns as needed -->
    </tr>
    </thead>
    <tbody>
    <?php foreach ($customers as $customer): ?>
        <tr>
            <?php if($customer->role=="admin"){
                continue;
            } ?>
            <td><?= $customer->customer_id ?></td>
            <td><?= $customer->customer_fname ?></td>
            <td><?= $customer->customer_lname ?></td>
            <td><?= $customer->email ?></td>
            <td><?= $customer->phone ?></td>
            <td><?= $customer->street_address ?></td>
            <td><?= $customer->role ?></td>
            <td>
                <button><a href="edit-user.php?id=<?= $customer->customer_id ?>">Edit</a></button>
            </td>
            <td>
                <button><a href="delete-user.php?id=<?= $customer->customer_id ?>">Delete</a></button>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>
<div class="container">
    <div class="row">
        <div class="col-md-6 mx-auto">
            <?php if(isset($successMessage)): ?>
                <p class="alert alert-success w-50 mx-auto"><?= $successMessage ?></p>
            <?php endif; ?>

            <?php if(isset($errorMessage)): ?>
                <p class="alert alert-danger w-50 mx-auto"><?= $errorMessage ?></p>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="centered-container">

    <div class="add-product-button">

        <h2>Messages</h2>

    </div>

</div>

<table id="messageTable" class="zebra">
    <thead>
    <tr>
        <th>Message</th>
        <th>Subject</th>
        <th>First Name</th>
        <th>Last Name</th>
        <th>Email</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($messages as $message): ?>
        <tr>
            <td><?= $message->message?></td>
            <td><?= $message->subject?></td>
            <td><?= $message->fname_contact?></td>
            <td><?= $message->lname_contact?></td>
            <td><?= $message->email_contact?></td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>


<?php include_once ("footer.php")?>
<script src="vendor/jquery/jquery.min.js"></script>
<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="assets/js/isotope.min.js"></script>
<script src="assets/js/owl-carousel.js"></script>
<script src="assets/js/counter.js"></script>
<script src="assets/js/custom.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>

