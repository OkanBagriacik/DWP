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
<html lang="en">

<head>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
    <link rel="stylesheet" href="./assets/css/style.css">
    <title>Register Page</title>
</head>

<body>
    <div class="container">
        <div class="row">
            <div class="col-lg-3 col-md-2"></div>
            <div class="col-lg-6 col-md-8 login-box">
                <div class="col-lg-12 login-key">
                    <i class="fa fa-register" aria-hidden="true"></i>
                </div>
                <div class="col-lg-12 login-title">
                    Register
                </div>

                <div class="col-lg-12 login-form">
                    <div class="col-lg-12 login-form">
                    <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                            <div class="form-group">
                                <label class="form-control-label">First Name</label>
                                <input type="text" class="form-control" name="first-name" required>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Last Name</label>
                                <input type="text" class="form-control" name="last-email" required>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">USERNAME</label>
                                <input type="text" class="form-control" name="username" required>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Email</label>
                                <input type="text" class="form-control" name="email" required>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Address</label>
                                <input type="text" class="form-control" name="address" required>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Password</label>
                                <input type="password" name="pass" required class="form-control" i>
                            </div>
                            <div class="form-group">
                                <label class="form-control-label">Confirm Password</label>
                                <input type="password" name="pass" required class="form-control" i>
                            </div>

                            <div class="col-lg-12 loginbttm">
                                <div class="col-lg-6 login-btm login-text">
                                    <?php echo !empty($confirmError) ? "Login failed!!! username or password is not correnct" : "" ?>
                                </div>
                                <div class="col-lg-6 login-btm login-button">
                                    <button type="submit" class="btn btn-outline-primary">REGISTER</button>
                                </div>
                                <small style="color: aliceblue;position: absolute;top: 10px;display: flex;">Do you have an account?<a style="color: #27EF9F" href="../login.php"> Login</a></small>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-3 col-md-2"></div>
            </div>
        </div>
</body>

</html>
<?php endif; ?>