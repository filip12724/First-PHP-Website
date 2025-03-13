<?php
session_start();

if(isset($_GET['index'])) {
    $index = $_GET['index'];

    // Check if the index exists in the cart
    if(isset($_SESSION['cart'][$index])) {
        // Remove the product from the cart array using the provided index
        unset($_SESSION['cart'][$index]);

        // Send a success response
        $response = array('status' => 'success', 'message' => 'Product removed successfully');
        echo json_encode($response);
    } else {
        // If the product is not found in the cart
        $response = array('status' => 'error', 'message' => 'Product not found in cart');
        echo json_encode($response);
    }
} else {
    // If the index parameter is missing
    $response = array('status' => 'error', 'message' => 'Index parameter is missing');
    echo json_encode($response);
}
?>
