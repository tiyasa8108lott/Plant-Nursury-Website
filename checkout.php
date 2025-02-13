<?php
session_start();
require 'includes/conn.php';

// Ensure the user is logged in and user_id exists in the session
if (!isset($_SESSION['user_id'])) {
    // Redirect to the login page if the user is not logged in
    header('Location: login.php');
    exit();
}

// Initialize cart items
$cart_items = [];
$total_amount = 0;

// Fetch cart product details
if (!empty($_SESSION['cart'])) {
    $product_ids = implode(',', array_keys($_SESSION['cart']));
    $product_query = "SELECT * FROM products WHERE id IN ($product_ids)";
    $product_result = mysqli_query($conn, $product_query);

    while ($product = mysqli_fetch_assoc($product_result)) {
        $product['quantity'] = $_SESSION['cart'][$product['id']];
        $cart_items[] = $product;
        $total_amount += $product['price'] * $product['quantity'];
    }
}

// Handle the form submission for checkout
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    // Get the user ID from the session
    $user_id = $_SESSION['user_id']; // This will work if the user is logged in

    // Get shipping details
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $address = mysqli_real_escape_string($conn, $_POST['address']);
    $payment_method = mysqli_real_escape_string($conn, $_POST['payment_method']);

    // Insert order into `orders` table
    $order_query = "INSERT INTO orders (user_id, total, status) VALUES ($user_id, $total_amount, 'Pending')";
    if (mysqli_query($conn, $order_query)) {
        // Get the last inserted order ID
        $order_id = mysqli_insert_id($conn);

        // Insert items into `order_items` table
        foreach ($cart_items as $item) {
            $product_id = $item['id'];
            $quantity = $item['quantity'];
            $price = $item['price'];
            $order_item_query = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                                 VALUES ($order_id, $product_id, $quantity, $price)";
            mysqli_query($conn, $order_item_query);
        }

        // Clear the cart after successful order
        $_SESSION['cart'] = [];

        // Redirect to order confirmation page with order_id
        header("Location: order_confirm.php?order_id=" . $order_id);
        exit();
    } else {
        echo "<div class='alert alert-danger'>Error placing the order: " . mysqli_error($conn) . "</div>";
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Checkout Section -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Checkout</h2>
        <div class="row">
            <!-- Cart Summary -->
            <div class="col-md-6">
                <h4 class="mb-3">Order Summary</h4>
                <ul class="list-group mb-4">
                    <?php foreach ($cart_items as $item) { ?>
                        <li class="list-group-item">
                            <div class="d-flex justify-content-between">
                                <span><?php echo htmlspecialchars($item['name']); ?> (x<?php echo $item['quantity']; ?>)</span>
                                <span>$<?php echo number_format($item['price'] * $item['quantity'], 2); ?></span>
                            </div>
                        </li>
                    <?php } ?>
                </ul>
                <h5>Total: $<?php echo number_format($total_amount, 2); ?></h5>
            </div>

            <!-- Shipping Information Form -->
            <div class="col-md-6">
                <h4 class="mb-3">Shipping Information</h4>
                <form method="POST">
                    <div class="mb-3">
                        <label for="name" class="form-label">Full Name</label>
                        <input type="text" class="form-control" id="name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="address" class="form-label">Shipping Address</label>
                        <textarea class="form-control" id="address" name="address" rows="3" required></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="payment_method" class="form-label">Payment Method</label>
                        <select class="form-control" id="payment_method" name="payment_method" required>
                            <option value="credit_card">Credit Card</option>
                            <option value="paypal">PayPal</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-success">Place Order</button>
                </form>
            </div>
        </div>
    </div>
</body>
</html>
