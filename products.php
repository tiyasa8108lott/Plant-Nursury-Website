<?php
require 'includes/conn.php';

// Initialize variables
$category_id = isset($_GET['category_id']) ? (int)$_GET['category_id'] : 0;
$search = isset($_GET['search']) ? trim($_GET['search']) : '';

// Fetch category details
$category = null;
if ($category_id > 0) {
    $category_query = "SELECT * FROM categories WHERE id = $category_id";
    $category_result = mysqli_query($conn, $category_query);
    if ($category_result && mysqli_num_rows($category_result) > 0) {
        $category = mysqli_fetch_assoc($category_result);
    }
}

// If no category is found, set an error message
if (!$category) {
    die("Category not found.");
}

// Fetch products based on category and optional search term
$product_query = "SELECT * FROM products WHERE category_id = $category_id";
if (!empty($search)) {
    $search_term = mysqli_real_escape_string($conn, $search);
    $product_query .= " AND name LIKE '%$search_term%'";
}
$product_result = mysqli_query($conn, $product_query);

// Check for database query issues
if (!$product_result) {
    die("Error fetching products: " . mysqli_error($conn));
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products in <?php echo htmlspecialchars($category['name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="css/product.css">
    <!-- Font Awesome for icons -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">
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

    <!-- Category Title -->
    <div class="container my-5">
        <h2 class="text-center mb-4">Products in <?php echo htmlspecialchars($category['name']); ?></h2>

        <!-- Search Form -->
        <form method="GET" class="mb-4">
            <input type="hidden" name="category_id" value="<?php echo $category_id; ?>">
            <div class="input-group">
                <input type="text" name="search" class="form-control" placeholder="Search products..." value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit" class="btn btn-primary">Search</button>
            </div>
        </form>

        <!-- Products -->
        <div class="row g-4">
            <?php if (mysqli_num_rows($product_result) > 0) { ?>
                <?php while ($product = mysqli_fetch_assoc($product_result)) { ?>
                    <div class="col-12 col-md-4 mb-4">
                        <div class="card">
                            <!-- Display product image -->
                            <?php if (!empty($product['image'])) {
                                $image_data = base64_encode($product['image']);
                                echo '<img src="data:image/jpeg;base64,' . $image_data . '" class="card-img-top" alt="' . htmlspecialchars($product['name']) . '">';
                            } else {
                                echo '<img src="images/default.jpg" class="card-img-top" alt="Default Image">';
                            } ?>
                            <div class="card-body">
                                <h5 class="card-title"><?php echo htmlspecialchars($product['name']); ?></h5>
                                <p class="card-text"><?php echo htmlspecialchars($product['description']); ?></p>
                                <p class="card-text text-success"><strong>$<?php echo number_format($product['price'], 2); ?></strong></p>
                                <a href="product_details.php?id=<?php echo $product['id']; ?>" class="btn btn-outline-primary">View Details</a>
                                <form action="add_to_cart.php" method="POST" class="mt-2">
                                    <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                    <button type="submit" class="btn btn-success">Add to Cart</button>
                                </form>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            <?php } else { ?>
                <p class="text-center text-danger">No products found matching your search.</p>
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
