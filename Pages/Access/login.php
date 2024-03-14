<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
	<link rel="stylesheet" type="text/css" href="../../Management/Style/style.css">
    <link rel="stylesheet" type="text/css" href="../../Management/Style/forms.css">

    <?php
		include("../../Management/accessControl.php");
		if(isLogged()) {
			header("Location: ../index.php");
			exit;
		}
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
				<input type="password" id="pass" name="pass" required><br>
				<input type="checkbox" id="show-pass" onclick="togglePassword()">
				<label for="show-pass" id="show-pass">Mostra Password</label> <br><br>

				<input type="checkbox" id="remember-me" name="remember-me">
				<label for="remember-me" id="remember-me-text">Ricordati di me</label><br>
			</div>
           	<input type="submit" value="Login" id="login-button" disabled>

			<div id="switchForm">
				<br><a href="registration.php">Not registered yet? Sign up here</a>
			</div>
        </form>
	</div>


    <script>
        // Ottieni i riferimenti agli elementi del modulo
        const emailInput = document.getElementById("email");
        const passwordInput = document.getElementById("pass");
        const loginButton = document.getElementById("login-button");

        // Aggiungi un gestore di eventi per verificare se tutti i campi sono stati riempiti
        emailInput.addEventListener("input", toggleLoginButton);
        passwordInput.addEventListener("input", togglePassword);

		<?php
			include("checkFields.js");
		?>
        function toggleLoginButton() {
			checkEmailFormat();
			//checkPasswordFormat();	//DEBUG

            if (emailInput.value !== "" && passwordInput.value !== "") {
                loginButton.removeAttribute("disabled");
            } else {
                loginButton.setAttribute("disabled", "disabled");
            }
        }

		function togglePassword() {	//show password in plain text or not
            var passField = document.getElementById("pass");
            var showPassCheckbox = document.getElementById("show-pass");

            if (showPassCheckbox.checked) {
                passField.type = "text";
            } else {
                passField.type = "password";
            }
			toggleLoginButton();
        }
    </script>

	<?php
		if($_SERVER['REQUEST_METHOD'] === 'POST' && isFilled("email") && isFilled("pass")) {	//ha inserito i dati
			$email = htmlspecialchars($_POST['email']);

			$res = selectDb("users", ["email, password"], "email = '$email'");
			if ($res->num_rows == 0) {
				alert("L\'email o la password non sono corrette", "warning");
				if(session_status() == PHP_SESSION_ACTIVE)
					session_abort();
				header("login.php");
				exit;
			}

			$row = $res->fetch_assoc();
			$password = $_POST['pass'];
			
			if(!password_verify($password, $row['password'])) {
				alert("L\'email o la password non sono corrette", "warning");
				if(session_status() == PHP_SESSION_ACTIVE)
					session_abort();
				header("login.php");
				exit;
			}

			//impostazione variabili di sessione e cookies
			$_SESSION['logged'] = $email;
			if(isset($_POST['remember-me'])) {
				rememberMe($email, $bytes);
				setcookie("remember-me", $bytes, time() + (86400 * 30), "/");
				updateDb("remember_token", hash('sha256', $bytes), "email = '$email'");
				updateDb("remember_token_created_at", "CURRENT_TIMESTAMP", "email = '$email'");
			}

			header("Location: ../index.php");
			exit;
		} else {
			if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit']))
				header("Location: login.php");
			//else wait for data...
		}

		function rememberMe($email, $bytes) {
			$conn = accessDb();
			try {
				$bytes = random_bytes(12);
				$conn->begin_transaction();
			
				updateDb("remember_token", hash('sha256', $bytes), "email = '$email'");
				updateDb("remember_token_created_at", "CURRENT_TIMESTAMP", "email = '$email'");
			
				$conn->commit();
			
				setcookie("remember-me", $bytes, time() + (86400 * 30), "/");
			} catch (Exception $e) {
				// An error occurred, rollback the transaction
				$conn->rollBack();
				echo "Error: " . $e->getMessage();
			}
			$conn->close();
		}
	?>
</body>
</html>
