<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Registration</title>
    <link rel="stylesheet" type="text/css" href="../../Management/Style/forms.css">
    <link
      href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined"
      rel="stylesheet"
    />

    <?php
		include("../../Management/accessControl.php");
	?>
</head>
<body>
	<div id="form-sfondo">
		<div id="form">
			<form action="" method="POST">
				<div id="form-dati">
					<h1>Sign-up</h1>
					<!-- <label for="username">Username:</label><br>
					<input type="text" id="username" name="username" required><br><br> -->

					<label for="email">Email:</label><br>
					<input type="email" id="email" name="email" required><br><br>

					<label for="pass">Password
						<span class="help" title="La password deve contenere almeno 8 caratteri, di cui almeno una lettera maiuscola, una minuscola e un numero">
							help_outline
						</span>
					:</label><br>
					<input type="password" id="pass" name="pass" required><br><br>

					<label for="confirm-password">Confirm Password:</label><br>
					<input type="password" id="confirm-password" name="confirm-password" required><br><br>
				</div>
				<input type="submit" value="Registrati" id="register-button" disabled>

				<div id="switchForm">
					<br><a href="login.html">Already registered? Login here</a>
				</div>
			</form>
		</div>
	</div>

    <script>
        // Ottieni i riferimenti agli elementi del modulo
        /* const usernameInput = document.getElementById("username"); */
        const emailInput = document.getElementById("email");
        const passwordInput = document.getElementById("pass");
        const confirmPasswordInput = document.getElementById("confirm-password");
        const registerButton = document.getElementById("register-button");

        // Aggiungi un gestore di eventi per verificare se tutti i campi sono stati riempiti
        /* usernameInput.addEventListener("input", toggleRegisterButton); */
        emailInput.addEventListener("input", toggleRegisterButton);
        passwordInput.addEventListener("input", toggleRegisterButton);
        confirmPasswordInput.addEventListener("input", toggleRegisterButton);

		<?php
			include("checkFields.js");
		?>

        function toggleRegisterButton() {
			checkEmailFormat();
			//checkPasswordFormat();	//DEBUG
			checkPasswordMatch();
			
            if (/* usernameInput.value !== "" && */ passwordInput.value !== "" && confirmPasswordInput.value !== "" && emailInput.value !== "")
                registerButton.removeAttribute("disabled");
            else
                registerButton.setAttribute("disabled", "disabled");
        }
    </script>
	
	<?php
		if(isLogged()) {
			echo "<script> window.location.href = '../home.php';</script>";
			exit;
		}

		$email_pattern = "/^[a-zA-Z0-9._%+-]+@[a-zA-Z0-9.-]+\.[a-zA-Z]{2,}$/";
		if ($_SERVER["REQUEST_METHOD"] == "POST") {
			if(/* !isFilled("username") && */ !isFilled("email") && !isFilled("pass") && !isFilled("confirm-password")) {
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
			$username = htmlspecialchars(trim($_POST["username"]));
			insertDb("users", [/* "username", */ "email", "password"], [$username, $email, $psw]);
			
			$_SESSION['logged'] = $email;
			relocation("../home.php");
			exit;
		}
	?>
</body>
</html>
