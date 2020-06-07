<?php
session_start();
if (!$_SESSION['token']) {
    header("Location: ../login.php");
}
include '../db_extension.php';
$products = getAllProducts();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.2.0/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="../assets/css/style.css">
    <title>Register Page</title>
</head>


<body>
    <h2 style="color: #000">List all of Product</h2>
    <a href="add.php" style="position: fixed;
    top: 34px;
    right: 32%;" class="btn btn-success btn-lg">
        <span class="glyphicon glyphicon glyphicon-plus-sign"></span> Add new Product
    </a>
    <div class="container">
        <div class="row">
            <div class="col-xs-12">
                <div class="table-responsive">
                    <table summary="This table shows how to create responsive tables using Bootstrap's default functionality" class="table table-bordered table-hover">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Product Category</th>
                                <th>Price</th>
                                <th>Description</th>
                                <th>Image URL</th>
                                <th>Edit </th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php for ($index = 0; $index < count($products); $index++) : ?>
                                <tr>
                                    <td>
                                        <?php echo $products[$index]["ProductName"] ?>
                                    </td>
                                    <td>
                                        <?php echo $products[$index]["CategoryName"] ?>
                                    </td>
                                    <td>
                                        <?php echo $products[$index]["Price"] ?>
                                    </td>
                                    <td>
                                        <?php echo $products[$index]["Description"] ?>
                                    </td>
                                    <td>
                                        <?php echo $products[$index]["ImageURL"] ?>
                                    </td>
                                    <td>
                                        <a href="./edit.php?productId=<?php echo $products[$index]["ProductID"] ?>" class="btn btn-outline-primary">Edit</a>
                                        <a href="./delete.php?productId=<?php echo $products[$index]["ProductID"] ?>" class="btn btn-outline-primary">Delete</a>
                                    </td>
                                </tr>
                            <?php endfor; ?>
                        </tbody>
                    </table>
                </div>
                <!--end of .table-responsive-->
            </div>
        </div>
    </div>
    <a href="/" class="backtohome btn btn-info btn-lg">
                            <span class="glyphicon glyphicon glyphicon-home"></span> Back to home
                        </a>
</body>

</html>