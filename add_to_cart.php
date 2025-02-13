<?php
session_start();
require 'includes/conn.php';

// Check if the product ID and quantity are set
if (isset($_POST['product_id'])) {
    $product_id = $_POST['product_id'];
    
    // Initialize cart if not set
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }
    
    // Check if product already in cart, increase quantity
    if (isset($_SESSION['cart'][$product_id])) {
        $_SESSION['cart'][$product_id] += 1; // Increment the quantity
    } else {
        $_SESSION['cart'][$product_id] = 1; // Set initial quantity to 1
    }

    // Redirect back to the product page or cart
    header('Location: cart.php');
    exit();
}

?>
