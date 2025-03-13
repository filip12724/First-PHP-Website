<?php
session_start();
include_once("Methods/functions.php");
include_once("Methods/conn.php");

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['address']) && !empty($_SESSION['cart'])) {
        $customerId = $_SESSION['user']->customer_id;
        $address = $_POST['address'];

        if (empty($_SESSION['cart'])) {
            header("Location: cart.php?error=Your cart is empty.");

        }

        foreach ($_SESSION['cart'] as $product) {
            $quantity = $product['quantity'];
            if (empty($quantity) || $quantity < 1 || $quantity > 100) {
                header("Location: cart.php?error=Error inserting your order");

            }
        }

        $orderId = insertOrder($address, $customerId);
        $allInserted = true;

        foreach ($_SESSION['cart'] as $product) {
            $productId = $product['product_id'];
            $quantity = $product['quantity'];

            $result = insertOrderDetails($productId, $quantity, $orderId);
            if (!$result) {
                $allInserted = false;
            }
        }

        if ($allInserted) {
            unset($_SESSION['cart']);
            header("Location: cart.php?message=Your order has been successfully received.");
            exit;
        } else {
            header("Location: cart.php?message=There was a problem receiving your order.");
            exit;
        }
    } else {
        header("Location: 404.php");
        exit;
    }
} else {
    header("Location: 404.php");
    exit;
}
?>
