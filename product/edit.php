<?php if (!empty($_POST)) : ?>
    <?php
    include '../db_extension.php';
    $id = htmlspecialchars($_POST["id"]);
    $productname = htmlspecialchars($_POST["productname"]);
    $price = htmlspecialchars($_POST["price"]);
    $description = htmlspecialchars($_POST["description"]);
    $imageurl = htmlspecialchars($_POST["imageurl"]);

    $result = updateProduct($id, $productname, $price, $description, $imageurl);

    if ($result) {
        header("location: list.php");
    } else $resultError = true;
    ?>

<?php else : ?>
    <?php
    session_start();
    if ($_SESSION['usertype'] != "Admin") {
        header("Location: ../login.php");
    }
    include '../db_extension.php';
    $product = getProduct(htmlspecialchars($_GET["productId"]));
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Page</title>
    </head>

    <body>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input type="text" name="id"  required hidden value="<?php echo $product["ProductID"]; ?>" />
            Product Name: <input type="text" required name="productname" value="<?php echo $product["ProductName"]; ?>" /> <br>
            Price: <input type="text" required name="price" value="<?php echo $product["Price"]; ?>" /> <br>
            Description: <input type="text" required name="description" value="<?php echo $product["Description"]; ?>" /> <br>
            Image URL: <input type="text" required name="imageurl" value="<?php echo $product["ImageURL"]; ?>" /> <br>
            <input type="submit">
            <?php echo !empty($resultError) ? "error occured" : "" ?>
        </form>
        <?php if ($_SESSION['token']) : ?>
            <a href="../logout.php">Logout</a>
        <?php endif; ?>
    </body>

    </html>
<?php endif ?>