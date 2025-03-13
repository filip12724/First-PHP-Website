<?php

function isPost(){
    if($_SERVER["REQUEST_METHOD"]=="POST"){
        return true;
    }
    else{
        return false;
    }
}
function isGet(){
    if($_SERVER["REQUEST_METHOD"]=="GET"){
        return true;
    }
    else{
        return false;
    }
}

function checkRegex($regex,$stringToCheck){

    return preg_match($regex, $stringToCheck);

}

function insertCustomer($fname,$lname,$email,$phone,$address,$md5Passwd,$roleId){


    $query='INSERT INTO customers (customer_fname,customer_lname,email,phone,street_address,password,role_id)
                            VALUES(:fname,:lname,:email,:phone,:address,:passwd,:role)';
    global $conn;
    $prepare=$conn->prepare($query);

    $prepare->bindParam(":fname",$fname);
    $prepare->bindParam(":lname",$lname);
    $prepare->bindParam(":email",$email);
    $prepare->bindParam(":phone",$phone);
    $prepare->bindParam(":address",$address);
    $prepare->bindParam(":passwd",$md5Passwd);
    $prepare->bindParam(":role",$roleId);

    $result=$prepare->execute();

    return $result;
}

function checkLogin($email,$passwd){

    global $conn;

    $query="SELECT * FROM customers c JOIN roles r ON c.role_id=r.role_id
                          WHERE c.email=:email AND c.password=:passwd";

    $prepare=$conn->prepare($query);

    $prepare->bindParam(":email",$email);
    $prepare->bindParam(":passwd",$passwd);

    $prepare->execute();

    $result=$prepare->fetch();

    return $result;

}

function isProductId(){
    global $conn;

    $query = "SELECT product_id FROM products";

    try {
        $stmt = $conn->query($query);
        $productIds = $stmt->fetchAll();
        return $productIds;
    } catch (PDOException $exception) {
        echo "Error: " . $exception->getMessage();
        return false;
    }
}
function insertOrder($address,$customerId){
    global $conn;
    try{
        $query="INSERT INTO orders (order_address,customer_id) VALUES (:address,:customerID)";

        $x=$conn->prepare($query);
        $x->bindParam(":address",$address);
        $x->bindParam(":customerID",$customerId);

        $x->execute();

        $lastInsertedId = $conn->lastInsertId();

        return $lastInsertedId;


    }
    catch (PDOException $exception){
        echo "Error: " . $exception->getMessage();
    }
}

function insertOrderDetails($productId,$quantity,$orderId){
    global $conn;

    $query="INSERT INTO orders_products (order_id,product_id,quantity) VALUES (:orderID,:productID,:quantity)";

    $x=$conn->prepare($query);
    $x->bindParam(":orderID",$orderId);
    $x->bindParam(":productID",$productId);
    $x->bindParam(":quantity",$quantity);

    $result=$x->execute();

    return $result;
}
function isAdmin(){
    if (isset($_SESSION['user'])) {
        $role = $_SESSION['user']->role;

        if ($role !== 'admin') {
            header("Location: 404.php");
            exit();
        }
    } else {
        header("Location: 404.php");
        exit();
    }
}

function redirect($url){
    header("Location: $url");
}