<?php
include("../../Management/utility.php");
include("../../Management/Database/connection.php");
if(!session_start()) exit("Troubles starting session.");

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isFilled("email") && isFilled("pass")) {	//ha inserito i dati
	$email = htmlspecialchars($_POST['email']);

	$res = selectDb("users", ["email", "password"], ["email"], [$email]);
	if ($res->num_rows == 0) {
		alert("L\'email o la password non sono corrette", "warning");
		if (session_status() == PHP_SESSION_ACTIVE)
			session_abort();
		relocation("login.html");
		exit;
	}

	$row = $res->fetch_assoc();
	$password = $_POST['pass'];

	if (!password_verify($password, $row['password'])) {
		alert("L\'email o la password non sono corrette", "warning");
		if (session_status() == PHP_SESSION_ACTIVE)
			session_abort();
		relocation("login.html");
		exit;
	}

	//impostazione variabili di sessione e cookies
	$_SESSION['email'] = $email;
	if (isset ($_POST['remember-me'])) {
		rememberMe($email, $bytes);
		setcookie("remember-me", $bytes, time() + (86400 * 30), "/");
		updateDb("users", ["remember_token"], [hash('sha256', $bytes)], ["email"], [$email]);
		updateDb("users", ["remember_token_created_at"], ["CURRENT_TIMESTAMP"], ["email"], [$email]);
	}
	header("Location: ../home.php");
	exit;
} else {
	if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset ($_POST['submit']))
		header("Location: login.html");
	//else wait for data...
}

function rememberMe($email, $bytes)
{
	$conn = accessDb();
	try {
		$bytes = random_bytes(12);
		$conn->begin_transaction();

		updateDb("users", ["remember_token"], [hash('sha256', $bytes)], ["email"], [$email]);
		updateDb("users", ["remember_token_created_at"], ["CURRENT_TIMESTAMP"], ["email"], [$email]);

		$conn->commit();

		setcookie("remember-me", $bytes, time() + (86400 * 30), "/");
	} catch (Exception $e) {
		// An error occurred, rollback the transaction
		$conn->rollBack();
		echo "Error: " . $e->getMessage();
	}
	$conn->close();
}