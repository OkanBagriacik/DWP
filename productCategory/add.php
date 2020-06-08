/* creates a new product category */
<?php if (!empty($_POST)) : ?>
    <?php
    include '../db_extension.php';
    $categoryname = htmlspecialchars($_POST["categoryname"]);

    $result = addCategory($categoryname);

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
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Add New Product Category Page</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-2"></div>
            <div class="col-lg-6 col-md-8 login-box">
                <div class="col-lg-12 login-title">
                    Add New Product Category
                </div>
                <div class="col-lg-12 login-form">
                    <div class="col-lg-12 login-form">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <label class="form-control-label">Category Name</label>
                                <input type="text" required name="categoryname" />
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