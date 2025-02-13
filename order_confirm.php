<?php
session_start();
require 'includes/conn.php';

// Check if order_id is passed in the URL
if (isset($_GET['order_id'])) {
    $order_id = $_GET['order_id'];

    // Fetch order details from the database
    $order_query = "SELECT * FROM orders WHERE id = $order_id";
    $order_result = mysqli_query($conn, $order_query);
    $order = mysqli_fetch_assoc($order_result);

    // Fetch order items
    $order_items_query = "SELECT * FROM order_items WHERE order_id = $order_id";
    $order_items_result = mysqli_query($conn, $order_items_query);
    $order_items = mysqli_fetch_all($order_items_result, MYSQLI_ASSOC);
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Confirmation</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/order_confirm.css">

</head>
<body>
    <div class="container my-5">
        <h2 class="text-center mb-4">Order Confirmation</h2>

        <?php if ($order) { ?>
            <div class="alert alert-success">
                <h4>Thank you for your order!</h4>
                <p>Your order ID is: #<?php echo $order['id']; ?></p>
                <p>Status: <?php echo $order['status']; ?></p>
                <h5>Order Summary:</h5>
                <ul class="list-group">
                    <?php foreach ($order_items as $item) { ?>
                        <li class="list-group-item">
                            <?php echo htmlspecialchars($item['product_id']); ?> (x<?php echo $item['quantity']; ?>) - $<?php echo number_format($item['price'] * $item['quantity'], 2); ?>
                        </li>
                    <?php } ?>
                </ul>
                <h5>Total: $<?php echo number_format($order['total'], 2); ?></h5>
            </div>
        <?php } else { ?>
            <div class="alert alert-danger">
                <p>Order not found!</p>
            </div>
        <?php } ?>
    </div>
</body>
</html>
