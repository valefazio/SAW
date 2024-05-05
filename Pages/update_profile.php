<?php
include("../Management/utility.php");
include("../Management/Database/connection.php");

if (!session_start())
    exit("Troubles starting session.");
if(!isLogged())
    header("Location: Access/checkAccess.php?login");

$email_pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";

if($_SERVER["REQUEST_METHOD"] == "POST") {
    if (!isFilled("firstname") && !isFilled("lastname") && !isFilled("email") && !isFilled("pass") && !isFilled("confirm-password")) {
        alert("Compilare tutti i campi", "warning");
        if (session_status() == PHP_SESSION_ACTIVE)
            session_abort();
        relocation("profile.php");
    }

    $email = htmlspecialchars(trim($_POST['email']));
    $psw = password_hash(trim($_POST['pass']), PASSWORD_DEFAULT);
    if (!preg_match($email_pattern, $email)) {
        alert("Il campo email non rispetta il formato richiesto", "warning");
        if (session_status() == PHP_SESSION_ACTIVE)
            session_abort();
        relocation("profile.php");
    }

    //controllo in caso di email già registrata
    if ($email != $_SESSION['email']) {
        $res = selectDb("users", ["email"], ["email"], [$email]);
        if ($res->num_rows != 0) {
            alert("Utente già registrato");
            if (session_status() == PHP_SESSION_ACTIVE)
                session_abort();
            relocation("");
            exit;
        }
    }

    //gestione upload di foto profilo
    if(isset($_FILES["profile_picture"]) && $_FILES["profile_picture"]["error"] == 0) {
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
                    updateDb("users", ["profile_picture"], [$file], ["email"], [$_SESSION["email"]]);
                } else {
                    alert("File troppo grande");
                    if (session_status() == PHP_SESSION_ACTIVE)
                        session_abort();
                    relocation("profile.php");
                    exit;
                }
            } else {
                alert("Errore durante il caricamento del file");
                relocation("profile.php");
                exit;
            }
        } else {
            alert("Formato file non supportato");
            relocation("profile.php");
            exit;
        }
    } else {
        alert("Errore durante il caricamento del file");
        relocation("profile.php");
        exit;
    }

    

    $firstname = htmlspecialchars(trim($_POST["firstname"]));
    $lastname = htmlspecialchars(trim($_POST["lastname"]));
    updateDb("users", ["firstname", "lastname", "email", "password"], [$firstname, $lastname, $email, $psw], ["email"], [$_SESSION["email"]]);

    $_SESSION['email'] = $email;
    relocation("profile.php");
    exit;
}