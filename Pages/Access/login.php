<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
	<link rel="stylesheet" type="text/css" href="../../Management/Style/style.css">
    <link rel="stylesheet" type="text/css" href="../../Management/Style/forms.css">

    <?php
		include("../../Management/accessControl.php");
		include("../../Management/utility.php");
	?>
</head>
<body>
	<div id="form-sfondo">
        <form action="" method="POST">
			<div id="form-dati">
        		<h1>Login</h1>
				<label for="email">Email:</label><br>
				<input type="email" id="email" name="email" required><br><br>

				<label for="pass">Password:</label><br>
				<input type="password" id="pass" name="pass" required><br><br>

				<input type="checkbox" id="remember-me" name="remember-me">
				<label for="remember-me" id="remember-me-text"> Remember me</label><br><br>
			</div>
           	<input type="submit" value="Login" id="login-button" disabled>

			<div id="switchForm">
				<br><a href="registration.php">Not registered yet? Sign up here</a>
			</div>
        </form>
	</div>
</body>
</html>


    <script>
        // Ottieni i riferimenti agli elementi del modulo
        const emailInput = document.getElementById("email");
        const passwordInput = document.getElementById("pass");
        const loginButton = document.getElementById("login-button");

        // Aggiungi un gestore di eventi per verificare se tutti i campi sono stati riempiti
        passwordInput.addEventListener("input", toggleLoginButton);
        emailInput.addEventListener("input", toggleLoginButton);

        function toggleLoginButton() {
            if (emailInput.value !== "" && passwordInput.value !== "") {
                loginButton.removeAttribute("disabled");
            } else {
                loginButton.setAttribute("disabled", "disabled");
            }
        }
    </script>

	<?php
		if(isLogged()) {
			header("Location: ../index.php");
			exit;
		}
		if($_SERVER['REQUEST_METHOD'] === 'POST' && isFilled("email") && isFilled("pass")) {	//ha inserito i dati
			$email = htmlspecialchars($_POST['email']);
			$password = $_POST['pass'];

			$res = selectDb("email, password", "email = '$email'");
			if ($res->num_rows == 0) {
				alert("Email or password incorrect.");
				if(session_status() == PHP_SESSION_ACTIVE)
					session_abort();
				timerRelocation("login.php");
			}
			$row = $res->fetch_assoc();
			if(!password_verify($password, $row['password'])) {
				alert("Email or password incorrect.");
				if(session_status() == PHP_SESSION_ACTIVE)
					session_abort();
				timerRelocation("login.php");
			}
			$_SESSION['logged'] = $email;
			if(isset($_POST['remember-me'])) {
				$bytes = random_bytes(12);
				setcookie("remember-me", $bytes, time() + (86400 * 30), "/");
				$cookie = hash("sha256", $bytes);
				updateDb("remember_token", "'$cookie'", "email = '$email'");
				updateDb("remember_token_created_at", "CURRENT_TIMESTAMP", "email = '$email'");
			}
			header("Location: ../index.php");
			exit;
		} else {
			if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit']))
				header("Location: login.php");
			//else wait for data...
		}
	?>
</body>
</html>
