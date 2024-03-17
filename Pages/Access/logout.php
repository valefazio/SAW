<?php
	if(!session_start()) exit("Troubles starting session.");
	include("../../Management/utility.php");
    include("../../Management/Database/connection.php");
    $email = $_SESSION['logged'];
    updateDb("users", ["remember_token"], ["NULL"], "email = '$email'");
    updateDb("users", ["remember_token_created_at"], ["NULL"], "email = '$email'");
    unset($_COOKIE['remember-me']);
    setcookie('remember-me', '', time() - 3600, '/');
    unset($_SESSION['logged']);
    session_destroy();
    header("Location: ../home.php");