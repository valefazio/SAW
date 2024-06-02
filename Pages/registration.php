<?php
include ("../Management/utility.php");
include ("../Management/Database/connection.php");
if (!session_start())
	exit ("Troubles starting session.");

$email_pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
$password_pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[\W_])[a-zA-Z\d\W_]{8,}$/";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
	if (!isFilled("firstname") && !isFilled("lastname") && !isFilled("email") && !isFilled("pass") && !isFilled("confirm")) {
		alert("Compilare tutti i campi", "warning");
		if (session_status() == PHP_SESSION_ACTIVE)
			session_abort();
		relocation("registration.html");
	}

	$email = htmlspecialchars(trim($_POST['email']));
	$psw = trim($_POST['pass']);
	if (!preg_match($password_pattern, $psw)) {
		alert("La password deve contenere almeno 8 caratteri, di cui almeno una lettera maiuscola, una minuscola, un numero e un carratere speciale", "warning");
		if (session_status() == PHP_SESSION_ACTIVE)
			session_abort();
		relocation("registration.html");
		exit;
	}

	$psw = password_hash($psw, PASSWORD_DEFAULT);

	if (!password_verify($_POST['confirm'], $psw)) {
		alert("Le password inserite non combaciano", "warning");
		if (session_status() == PHP_SESSION_ACTIVE)
			session_abort();
		relocation("registration.html");
	} else if (!preg_match($email_pattern, $email)) {
		alert("Il campo email non rispetta il formato richiesto", "warning");
		if (session_status() == PHP_SESSION_ACTIVE)
			session_abort();
		relocation("registration.html");
	}

	$res = selectDb("users", ["email"], ["email"], [$email]);
	if ($res->num_rows != 0) {
		alert("Utente già registrato");
		if (session_status() == PHP_SESSION_ACTIVE)
			session_abort();
		relocation("registration.html");
		exit;
	}
	$firstname = htmlspecialchars(trim($_POST["firstname"]));
	$lastname = htmlspecialchars(trim($_POST["lastname"]));
	if(insertDb("users", ["firstname", "lastname", "email", "password"], [$firstname, $lastname, $email, $psw]) == false)
		relocation("../404.php");

	$_SESSION['email'] = $email;
	relocation("home.php");
	echo "Registrazione avvenuta con successo" . $_SESSION['email'];
	exit;
}

