<?php
	if(!session_start()) exit("Troubles starting session.");
	include("../Management/utility.php");
    include("../Management/Database/connection.php");
    $email = $_SESSION['email'];
    unset($_SESSION['email']);
    session_destroy();
    header("Location: home.php");