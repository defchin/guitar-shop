<?php
require('database.php');
//Get Categories from the Database
$qryGetAllCategories = "SELECT * FROM categories";
$resultGetAllCategories = mysqli_query($connection, $qryGetAllCategories);
//test for query failure
if (!$resultGetAllCategories) {
    die("Database query failed.");
}

// create the associative array from the results.
$categories = array();
while ($row = mysqli_fetch_assoc($resultGetAllCategories)) {
    $categories[$row["categoryID"]] = $row;
}

?>
<!DOCTYPE html>
<html>

<!-- the head section -->
<head>
    <title>My Guitar Shop</title>
    <link rel="stylesheet" type="text/css" href="main.css">
</head>

<!-- the body section -->
<body>
    <header><h1>Product Manager</h1></header>

    <main>
        <h1>Edit Product</h1>
            <form action="edit_product.php" method="post" id="edit_product_form">
                <label>Category:</label>
                <select name="category_id">
                    <?php foreach ($categories as $category) : ?>
                        <option name = "category_id" value="<?php echo $category['categoryID']; ?>"
                            <?php if ($_POST["category_id"] == $category['categoryID']) {
                                echo "selected";
                                }
                            ?>>
                            <?php echo $category['categoryName']; ?>
                        </option>
                    <?php endforeach; ?>
                </select><br>

                <label>Code:</label>
                <input type="text" name="code" value="<?php echo $_POST["product_code"]?>"><br>

                <label>Name:</label>
                <input type="text" name="name" value="<?php echo $_POST["product_name"]?>"><br>

                <label>List Price:</label>
                <input type="text" name="price" value="<?php echo $_POST["list_price"]?>"><br>

                <label>&nbsp;</label>
                <input type="submit" value="Edit Product"><br>
                <input type="hidden" name="product_id" value="<?php echo $_POST["product_id"]?>">
            </form>
        <p><a href="index.php">View Product List</a></p>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> My Guitar Shop, Inc.</p>
    </footer>
</body>
</html>