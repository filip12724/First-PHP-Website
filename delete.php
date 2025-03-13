<?php
session_start();
include_once ("Methods/functions.php");
include_once ("Methods/conn.php");
isAdmin();
if (isset($_GET['id'])) {
    $id=$_GET['id'];
    var_dump($id);
    global $conn;

    $query="DELETE FROM products_category WHERE product_id=:id";

    $x=$conn->prepare($query);

    $x->bindParam(":id",$id);

    $x->execute();

    $query="DELETE FROM products WHERE product_id=:id";

    $x=$conn->prepare($query);

    $x->bindParam(":id",$id);

    $x->execute();

    if($x){
        redirect("admin-panel.php");
    }else{
        redirect("404.php");
    }


} else {
    redirect("404.php");
    exit();
}
?>