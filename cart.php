<?php
session_start();
require 'includes/conn.php';

// Initialize the cart if it's not set yet
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}

// Update cart logic if update request is received
if (isset($_POST['update_cart'])) {
    foreach ($_POST['quantity'] as $product_id => $quantity) {
        if ($quantity <= 0) {
            unset($_SESSION['cart'][$product_id]);
        } else {
            $_SESSION['cart'][$product_id] = $quantity;
        }
    }
    header('Location: cart.php');
    exit();
}

// Fetch cart product details
$cart_items = [];
if (!empty($_SESSION['cart'])) {
    $product_ids = implode(',', array_keys($_SESSION['cart']));
    $product_query = "SELECT * FROM products WHERE id IN ($product_ids)";
    $product_result = mysqli_query($conn, $product_query);
    
    while ($product = mysqli_fetch_assoc($product_result)) {
        $product['quantity'] = $_SESSION['cart'][$product['id']];
        $cart_items[] = $product;
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Cart</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
</head>
<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
        <div class="container">
            <a class="navbar-brand" href="index.php">
                <img src="https://img.freepik.com/free-vector/line-tree-logo-template-branding-with-text_53876-117526.jpg" 
                     alt="Plant Shop Logo" 
                     class="img-fluid" 
                     style="max-width: 50px; margin-right: 10px;">
                <span class="fs-4 fw-bold text-dark">Green Scape</span>
            </a>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="index.php">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="category.php">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link active" href="cart.php"><i class="fas fa-cart-plus"></i> Cart</a>
                    </li>
                    <?php
                    if (isset($_SESSION['email'])) {
                        echo '<li class="nav-item"><a class="nav-link" href="logout.php">Logout</a></li>';
                    } else {
                        echo '<li class="nav-item"><a class="nav-link" href="login.php">Login</a></li>';
                    }
                    ?>
                </ul>
            </div>
        </div>
    </nav>

    <!-- Cart Section -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Your Cart</h2>

        <?php if (empty($cart_items)) { ?>
            <p class="text-center">Your cart is empty.</p>
        <?php } else { ?>
            <form action="cart.php" method="POST">
                <div class="row">
                    <?php foreach ($cart_items as $item) { ?>
                        <div class="col-12 mb-4">
                            <div class="card shadow-sm">
                                <div class="row g-0">
                                    <div class="col-md-3">
                                        <!-- Product Image -->
                                        <?php if (!empty($item['image'])) {
                                            $image_data = base64_encode($item['image']);
                                            echo '<img src="data:image/jpeg;base64,' . $image_data . '" class="img-fluid rounded-start" alt="' . htmlspecialchars($item['name']) . '">';
                                        } else {
                                            echo '<img src="images/default.jpg" class="img-fluid rounded-start" alt="Default Image">';
                                        } ?>
                                    </div>
                                    <div class="col-md-9">
                                        <div class="card-body">
                                            <h5 class="card-title"><?php echo htmlspecialchars($item['name']); ?></h5>
                                            <p class="card-text"><?php echo htmlspecialchars($item['description']); ?></p>
                                            <p class="card-text text-success"><strong>$<?php echo number_format($item['price'], 2); ?></strong></p>

                                            <!-- Quantity Input -->
                                            <div class="mb-3">
                                                <label for="quantity_<?php echo $item['id']; ?>" class="form-label">Quantity</label>
                                                <input type="number" name="quantity[<?php echo $item['id']; ?>]" id="quantity_<?php echo $item['id']; ?>" class="form-control" value="<?php echo $item['quantity']; ?>" min="1">
                                            </div>
                                            
                                            <!-- Total Price -->
                                            <p class="card-text"><strong>Total: $<?php echo number_format($item['price'] * $item['quantity'], 2); ?></strong></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>

                <!-- Update Cart Button -->
               
            </form>
            
            <div class="text-center my-4">
                <a href="checkout.php" class="btn btn-success">Proceed to Checkout</a>
            </div>
        <?php } ?>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4">
        <p>&copy; 2025 Green Scape | All Rights Reserved</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
