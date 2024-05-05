<?php
include("../Management/utility.php");
include("../Management/Database/connection.php");

if (!session_start())
    exit("Troubles starting session.");


    // Get the user ID from the session
    $email = $_SESSION['email'];

    // Delete the account from the database
    $where = "email = '$email'";
    $result = removeDb("users", $where);

    if ($result) {
        // Account deleted successfully
        echo "Account deleted successfully.";
    } else {
        // Failed to delete account
        echo "Failed to delete account.";
    }