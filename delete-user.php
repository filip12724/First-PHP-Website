<?php
if(isset($_GET['id'])) {
    include_once ("Methods/conn.php");
    include_once ("Methods/functions.php");
    global $conn;
    $customerId = $_GET['id'];

    $queryCheckOrders = "SELECT * FROM orders WHERE customer_id = :id";
    $stmtCheckOrders = $conn->prepare($queryCheckOrders);
    $stmtCheckOrders->bindParam(":id", $customerId);
    $stmtCheckOrders->execute();

    if($stmtCheckOrders->rowCount() > 0) {
        redirect("admin-panel.php?error=Customer has orders. Cannot delete.");
        exit();
    }
    $queryDeleteCustomer = "DELETE FROM customers WHERE customer_id = :id";
    $stmtDeleteCustomer = $conn->prepare($queryDeleteCustomer);
    $stmtDeleteCustomer->bindParam(":id", $customerId);
    $stmtDeleteCustomer->execute();


    redirect("admin-panel.php?success=Customer deleted successfully.");


} else {
    redirect("404.php");
}
?>
