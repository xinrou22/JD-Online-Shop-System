<?php
include("../connect/config.php");

// Check if product id is provided and valid
if (isset($_GET['id']) && is_numeric($_GET['id'])) {
    $productId = $_GET['id'];

    // Construct SQL DELETE query
    $sql = "DELETE FROM products WHERE id = $productId";

    // Execute the query
    if (mysqli_query($conn, $sql)) {
        // Product deleted successfully
        echo "Product deleted successfully.";
        header("Location: product-list.php"); // Redirect to product list page
        exit();
    } else {
        // Error deleting product
        echo "Error: " . mysqli_error($conn);
    }
} else {
    // Redirect to product list page if product id is not provided or invalid
    header("Location: product-list.php");
    exit();
}
?>