<?php
	if(!session_start()) exit("Troubles starting session.");
    include "../Management/connection.php";
    $email = $_SESSION['logged'];
    updateDb("remember", "NULL", "email = '$email'");
    unset($_COOKIE['remember-me']);
    setcookie('remember-me', '', time() - 3600, '/');
    unset($_SESSION['logged']);
    session_destroy();
    header("Location: ../Pages/index.php");
?>