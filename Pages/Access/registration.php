<?php
include ("../../Management/utility.php");
include ("../../Management/Database/connection.php");
if (!session_start())
	exit ("Troubles starting session.");

$email_pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	/* if(!isFilled("firstname") && !isFilled("lastname") && !isFilled("email") && !isFilled("pass") && !isFilled("confirm-password")) {
				 alert("Compilare tutti i campi", "warning");
				 if(session_status() == PHP_SESSION_ACTIVE)
					 session_abort();
				 relocation("registration.html");
			 } 

			 $email = htmlspecialchars(trim($_POST['email']));
			 $psw = password_hash(trim($_POST['pass']), PASSWORD_DEFAULT);

			 if (!password_verify($_POST['confirm-password'], $psw)) {
				 alert("Le password inserite non combaciano", "warning");
				 if(session_status() == PHP_SESSION_ACTIVE)
					 session_abort();
				 relocation("registration.html");
			 } else if(!preg_match($email_pattern, $email)) {
				 alert("Il campo email non rispetta il formato richiesto", "warning");
				 if(session_status() == PHP_SESSION_ACTIVE)
					 session_abort();
					 relocation("registration.html");
			 }

			 $res = selectDb("users", ["email"], "email = '$email'");
			 if($res->num_rows != 0) {
				 alert("Utente già registrato");
				 if(session_status() == PHP_SESSION_ACTIVE)
					 session_abort();
					 relocation("");
				 exit;
			 }
			 $firstname = htmlspecialchars(trim($_POST["firstname"]));
			 $lastname = htmlspecialchars(trim($_POST["lastname"]));
			 echo "ok"; */

	$firstname = $_POST["firstname"];
	$lastname = $_POST["lastname"];
	$email = $_POST["email"];
	$psw = password_hash($_POST["pass"], PASSWORD_DEFAULT);

	//insertDb("users", ["firstname", "lastname", "email", "password"], [$firstname, $lastname, $email, $psw]);
	$conn = new mysqli("localhost", "vale", "uni23", "uni");
	$query = "INSERT INTO users (firstname, lastname, email, password) VALUES (?, ?, ?, ?)";
	$stmt = $conn->prepare($query);
	$stmt->bind_param("ssss", $firstname, $lastname, $email, $psw);
	$stmt->execute();
	$stmt->close();
	disconnectDb($conn);

	//$_SESSION['logged'] = $email;
	relocation("../home.php");
	exit;
}
