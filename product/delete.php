<?php if (!empty($_POST)) : ?>
    <?php
    include '../db_extension.php';
    $id = htmlspecialchars($_POST["id"]);

    $result = deleteProduct($id);
    if ($result) {
        header("Location: list.php");
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
        Do you confirm to delete following entry?
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            <input name="id" hidden value="<?php echo $product["ProductID"]; ?>" />
            ProductName: <?php echo $product["ProductName"]; ?> <br>
            Price: <?php echo $product["Price"]; ?> <br>
            Description: <?php echo $product["Description"]; ?> <br>
            ImageURL: <?php echo $product["ImageURL"]; ?> <br>

            <input type="submit" value="Delete">
        </form>
        <?php if ($_SESSION['token']) : ?>
            <a href="../logout.php">Logout</a>
        <?php endif; ?>
    </body>

    </html>
<?php endif ?>