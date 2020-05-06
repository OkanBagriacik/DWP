<?php session_start(); ?>
<?php if (!isset($_SESSION['token'])) : ?>
    <?php header("Location: ../login.php"); ?>
<?php endif; ?>

<?php if (!empty($_POST)) : ?>
    <?php
    include '../db_extension.php';
    $firstname = htmlspecialchars($_POST["firstname"]);
    $lastname = htmlspecialchars($_POST["lastname"]);
    $username = htmlspecialchars($_POST["username"]);
    $email = htmlspecialchars($_POST["email"]);
    $password = htmlspecialchars($_POST["password"]);
    $address = htmlspecialchars($_POST["address"]);

    $result = updateUser($firstname, $lastname, $username, $email, $password, $address);

    if ($result) {
        header("location: /index.php");
    } else $resultError = true;
    ?>

<?php else : ?>
    <?php
    if ($_SESSION['usertype'] != "Admin") {
        header("Location: ../login.php");
    }
    include '../db_extension.php';
    $user = getUser();
    ?>
    <!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Edit Page</title>
    </head>

    <body>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
            First Name: <input type="text" required name="firstname" value="<?php echo $user["FirstName"]; ?>" /> <br>
            LastName: <input type="text" required name="lastname" value="<?php echo $user["LastName"]; ?>" /> <br>
            User Name: <input type="text" required name="username" value="<?php echo $user["UserName"]; ?>" /> <br>
            Email: <input type="text" required name="email" value="<?php echo $user["Email"]; ?>" /> <br>
            Password: <input type="text" required name="password" value="<?php echo $user["Password"]; ?>" /> <br>
            Address: <input type="text" required name="address" value="<?php echo $user["Address"]; ?>" /> <br>
            <input type="submit">
            <?php echo !empty($resultError) ? "error occured" : "" ?>
        </form>
        <?php if ($_SESSION['token']) : ?>
            <a href="../logout.php">Logout</a>
        <?php endif; ?>
    </body>

    </html>
<?php endif ?>