<?php
include("utility.php");
include("Database/connection.php");

if (!session_start())
    exit("Troubles starting session.");


    // Get the user ID from the session
    $email = $_SESSION['email'];

    // Delete the account from the database
    $result = removeDb("users", ["email"], [$email]);

    if ($result) {
        // Account deleted successfully
        echo "Account deleted successfully.";
        // Destroy the session
        session_destroy();
        // Redirect to the login page dopo 1 secondo
        header("Location: ../Pages/home.php");
    } else {
        // Failed to delete account
        echo "Failed to delete account.";
        relocation("../Pages/404.php");//ERROR
    }