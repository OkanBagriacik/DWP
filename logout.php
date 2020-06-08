<!-- allow user to log out and delete the all session data -->
<?php
session_start();

if (session_destroy()) {
    header("Location: login.php");
}
