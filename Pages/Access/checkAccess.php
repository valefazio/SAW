<?php
include("../../Management/accessControl.php");

if(isLogged()) {
    header("Location: ../index.php");
    exit;
}

$queryParam = $_SERVER['QUERY_STRING'];
if ($queryParam === 'login')
    header("Location: login.html");
else if ($queryParam === 'registration') 
    header("Location: registration.html");
else
    header("Location: ../home.php");