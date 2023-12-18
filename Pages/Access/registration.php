<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
	<link rel="stylesheet" type="text/css" href="../../Management/Style/style.css">
    <link rel="stylesheet" type="text/css" href="../../Management/Style/forms.css">

    <?php
		include("../../Management/accessControl.php");
		include("../../Management/utility.php");
	?>
</head>
<body>
	<div id="form-sfondo">
		<div id="form">
			<form action="" method="POST">
				<div id="form-dati">
					<h1>Sign-up</h1>
					<label for="username">Username:</label><br>
					<input type="text" id="username" name="username" required><br><br>

					<label for="email">Email:</label><br>
					<input type="email" id="email" name="email" required><br><br>

					<label for="pass">Password:</label><br>
					<input type="password" id="pass" name="pass" required><br><br>

					<label for="confirm-password">Confirm Password:</label><br>
					<input type="password" id="confirm-password" name="confirm-password" required><br><br>
				</div>
				<input type="submit" value="Registrati" id="register-button" disabled>

				<div id="switchForm">
					<br><a href="login.php">Already registered? Login here</a>
				</div>
			</form>
		</div>
	</div>

    <script>
        // Ottieni i riferimenti agli elementi del modulo
        const usernameInput = document.getElementById("username");
        const passwordInput = document.getElementById("pass");
        const confirmPasswordInput = document.getElementById("confirm-password");
        const emailInput = document.getElementById("email");
        const registerButton = document.getElementById("register-button");

        // Aggiungi un gestore di eventi per verificare se tutti i campi sono stati riempiti
        usernameInput.addEventListener("input", toggleRegisterButton);
        passwordInput.addEventListener("input", toggleRegisterButton);
        confirmPasswordInput.addEventListener("input", toggleRegisterButton);
        emailInput.addEventListener("input", toggleRegisterButton);

        function toggleRegisterButton() {
            if (usernameInput.value !== "" && passwordInput.value !== "" && confirmPasswordInput.value !== "" && emailInput.value !== "") {
                registerButton.removeAttribute("disabled");
            } else {
                registerButton.setAttribute("disabled", "disabled");
            }
        }
    </script>
	
	<?php
		if(isLogged()) {
			echo "<script> window.location.href = '../Pages/index.php';</script>";
			exit;
		}

		$email_pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if(!isFilled("username") && !isFilled("email") && !isFilled("pass") && !isFilled("confirm-password")) {
				alert("Compilare tutti i campi");
				if(session_status() == PHP_SESSION_ACTIVE)
					session_abort();
				timerRelocation("registration.php");
			} 

			$psw = password_hash(trim($_POST['pass']), PASSWORD_DEFAULT);
			if (!password_verify($_POST['confirm-password'], $psw)) {
				alert("Le password inserite non combaciano");
				if(session_status() == PHP_SESSION_ACTIVE)
					session_abort();
				timerRelocation("registration.php");
			} else if(!preg_match($email_pattern, $_POST['email'])) {
				alert("Il campo email non rispetta il formato richiesto");
				if(session_status() == PHP_SESSION_ACTIVE)
					session_abort();
				timerRelocation("registration.php");
			}

			$email = htmlspecialchars(trim($_POST['email']));

			$res = selectDb("email", "email = '$email'");
			if($res->num_rows != 0) {
				alert("Utente già registrato");
				if(session_status() == PHP_SESSION_ACTIVE)
					session_abort();
				timerRelocation("");
				exit;
			}
			$username = htmlspecialchars(trim($_POST["username"]));
			insertDb("username, email, password", "'$username', '$email', '$psw'");
			
			$_SESSION['logged'] = $email;
			echo "<script> window.location.href = '../index.php';</script>";
			exit;
		}
	?>
</body>
</html>
