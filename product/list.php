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
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Page</title>
</head>

<body>
    <table>
        <tr>
            <td>
                Product Name
            </td>
            <td>
                Price:
            </td>
            <td>
                Description:
            </td>
            <td>
                Image URL:
            </td>
            <td>Actions</td>
        </tr>
        <?php for ($index = 0; $index < count($products); $index++) : ?>
            <tr>
                <td>
                    <?php echo $products[$index]["ProductName"] ?>
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
                    <a href="./edit.php?productId=<?php echo $products[$index]["ProductID"] ?>">Edit</a>
                    <a href="./delete.php?productId=<?php echo $products[$index]["ProductID"] ?>">Delete</a>
                </td>
            </tr>
        <?php endfor; ?>
    </table>
    <?php if ($_SESSION['token']) : ?>
        <a href="../logout.php">Logout</a>
    <?php endif; ?>
</body>

</html>