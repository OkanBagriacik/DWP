<?php if (!empty($_POST)) : ?>
    <?php
    include './db_extension.php';
    session_id(uniqid());
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
<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Login Page</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-2"></div>
            <div class="col-lg-6 col-md-8 login-box">
                <div class="col-lg-12 login-key">
                    <i class="fa fa-key" aria-hidden="true"></i>
                </div>
                <div class="col-lg-12 login-title">
                    Login
                </div>

                <div class="col-lg-12 login-form">
                    <div class="col-lg-12 login-form">
                        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <label class="form-control-label">USERNAME</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">PASSWORD</label>
                                <input type="password" name="password" required class="form-control" i>
                            </div>

                            <div class="col-lg-12 loginbttm">
                                <div class="col-lg-6 login-btm login-text">
                                    <?php echo !empty($confirmError) ? "Login failed!!! username or password is not correnct" : "" ?>
                                </div>
                                <div class="col-lg-6 login-btm login-button">
                                    <button type="submit" class="btn btn-outline-primary">LOGIN</button>
                                </div>
                                <small style="color: aliceblue;position: absolute;top: 10px;display: flex;">If you don't have account please <a style="color: #27EF9F" href="../register.php"> Register</a></small>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-3 col-md-2"></div>
            </div>
        </div>
</body>

</html>