<?php
include ("utility.php");
include ("Database/connection.php");

if (!session_start())
    exit("Troubles starting session.");

// Check if the user is logged in
if (!isset($_SESSION['email'])) {
    // User is not logged in
    echo "You must be logged in to update your account.";
    relocation("../Pages/Access/login.html");
}

if (!isset($_SESSION['stato']) || $_SESSION['stato'] != "update") {
    // User accessed this page without clicking the update button
    relocation("../Pages/404.php");
}

$email_pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    /* if (!isFilled("firstname") && !isFilled("lastname") && !isFilled("email") && !isFilled("pass")) {
        alert("Compilare tutti i campi", "warning");
        if (session_status() == PHP_SESSION_ACTIVE)
            session_abort();
        relocation("../Pages/profile.php");
    } */

    $user = selectDb("users", ["email", "firstname", "lastname"], ["email"], [$_SESSION["email"]]);
    if($user->num_rows == 0) {
        alert("Errore durante il caricamento del profilo");
        relocation("../Pages/404.php");
        exit;
    }
    $user = $user->fetch_assoc();
    $fieldsToUpdate = [];
    $valuesToUpdate = [];

    //CHECK FORMATO EMAIL
    $email = htmlspecialchars(trim($_POST['email']));
    if ($email != $user['email']) {
        if (!preg_match($email_pattern, $email)) {
            alert("Il campo email non rispetta il formato richiesto", "warning");
            if (session_status() == PHP_SESSION_ACTIVE)
                session_abort();
            relocation("../Pages/profile.php");
        }

        //controllo in caso di email già registrata
        if ($email != $_SESSION['email']) {
            $res = selectDb("users", ["email"], ["email"], [$email]);
            if ($res->num_rows != 0) {
                alert("Utente già registrato");
                if (session_status() == PHP_SESSION_ACTIVE)
                    session_abort();
                relocation("../Pages/profile.php");
                exit;
            }
        }
        array_push($fieldsToUpdate, "email");
        array_push($valuesToUpdate, $email);
    }

    //gestione upload di foto profilo
    if (isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == 0) {
        $file = $_FILES["profile_picture"];
        $file_name = $file["name"];
        $file_tmp = $file["tmp_name"];
        $file_size = $file["size"];
        $file_error = $file["error"];
        $file_type = $file["type"];
        $file_ext = explode(".", $file_name);
        $file_actual_ext = strtolower(end($file_ext));
        $allowed = ["jpg", "jpeg", "png"];
        if (in_array($file_actual_ext, $allowed)) {
            if ($file_error === 0) {
                if ($file_size < 1000000) {
                    $file_name_new = uniqid("", true) . "." . $file_actual_ext;
                    $file_destination = "../Management/Images/users/" . $file_name_new;
                    move_uploaded_file($file_tmp, $file_destination);
                    $file = file_get_contents($file_destination);
                    if (updateDb("users", ["profile_picture"], [$file], ["email"], [$_SESSION["email"]])) {
                        unlink($file_destination);
                    } else {
                        alert("Errore durante il caricamento del file");
                        relocation("../Pages/404.php");
                        exit;
                    }
                } else {
                    alert("File troppo grande");
                    if (session_status() == PHP_SESSION_ACTIVE)
                        session_abort();
                    relocation("../Pages/profile.php");
                    exit;
                }
            } else {
                alert("Errore durante il caricamento del file");
                relocation("../Pages/profile.php");
                exit;
            }
        } else {
            alert("Formato file non supportato");
            relocation("../Pages/profile.php");
            exit;
        }
    } else if ($_FILES["profile_picture"]["error"] == 0) {
        alert("Errore durante il caricamento del file");
        relocation("../Pages/profile.php");
        exit;
    }

    $firstname = htmlspecialchars(trim($_POST["firstname"]));
    if ($firstname != $user['firstname']) {
        array_push($fieldsToUpdate, "firstname");
        array_push($valuesToUpdate, $firstname);
    }
    $lastname = htmlspecialchars(trim($_POST["lastname"]));
    if ($lastname != $user['lastname']) {
        array_push($fieldsToUpdate, "lastname");
        array_push($valuesToUpdate, $lastname);
    }
    $psw = htmlspecialchars(trim($_POST["pass"]));
    if ($psw != "") {
        $psw = password_hash($psw, PASSWORD_DEFAULT);
        array_push($fieldsToUpdate, "password");
        array_push($valuesToUpdate, $psw);
    }

    if (count($fieldsToUpdate) == 0) {
        alert("Nessuna modifica effettuata", "warning");
        relocation("../Pages/profile.php");
        exit;
    } else {
        if (!updateDb("users", $fieldsToUpdate, $valuesToUpdate, ["email"], [$_SESSION["email"]])) {
            alert("Errore durante l'aggiornamento del profilo");
            relocation("../Pages/404.php");
            exit;
        } else {
            $_SESSION["email"] = $email;
            alert("Modifiche effettuate con successo", "success");
            relocation("../Pages/profile.php");
            exit;

        }
    }
}