<!-- lets the current user to change its profile information for example username, password,address etc.. -->
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
    if ($_SESSION['usertype'] != "Admin"  && $_SESSION['usertype'] != "Customer") {
        header("Location: ../login.php");
    }
    include '../db_extension.php';
    $user = getUser();
    ?>
    <!DOCTYPE html>
    <html lang="en">


    <head>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/4.0.0-beta/css/bootstrap.min.css">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto">
        <link rel="stylesheet" href="../assets/css/style.css">
        <title>Edit Profile Page</title>
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
                        Edit Profile
                    </div>

                    <div class="col-lg-12 login-form">
                        <div class="col-lg-12 login-form">


                            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
                                <div class="form-group">
                                    <label class="form-control-label">First Name</label>
                                    <input type="text" class="form-control" name="firstname" value="<?php echo $user["FirstName"]; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Last Name</label>
                                    <input type="text" class="form-control" name="lastname" value="<?php echo $user["LastName"]; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">USERNAME</label>
                                    <input type="text" class="form-control" name="username" value="<?php echo $user["UserName"]; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Email</label>
                                    <input type="text" class="form-control" name="email" value="<?php echo $user["Email"]; ?>" required>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Password</label>
                                    <input type="password" name="password" required value="<?php echo $user["Password"]; ?>" class="form-control" i>
                                </div>
                                <div class="form-group">
                                    <label class="form-control-label">Address</label>
                                    <input type="text" class="form-control" name="address" value="<?php echo $user["Address"]; ?>" required>
                                </div>


                                <div class="col-lg-12 loginbttm">
                                    <div class="col-lg-6 login-btm login-text">
                                        <?php echo !empty($resultError) ? "error occured" : "" ?>
                                    </div>
                                    <div class="col-lg-6 login-btm login-button">
                                        <button type="submit" class="btn btn-outline-primary">Save</button>
                                    </div>
                                </div>

                                <a href="/" class="backtohome btn btn-info btn-lg">
                                    <span class="glyphicon glyphicon glyphicon-home"></span> Back to home
                                </a>
                            </form>
                        </div>
                    </div>
                    <div class="col-lg-3 col-md-2"> </div>
                </div>
            </div>
    </body>

    </html>
<?php endif ?>