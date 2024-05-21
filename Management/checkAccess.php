<?php
include("accessControl.php");

if(isLogged()) {
    header("Location: ../index.php");
    exit;
}

$queryParam = $_SERVER['QUERY_STRING'];
if ($queryParam === 'login')
    header("Location: ../Pages/login.html");
else if ($queryParam === 'registration') 
    header("Location: ../Pages/registration.html");
else
    header("Location: ../home.php");
