<?php
include "../Management/accessControl.php";

if ($_POST['to_do'] == "heart") {
    if (isLogged()) {
        if ($_POST['action'] == 'add') {
            if (insertDb("preferites", ["monster", "door"], [$_SESSION['logged'], $_POST['room']]))
                echo true;
            else
                echo false;   //ERROR
        } else {    //remove
            if (removeDb("preferites", "monster = '" . $_SESSION['logged'] . "' AND door = '" . $_POST['room'] . "'"))
                echo true;
            else
                echo false;   //ERROR
        }
    } else {
        echo false;
    }
} else if($_POST['to_do'] == "getCover") {
    $res = selectDb("room_pics", ["filename"], ["room_id"], [$_POST['room']]);
    if ($res->num_rows > 0) {
        $row = $res->fetch_assoc();
        echo $row['filename'];
    } else {
        echo null;
    }
}