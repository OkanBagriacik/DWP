<style>
    /* form{
        display: flex;
        justify-content: center;
        align-items: center;
    } */
</style>
<?php include 'db_extension.php'; ?>
<?php if (!empty($_POST)) : ?>
    <?php
    session_start();
    $username = htmlspecialchars($_POST["username"]);
    $firstname = htmlspecialchars($_POST["first-name"]);
    $lastname = htmlspecialchars($_POST["last-name"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["pass"]);
    $address = htmlspecialchars($_POST["address"]);
    $usertype = $_SESSION["usertype"];

    createUser($firstname, $lastname, $username, $email, $password, $address, $usertype);
    header("Location: login.php");
    ?>
<?php else : ?>
    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
        Fist Name: <input type="text" name="first-name" required><br>
        Last Email: <input type="text" name="last-email" required><br>
        Username: <input type="text" name="username" required><br>
        Email: <input type="text" name="email required"><br>
        Address: <input type="text" name="address" required><br>
        Password: <input type="password" name="pass" required><br>
        Confirm Password: <input type="password" name="conf-pass" required><br>
        <input type="submit">
    </form>
<?php endif; ?>