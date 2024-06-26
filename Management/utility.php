<?php
function isFilled($var) {   //checks if form field is filled
    $var = $_SERVER['REQUEST_METHOD'] === 'POST' ? $_POST[$var] : $_GET[$var];
    return isset($var) && $var != "";
}

function timerRelocation($var) {    //redirects to $var after 2 seconds
    echo "	<script> setTimeout(function() {
                    window.location.href = '$var';
                }, 2000);
            </script>";
    exit;
}

function relocation($var) { //redirects to $var
    echo "<script> window.location.href = '$var'; </script>";
    exit;
}

function alert( $msg, $type = "info") { //shows an alert with $msg
    echo "<script> alert('$msg', '$type'); </script>";
}

function writeLog($msg) {   //writes $msg in console
    echo "<script> console.log('$msg'); </script>";
}