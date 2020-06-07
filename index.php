<?php
include './db_extension.php';
session_start();
?>
<?php if (!empty($_POST)) : ?>
    <?php
    echo 'sda';
    $type =  htmlspecialchars($_GET["type"]);
    $productId =  htmlspecialchars($_GET["productId"]);

    if ($type == 'addToCart') {
        addToCart($productId);
        header('Location: index.php');
    }

    ?>
<?php endif; ?>
<?php

$username = "root";
$password = "admin";

try {
    $conn = new PDO("mysql:host=localhost;dbname=minus", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    // echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}

if (!$_SESSION['token']) {
    header("Location: ../login.php");
}
$products = getAllProducts();
?>

<!DOCTYPE html>
<html>

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="./assets/css/style.css">

</head>

<body>
    <?php if (isset($_SESSION['token'])) : ?>
        <div class="indexPage">
            <a href="./product/list.php"><button class="btn btn-outline-primary">Products</button></a>
            <a href="./productCategory/list.php"><button class="btn btn-outline-primary">Product Categories</button></a>
            <a href="./profile/edit.php"><button class="btn btn-outline-primary">Profile</button></a>
            <a href="./logout.php"><button class="btn btn-outline-primary">Log out</button></a>
            <a href="./cart/cart.php" class="btn btn-info btn-lg">
                <span class="glyphicon glyphicon-shopping-cart"></span> Shopping Cart
            </a>
        </div>
        <div class="container">
            <?php for ($index = 0; $index < count($products); $index++) : ?>
                <div class="product">
                    <div class="img-container">
                        <img src="<?php echo $products[$index]["ImageURL"] ?>">
                    </div>
                    <div class="product-info">
                        <div class="product-content">
                            <h1> <?php echo $products[$index]["ProductName"] ?></h1>
                            <p><?php echo $products[$index]["Description"] ?></p>
                            <ul>
                                <li>Categories</li>
                            </ul>
                            <div class="buttons">
                                <form method="post" id='addToCart' action="./index.php?type=addToCart&productId=<?php echo $products[$index]["ProductID"] ?>">
                                    <input type="submit" name="addToCart" class="button add" value="Add to Cart" />
                                </form>
                                <span class="button" id="price"> <?php echo $products[$index]["Price"] ?>TL</span>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endfor; ?>
        </div>
    <?php else : ?>
        <div class="indexPage">
            <a href="./login.php"><button class="btn btn-outline-primary">Login</button></a>
            <small style="color:aliceblue; padding: 5px">OR</small>
            <a href="./register.php"><button class="btn btn-outline-primary">Register</button></a>
        </div>
    <?php endif; ?>
    <script>

    </script>
</body>

</html>