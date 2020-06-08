/* creates a new product */
<?php if (!empty($_POST)) : ?>
    <?php
    include '../db_extension.php';
    $productname = htmlspecialchars($_POST["productname"]);
    $price = htmlspecialchars($_POST["price"]);
    $description = htmlspecialchars($_POST["description"]);
    $imageurl = htmlspecialchars($_POST["imageurl"]);
    $productCatId = htmlspecialchars($_POST["productCategoryId"]);
    $result = addProduct($productname, $productCatId, $price, $description, $imageurl);

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
include '../db_extension.php';
$productCategories = listCategories();

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Add New Product Page</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-2"></div>
            <div class="col-lg-6 col-md-8 login-box">
                <div class="col-lg-12 login-title">
                    Add New Product
                </div>
                <div class="col-lg-12 login-form">
                    <div class="col-lg-12 login-form">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <label class="form-control-label">Product Name</label>
                                <input type="text" required name="productname" />
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Product Category</label>
                                <select id="productCategory" name='productCategoryId'>
                                    <?php for ($index = 0; $index < count($productCategories); $index++) : ?>
                                        <option value="<?php echo $productCategories[$index]['CategoryID'] ?>"><?php echo $productCategories[$index]['CategoryName'] ?></option>
                                    <?php endfor; ?>
                                </select>
                            </div>

                            <div class="form-group">
                                <label class="form-control-label">Price</label>
                                <input type="text" required name="price" />
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Description</label>
                                <input type="text" required name="description" />
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Image URL</label>
                                <input type="text" required name="imageurl" />
                            </div>
                            <div class="col-lg-12 loginbttm">
                                <div class="col-lg-6 login-btm login-text">
                                    <?php echo !empty($resultError) ? "error occured" : "" ?>
                                </div>
                                <div class="col-lg-6 login-btm login-button">
                                    <input type="submit" class="btn btn-outline-primary">
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