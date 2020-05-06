<?php if (!empty($_POST)) : ?>
    <?php
    include '../db_extension.php';
    $productname = htmlspecialchars($_POST["productname"]);
    $price = htmlspecialchars($_POST["price"]);
    $description = htmlspecialchars($_POST["description"]);
    $imageurl = htmlspecialchars($_POST["imageurl"]);

    $result = addProduct($productname, $price, $description, $imageurl);

    if ($result) {
        header("location: list.php");
    } else $resultError = true;
    ?>

<?php endif ?>
<?php
session_start();
if ($_SESSION['usertype'] != "Admin") {
    header("Location: ../login.php");
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>

<body>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Product Name: <input type="text" name="productname" required><br>
        Price: <input type="text" name="price" required><br>
        Description: <input type="text" name="description" required><br>
        Image URL: <input type="text" name="imageurl"><br>
        <input type="submit">
        <?php echo !empty($resultError) ? "error occured" : "" ?>
    </form>
    <?php if ($_SESSION['token']) : ?>
        <a href="../logout.php">Logout</a>
    <?php endif; ?>
</body>

</html>