<?php

if(!session_start())
    exit("Troubles starting session.");

$_SESSION['stato'] = "delete";
echo true;