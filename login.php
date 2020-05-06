<?php if (!empty($_POST)) : ?>
    <?php
    include './db_extension.php';
    session_start();

    $user = login($_POST["username"], $_POST["password"]);

    if ($user != null) {

        $_SESSION["token"] = $user['UserName'];
        $_SESSION["usertype"] = $user['UserType'];
        $_SESSION["userid"] = $user['UserID'];
        header("Location: index.php");
        return;
    } else {
        $confirmError = true;
    }
    ?>
<?php else : ?>

<?php endif; ?>

<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <button type="submit">Login</button><br>
    <?php echo !empty($confirmError) ? "Login failed!!! username or password is not correnct" : "" ?>
</form>