<?php
session_start();
$username = "root";
$password = "admin";

try {
    $conn = new PDO("mysql:host=localhost;dbname=minus", $username, $password);
    // set the PDO error mode to exception
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    echo "Connected successfully";
} catch (PDOException $e) {
    echo "Connection failed: " . $e->getMessage();
}
?>

<!DOCTYPE html>
<html>

<body>
    <?php if (isset($_SESSION['token'])) : ?>
        <a href="./product/list.php">Products</a>
        <a href="./profile/edit.php">Profile</a>
        <a href="./logout.php">Logout</a>
    <?php else : ?>
        <a href="./login.php">Login</a>
        <a href="./register.php">Register</a>
    <?php endif; ?>
</body>

</html>