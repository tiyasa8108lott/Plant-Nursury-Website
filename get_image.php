<?php
// Include your database connection file
require 'includes/conn.php';

// Check if 'id' is passed in the query string
if (isset($_GET['id'])) {
    $product_id = $_GET['id'];

    // Query to fetch the image for the product by its ID
    $query = "SELECT image FROM products WHERE id = $product_id";
    $result = mysqli_query($conn, $query);

    // If the image exists, output the image
    if ($result && mysqli_num_rows($result) > 0) {
        $product = mysqli_fetch_assoc($result);

        // Set the appropriate headers for image output
        header('Content-Type: image/jpeg'); // Or change depending on the image format
        
        // Output the image content (assuming the image is stored as BLOB)
        echo $product['image'];
    } else {
        // If no image found, output a default image
        header('Content-Type: image/jpeg');
        readfile('images/default.jpg');  // Path to your default image
    }
}
?>
