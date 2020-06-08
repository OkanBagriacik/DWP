<!-- removes a product from database */ --> 
<?php
include '../db_extension.php';
?>
<?php if (!empty($_POST)) : ?>
    <?php
    $id = htmlspecialchars($_POST["id"]);

    $result = deleteProduct($id);
    
    if ($result) {
        header("Location: list.php");
    } else $resultError = true;
    ?>

<?php endif; ?>

<?php
session_start();
if ($_SESSION['usertype'] != "Admin") {
    header("Location: ../login.php");
}

$product = getProduct(htmlspecialchars($_GET["productId"]));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Edit Product Page</title>
</head>


<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-2"></div>
            <div class="col-lg-6 col-md-8 login-box">
                <div class="col-lg-12 login-title">
                    Do you confirm to delete following entry?
                </div>
                <div class="col-lg-12 login-form">
                    <div class="col-lg-12 login-form">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <input type="text" name="id" hidden value="<?php echo $product["ProductID"]; ?>" />
                            <div class="form-group">
                                <label class="form-control-label">Product Name</label>
                                <input type="text" disabled name="productname" value="<?php echo $product["ProductName"]; ?>" />
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Price</label>
                                <input type="text" disabled name="price" value="<?php echo $product["Price"]; ?>" />
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Description</label>
                                <input type="text" disabled name="description" value="<?php echo $product["Description"]; ?>" />
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Image URL</label>
                                <input type="text" disabled name="imageurl" value="<?php echo $product["ImageURL"]; ?>" />
                            </div>
                            <div class="col-lg-12 loginbttm">
                                <div class="col-lg-6 login-btm login-text">
                                    <?php echo !empty($resultError) ? "error occured" : "" ?>
                                </div>
                                <div class="col-lg-6 login-btm login-button">
                                    <input type="submit" value="Delete" class="btn btn-outline-primary">
                                </div>
                            </div>


                        </form>
                        <a href="/" class="backtohome btn btn-info btn-lg">
                            <span class="glyphicon glyphicon glyphicon-home"></span> Back to home
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>

</html>