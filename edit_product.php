<?php
// Get the product data
$category_id = filter_input(INPUT_POST, 'category_id', FILTER_VALIDATE_INT);
$code = filter_input(INPUT_POST, 'code');
$name = filter_input(INPUT_POST, 'name');
$price = filter_input(INPUT_POST, 'price', FILTER_VALIDATE_FLOAT);
$product_id = filter_input(INPUT_POST, 'product_id', FILTER_VALIDATE_INT);

// Validate inputs
if ($category_id == null || $category_id == false ||
	$code == null || $name == null || $price == null || $price == false || $product_id == null || $product_id == false ) {
	$error = "Invalid product data. Check all fields and try again.";
	include('error.php');
} else {
	require_once('database.php');

	// Add the product to the database
	$editProductQuery = "UPDATE products SET categoryID = $category_id, productCode = '{$code}', productName = '{$name}', listPrice = $price WHERE productID = $product_id";
	$editProductResult = mysqli_query($connection, $editProductQuery);


	// Display the Product List page
	if ($editProductResult) {
		header("Location: index.php");
		exit;
	} else {
		header("Location: database_error.php");
		exit;
	}
}
?>