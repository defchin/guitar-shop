<?php
require_once('database.php');

// check for a submission. this assumes that we're trying to add a new category.
if (isset($_POST["submit"])) {
    // set up the new category variable for use in the query.
    $addNewCategory = $_POST["newCategory"];
    // Escape all strings fom the new category name
    $addNewCategory = mysqli_real_escape_string($connection, $addNewCategory);
    // run query to add new category to the database.
    $addNewCategoryQuery = "INSERT INTO categories (categoryName) VALUES ('{$addNewCategory}')";
    $newCategoryResult = mysqli_query($connection, $addNewCategoryQuery);
}

// check for a form submission. if it submitted, check the database interaction. if nothing, skip.
if (isset($_POST["submit"])) {
    if ($newCategoryResult) {
        echo "Successfully added new category.";
    } else {
        echo "Failed to add new category." . mysqli_error($connection);
    }
}

// Get all categories
$qryGetCategories = "SELECT categoryName FROM categories";
$resultGetCategories = mysqli_query($connection, $qryGetCategories);
//test for query failure
if (!$resultGetCategories) {
    die("Database query failed.");
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
    <h1>Category List</h1>
    <table>
        <tr>
            <th>Name</th>
            <th>&nbsp;</th>
        </tr>
        
    <?php
        while($categoryInfo = mysqli_fetch_row($resultGetCategories)) {
            // output a row for each category
    ?>
        <tr><td><?php echo $categoryInfo[0]; ?></td><td></td></tr>
    <?php
        }
    ?>
    
    </table>

    <h2>Add Category</h2>
    
    <form action="category_list.php" method="post">
        <input type="text" name="newCategory" value="" />
        <input type="submit" name="submit" value="Submit" />
    </form>
    
    <br>
    <p><a href="index.php">List Products</a></p>

    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> My Guitar Shop, Inc.</p>
    </footer>
</body>
</html>