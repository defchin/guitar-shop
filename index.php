<?php
require_once('database.php');

// Get category ID
if (!isset($category_id)) {
    $category_id = filter_input(INPUT_GET, 'category_id', 
            FILTER_VALIDATE_INT);
    if ($category_id == NULL || $category_id == FALSE) {
        $category_id = 1;
    }
}

// Get name for selected category
$qryGetCategoryName = "SELECT categoryName FROM categories WHERE categoryID = $category_id";
$resultGetCategoryName = mysqli_query($connection, $qryGetCategoryName);
//test for query failure
if (!$resultGetCategoryName) {
    die("Database query failed.");
}

$category_name = mysqli_fetch_assoc($resultGetCategoryName)['categoryName'];

if (!isset($category_name)) {
    $category_name = "Guitars";
}

// Get all categories
$qryGetAllCategories = "SELECT * FROM categories";
$resultGetAllCategories = mysqli_query($connection, $qryGetAllCategories);
//test for query failure
if (!$resultGetAllCategories) {
    die("Database query failed.");
}

// create the associative array from the results
$categories = array();
while ($row = mysqli_fetch_assoc($resultGetAllCategories)) {
    $categories[$row["categoryID"]] = $row;
}

// Get products for selected category
$qryGetProducts = "SELECT * FROM products WHERE categoryID = $category_id";

$resultGetProducts = mysqli_query($connection, $qryGetProducts);
//test for query failure
if (!$resultGetProducts) {
    die("Database query failed.");
}

// create the associative array from the results
$products = array();
while ($row = mysqli_fetch_assoc($resultGetProducts)) {
    $products[$row["productID"]] = $row;
}

?>
<!DOCTYPE html>
<html>

<!-- the head section -->
<head>
    <title>My Guitar Shop</title>
    <link rel="stylesheet" type="text/css" href="main.css" />
</head>

<!-- the body section -->
<body>
<header><h1>Product Manager</h1></header>
<main>
    <h1>Product List</h1>

    <aside>
        <!-- display a list of categories -->
        <h2>Categories</h2>
        <nav>
        <ul>
            <?php foreach ($categories as $category) : ?>
            <li><a href=".?category_id=<?php echo $category['categoryID']; ?>">
                    <?php echo $category['categoryName']; ?>
                </a>
            </li>
            <?php endforeach; ?>
        </ul>
        </nav>          
    </aside>

    <section>
        <!-- display a table of products -->
        <h2><?php echo $category_name; ?></h2>
        <table>
            <tr>
                <th>Code</th>
                <th>Name</th>
                <th class="right">Price</th>
                <th>&nbsp;</th>
            </tr>

            <?php foreach ($products as $product) : ?>
            <tr>
                <td><?php echo $product['productCode']; ?></td>
                <td><?php echo $product['productName']; ?></td>
                <td class="right"><?php echo $product['listPrice']; ?></td>
                <td>
                    <form action="edit_product_form.php" method="post">
                        <input type="hidden" name="product_id"
                               value="<?php echo $product['productID']; ?>">
                        <input type="hidden" name="category_id"
                               value="<?php echo $product['categoryID']; ?>">
                        <input type="hidden" name="product_code"
                               value="<?php echo $product['productCode']; ?>">
                        <input type="hidden" name="product_name"
                               value="<?php echo $product['productName']; ?>">
                        <input type="hidden" name="list_price"
                               value="<?php echo $product['listPrice']; ?>">
                        <input type="hidden" name="mode"
                               value="edit">
                        <input type="submit" value="Edit">
                    </form>
                </td>

                <td><form action="delete_product.php" method="post">
                    <input type="hidden" name="product_id"
                           value="<?php echo $product['productID']; ?>">
                    <input type="hidden" name="category_id"
                           value="<?php echo $product['categoryID']; ?>">
                    <input type="submit" value="Delete">
                </form></td>
            </tr>
            <?php endforeach; ?>
        </table>
        <p><a href="add_product_form.php">Add Product</a></p>
        <p><a href="category_list.php">List Categories</a></p>        
    </section>
</main>
<footer>
    <p>&copy; <?php echo date("Y"); ?> My Guitar Shop, Inc.</p>
</footer>
</body>
</html>