<?php require 'includes/conn.php'; ?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Shop - Your Online Nursery</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/style.css">
    <!-- Font Awesome CSS (corrected version) -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
</head>

<body>
    
                    
<nav class="navbar navbar-expand-lg navbar-light bg-light shadow-sm">
    <div class="container">
        <a class="navbar-brand" href="index.php">
            <!-- Logo Image -->
            <img src="https://img.freepik.com/free-vector/line-tree-logo-template-branding-with-text_53876-117526.jpg?t=st=1737553725~exp=1737557325~hmac=c220ea6fe2d7223e14e03d9f89313dddeda657258a0ca08a8f4795cddfb30c2e&w=740" alt="Plant Shop Logo" class="img-fluid" style="max-width: 50px; margin-right: 10px;">
        </a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ms-auto"> <!-- ms-auto added to push items to the right -->
                <li class="nav-item">
                    <a class="nav-link active" href="index.php">Home</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="category.php">Products</a>
                </li>
                <li class="nav-item">
                    <a class="nav-link" href="contact.php">Contact</a>
                </li>
                
                <?php
                if (isset($_SESSION['email'])) {
                    echo '<li class="nav-item">
                            <a class="nav-link" href="logout.php">Logout</a>
                          </li>';
                } else {
                    echo '<li class="nav-item ms-auto"> <!-- ms-auto added here to move login to the right -->
                            <a class="nav-link" href="login.php"><i class="fas fa-user"></i> </a>
                          </li>';
                }
                ?>
            </ul>
        </div>
    </div>
</nav>

    <!-- Hero Section -->
    <section class="hero bg-primary text-white text-center py-5">
        <div class="container">
            <h1 class="display-4 fw-bold animate__animated animate__fadeIn animate__delay-1s">Welcome to Our Online Nursery</h1>
            <p class="lead animate__animated animate__fadeIn animate__delay-1s">Your one-stop shop for all types of plants!</p>
            <a href="category.php" class="btn btn-warning btn-lg animate__animated animate__fadeIn animate__delay-2s">Shop Now</a>
        </div>
    </section>

    <!-- Featured Products Section -->
    <section class="container my-5">
    <h2 class="text-center mb-4">Featured Plants</h2>
    <div class="row g-4">
        <?php
        // Query to get the products (limited to 4 for featured)
        $query = "SELECT * FROM products LIMIT 4";
        $result = mysqli_query($conn, $query);

        // Check if there are any products in the result
        if ($result && mysqli_num_rows($result) > 0) {
            // Loop through each product
            while ($product = mysqli_fetch_assoc($result)) {
                // Generate the image source URL by calling the get_image.php script
                $imageSrc = 'get_image.php?id=' . $product['id']; // Fetch image through get_image.php

                // Output the product card with its details
                echo '
                <div class="col-md-3 col-sm-6">
                    <div class="card shadow-lg border-light rounded-3">
                        <img src="' . $imageSrc . '" class="card-img-top" alt="' . htmlspecialchars($product['name']) . '">
                        <div class="card-body text-center">
                            <h5 class="card-title">' . htmlspecialchars($product['name']) . '</h5>
                            <p class="card-text">$' . number_format($product['price'], 2) . '</p>
                            <a href="products.php?id=' . $product['id'] . '" class="btn btn-outline-primary">View Details</a>
                        </div>
                    </div>
                </div>';
            }
        } else {
            // If no products available, display a message
            echo '<p>No featured products available.</p>';
        }
        ?>
    </div>
</section>


    <!-- Customer Reviews Section -->
    <section class="container my-5">
        <h2 class="text-center mb-4">What Our Customers Are Saying</h2>
        <div class="row">
            <div class="col-md-4">
                <div class="card border-light">
                    <div class="card-body">
                        <p class="card-text">"I love this nursery! The plants I ordered arrived healthy and thriving. Highly recommend!"</p>
                        <footer class="blockquote-footer">John Doe, <cite title="Source Title">Verified Buyer</cite></footer>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-light">
                    <div class="card-body">
                        <p class="card-text">"Great selection of plants. I found everything I needed and more. Will definitely shop here again."</p>
                        <footer class="blockquote-footer">Jane Smith, <cite title="Source Title">Verified Buyer</cite></footer>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="card border-light">
                    <div class="card-body">
                        <p class="card-text">"Excellent customer service and fast delivery. My plants are flourishing!"</p>
                        <footer class="blockquote-footer">Emily Johnson, <cite title="Source Title">Verified Buyer</cite></footer>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer Section -->
    <footer class="bg-dark text-white text-center py-4">
        <p>&copy; 2025 Plant Shop | All Rights Reserved</p>
    </footer>

    <!-- Bootstrap and JS Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css"></script>
</body>
</html>
