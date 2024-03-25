<?php
include "../Management/accessControl.php";

if (isLogged()) {
    //$res = selectDb("preferites", ["room"], "email = '$_SESSION[logged]' AND room = '$_POST[room]'");
    if ($_POST['action'] == 'add') {
        if(insertDb("preferites", ["monster", "door"], [$_SESSION['logged'], $_POST['room']]))
            echo true;
        else
            echo false;   //ERROR
    } else {    //remove
        if(removeDb("preferites", "monster = '".$_SESSION['logged']."' AND door = '".$_POST['room']."'"))
            echo true;
        else
            echo false;   //ERROR
    }
} else {
    echo false;
}