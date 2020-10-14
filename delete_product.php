<?php
require_once('database.php');

// Get IDs
$product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);
$category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);

// Delete the product from the database
$deleteProductQuery = "DELETE FROM products WHERE productId = '{$product_id}'";
$deleteProductResult = mysqli_query($connection, $deleteProductQuery);

// Display the Product List page
if ($deleteProductResult) {
	header("Location: index.php");
	exit;
} else {
	header("Location: database_error.php");
	exit;
}