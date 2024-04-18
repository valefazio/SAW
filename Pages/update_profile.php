<?php
include("../Management/utility.php");
include("../Management/Database/connection.php");

if (!session_start())
    exit("Troubles starting session.");

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

    //Se non volessi cambiare mail?
    //controllo in caso di email già registrata
    /*
    $res = selectDb("users", ["email"], ["email"], [$email]);
	if ($res->num_rows != 0) {
		alert("Utente già registrato");
		if (session_status() == PHP_SESSION_ACTIVE)
			session_abort();
		relocation("");
		exit;
	}
    */

    $firstname = htmlspecialchars(trim($_POST["firstname"]));
    $lastname = htmlspecialchars(trim($_POST["lastname"]));
    updateDb("users", ["firstname", "lastname", "email", "password"], [$firstname, $lastname, $email, $psw], ["email"], [$_SESSION["email"]]);

    $_SESSION['email'] = $email;
    relocation("profile.php");
    exit;
}