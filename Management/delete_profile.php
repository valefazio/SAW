<?php
include ("utility.php");
include ("accessControl.php");

if (!session_start())
    exit("Troubles starting session.");

// Check if the user is logged in
if (!isLogged()) {
    //echo "You must be logged in to delete your account.";
    relocation("../Management/checkAccess.php?login");
}

if (!isset($_SESSION['stato']) || $_SESSION['stato'] != "delete") {
    relocation("../Pages/404.php");
}

$email = $_SESSION['email'];
$result = removeDb("users", ["email"], [$email]);


if ($result) {
    echo "Account deleted successfully.";
    session_destroy();
    header("Location: ../Pages/home.php");
} else {
    echo "Failed to delete account.";
    relocation("../Pages/404.php");
}