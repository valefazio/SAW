<?php
include("utility.php");
include("Database/connection.php");

if (!session_start())
    exit("Troubles starting session.");

    // Check if the user is logged in
    if (!isset($_SESSION['email'])) {
        // User is not logged in
        echo "You must be logged in to delete your account.";
        relocation("../Pages/Access/login.html");
    }

    if (!isset($_SESSION['delete'])) {
        // User accessed this page without clicking the delete button
        relocation("../Pages/404.php");
    }

    // Get the user ID from the session
    $email = $_SESSION['email'];

    // Delete the account from the database
    $result = removeDb("users", ["email"], [$email]);

    unset($_SESSION["delete"]);

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

//Da fixare: se l'utente non è loggato, non può accedere a questa pagina
//Da fixare: se non c'è alcun where, non eliminare nulla