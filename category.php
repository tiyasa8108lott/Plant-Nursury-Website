<?php
require 'includes/conn.php';

// Fetch all categories
$category_query = "SELECT * FROM categories";
$category_result = mysqli_query($conn, $category_query);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Plant Shop - Categories</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/category.css">
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
                        <a class="nav-link active" href="category.php">Categories</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="cart.php"><i class="fas fa-cart-plus"></i> Cart</a>
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

    <!-- Categories Section -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Shop by Category</h2>

        <div class="row g-4">
            <?php while ($category = mysqli_fetch_assoc($category_result)) { ?>
                <div class="col-lg-3 col-md-4 col-sm-6">
                    <div class="card shadow-sm border-0">
                        <!-- Category Image -->
                        <?php
                        if (!empty($category['image'])) {
                            $image_data = base64_encode($category['image']);
                            echo '<img src="data:image/jpeg;base64,' . $image_data . '" 
                                 class="card-img-top" 
                                 alt="' . htmlspecialchars($category['name']) . '">';
                        } else {
                            echo '<img src="images/default.jpg" class="card-img-top" alt="Default Image">';
                        }
                        ?>
                        <div class="card-body text-center">
                            <h5 class="card-title text-truncate"><?php echo htmlspecialchars($category['name']); ?></h5>
                            <a href="products.php?category_id=<?php echo $category['id']; ?>" class="btn btn-primary btn-sm">View Products</a>
                        </div>
                    </div>
                </div>
            <?php } ?>
        </div>
    </div>

    <!-- Footer -->
    <footer class="bg-dark text-white text-center py-4">
        <p>&copy; 2025 Green Scape | All Rights Reserved</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
