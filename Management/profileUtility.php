<?php

if(!session_start())
    exit("Troubles starting session.");

if($_POST['to_do'] == 'update')
    $_SESSION['stato'] = "update";
else
    $_SESSION['stato'] = "delete";
echo true;