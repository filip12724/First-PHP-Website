<?php
session_start();
include_once ("Methods/functions.php");
include_once ("Methods/conn.php");
global $conn;
isAdmin();
if (isset($_GET['type']) && $_GET['type'] === 'product') {

    extract($_POST);




  if($newPrice==""){
      $newPrice=null;
  }
 $isTrending2=intval($isTrending);
  if($isTrending2==1){
      $isTrending=true;
  }else{
      $isTrending=false;
  }
    $query="UPDATE products SET product_name=:name,
                    product_img=:img,alt=:alt,game_id=:gameId,old_price=:oldPrice,
                    new_price=:newPrice,isTrending=:trend,description=:desc
             WHERE product_id=:id";
    $x=$conn->prepare($query);

    $x->bindParam(":name", $productName);
    $x->bindParam(":img", $productImage);
    $x->bindParam(":alt", $alt);
    $x->bindParam(":gameId", $gameId);
    $x->bindParam(":oldPrice", $oldPrice);
    $x->bindParam(":newPrice", $newPrice);
    $x->bindParam(":trend", $isTrending);
    $x->bindParam(":desc", $description);
    $x->bindParam(":id", $productId);

    $x->execute();

    if($x){
        redirect("admin-panel.php");
    }else{
        redirect("404.php");
    }


}elseif (isset($_GET['type']) && $_GET['type'] === 'customer') {
    extract($_POST);
            $query = "UPDATE customers SET customer_fname=:fname,customer_lname =:lname,email=:email,phone=:phone,street_address=:address
                    WHERE customer_id=:id";
            $stmt = $conn->prepare($query);
            $stmt->bindParam(":fname", $customerName);
            $stmt->bindParam(":lname", $customerLname);
            $stmt->bindParam(":email", $email);
            $stmt->bindParam(":phone", $phone);
            $stmt->bindParam(":address", $address);
            $stmt->bindParam(":id", $customerId);

             $stmt->execute();

             redirect("admin-panel.php");



}else {
    redirect("404.php");
    exit();
}
?>