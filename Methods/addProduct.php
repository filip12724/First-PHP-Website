<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

session_start();
include_once("functions.php");
include_once("conn.php");
isAdmin();
global $conn;
$error = [];
try{
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        if(isset($_POST['isTrending'])){
            $isTrending=$_POST['isTrending'];
        }
        else{
            $isTrending=null;
            $error[]="Please select the trending state";
        }
        extract($_POST);
        if ($dropdown1 != 0 && $dropdown2 != 0) {
            if($isTrending==1 || $isTrending ==0 ){

                $productNameRegex="/^[A-Za-z0-9\s\-&',.()]{3,35}$/";
                $imageRegex="/^assets\/images\/[A-Za-z0-9_-]{1,95}\.(jpg|jpeg|png|gif)$/";
                $priceRegex="/^(?:100|\d{1,2})$/";
                $newPriceRegex="/^(100|\b[1-9][0-9]?\b|null)$/";
                $textAreaRegex="/^.{0,255}$/";





                if($newPrice=="" || $newPrice==0){
                    $newPrice=null;
                }

                $isValid = array(
                    'productName' => checkRegex($productNameRegex, $productName),
                    'image' => checkRegex($imageRegex, $productImage),
                    'alt' => checkRegex($productNameRegex, $alt),
                    'gameId'=>checkRegex($productNameRegex,$gameId),
                    'oldPrice' => checkRegex($priceRegex, $oldPrice),
                    'newPrice' => checkRegex($newPriceRegex, $newPrice),
                    'description' => checkRegex($textAreaRegex, $description)
                );
                if($newPrice==null){
                    $isValid['newPrice']=true;
                }
                $isAllTrue=true;

                foreach ($isValid as $key=>$value){
                    if(!$value){
                        $isAllTrue=false;
                        $error[]="Invalid $key field";
                    }
                }
                if($isAllTrue){



                    $isTrending = ($_POST['isTrending'] == '1') ? 1 : 0;


                    $query = "INSERT INTO products (product_name, product_img, alt, game_id, old_price, new_price, isTrending, description) VALUES (:name, :img, :alt, :gameId, :old, :new, :trend, :desc)";


                    $x=$conn->prepare($query);

                    $x->bindParam(":name", $productName);
                    $x->bindParam(":img", $productImage);
                    $x->bindParam(":alt", $alt);
                    $x->bindParam(":gameId", $gameId);
                    $x->bindParam(":old", $oldPrice);
                    $x->bindParam(":new", $newPrice);
                    $x->bindParam(":trend", $isTrending, PDO::PARAM_INT);
                    $x->bindParam(":desc", $description);



                    $x->execute();

                    $productId=$conn->lastInsertId();


                    $categories = [$dropdown1, $dropdown2];
                    if ($dropdown3 != 0) {
                        $categories[] = $dropdown3;
                    }

                    foreach ($categories as $categoryId) {
                        $query2 = "INSERT INTO products_category (product_id, category_id) VALUES (:pid, :cid)";
                        $y = $conn->prepare($query2);
                        $y->bindParam(":pid", $productId);
                        $y->bindParam(":cid", $categoryId);
                        $y->execute();

                    }
                }

            }else{
                $error[]="Please select the trending state";

            }



        } else {

            $error[]="Please select at least two categories.";
        }
    }
    $query="SELECT * FROM category";
    $categories=$conn->query($query)->fetchAll();


}catch (Exception $e) {
    echo json_encode(['success' => false, 'message' => 'An error occurred: ' . $e->getMessage()]);
}



?>

<!DOCTYPE html>
<html lang="en">
<head>
    <link href="../assets/css/style.css" type="text/css" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@100;200;300;400;500;600;700;800;900&display=swap" rel="stylesheet">

    <title>Lugx Gaming Shop HTML5 Template</title>

    <!-- Bootstrap core CSS -->
    <link href="../vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">


    <!-- Additional CSS Files -->
    <link rel="stylesheet" href="../assets/css/fontawesome.css">
    <link rel="stylesheet" href="../assets/css/templatemo-lugx-gaming.css">
    <link rel="stylesheet" href="../assets/css/owl.css">
    <link rel="stylesheet" href="../assets/css/animate.css">
    <link rel="stylesheet"href="../https://unpkg.com/swiper@7/swiper-bundle.min.css"/>

    <script src="../https://ajax.googleapis.com/ajax/libs/jquery/3.6.0/jquery.min.js"></script>
    <link rel="stylesheet" href="../assets/css/admin.css" type="text/css">
</head>
<body>
<!-- ***** Preloader Start ***** -->

<!-- ***** Header Area End ***** -->

<div class="page-heading header-text">
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <h3>ADD PRODUCT</h3>
                <span class="breadcrumb"><a href="../admin-panel.php">Admin Panel</a>  > Add product</span>
            </div>
        </div>
    </div>
</div>



<div class="edit-product-container">
    <form action="<?=$_SERVER["PHP_SELF"]?>" method="POST">
        <input type="hidden" name="productId" >
        <label for="productName" class="input-label">Product Name:</label>
        <input type="text" id="productName" name="productName" class="input-field">

        <label for="productImage" class="input-label">Product Image:</label>
        <input type="text" id="productImage" name="productImage" class="input-field" value="assets/images/">

        <label for="alt" class="input-label">Alt for Image:</label>
        <input type="text" id="alt" name="alt" class="input-field" >

        <label for="gameId" class="input-label">Game ID:</label>
        <input type="text" id="gameId" name="gameId" class="input-field">

        <label for="oldPrice" class="input-label">Old Price:</label>
        <input type="text" id="oldPrice" name="oldPrice" class="input-field" >

        <label for="newPrice" class="input-label">New Price:</label>
        <input type="text" id="newPrice" name="newPrice" class="input-field" >

        <label for="Yes" class="input-label">Is Trending</label>

        <div class="radio-container">
            <label for="Yes" class="radio-label">Yes</label>
            <input type="radio" id="Yes" name="isTrending" class="input-field radio" value="1">

            <label for="No" class="radio-label">No</label>
            <input type="radio" id="No" name="isTrending" class="input-field radio" value="0" >
        </div>


        <label for="description" class="input-label">Description:</label>
        <textarea id="description" name="description" class="input-field" rows="4"></textarea>


        <label for="dropdown1" class="input-label">Dropdown 1: (Mandatory)</label>
        <select id="dropdown1" name="dropdown1" class="input-field">
            <option value="0">Choose...</option>
            <?php foreach ($categories as $category): ?>

                <option value="<?=$category->category_id?>"><?=$category->category_name?></option>

            <?php endforeach; ?>
        </select>

        <label for="dropdown2" class="input-label">Dropdown 2: (Mandatory)</label>
        <select id="dropdown2" name="dropdown2" class="input-field">
            <option value="0">Choose...</option>
            <?php foreach ($categories as $category): ?>

                <option value="<?=$category->category_id?>"><?=$category->category_name?></option>

            <?php endforeach; ?>
        </select>

        <label for="dropdown3" class="input-label">Category 3: (optional)</label>
        <select id="dropdown3" name="dropdown3" class="input-field">
            <option value="0">Choose...</option>
            <?php foreach ($categories as $category): ?>

                <option value="<?=$category->category_id?>"><?=$category->category_name?></option>

            <?php endforeach; ?>
        </select>
        <!-- End of Dropdown Lists -->
        <?php if(!empty($error)): ?>
            <?php foreach ($error as $er): ?>
                <p class="alert alert-danger"><?=$er?></p>
            <?php endforeach; ?>
        <?php endif; ?>
        <div class="button-container">
            <button id="add">Add product</button>
        </div>
    </form>
</div>




<?php include_once("../footer.php") ?>


<script src="../vendor/jquery/jquery.min.js"></script>
<script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
<script src="../assets/js/isotope.min.js"></script>
<script src="../assets/js/owl-carousel.js"></script>
<script src="../assets/js/counter.js"></script>
<script src="../assets/js/custom.js"></script>
<script src="../assets/js/main.js"></script>

</body>
</html>

