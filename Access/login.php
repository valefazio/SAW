<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="../Management/style.css">
</head>
<body id="form-sfondo">
    <div id="form">
        <form action="" method="POST">
			<div id="form-dati">
        		<h1>Login</h1>
				<label for="email">Email:</label>
				<input type="email" id="email" name="email" required><br><br>

				<label for="pass">Password:</label>
				<input type="password" id="pass" name="pass" required><br><br>

				<input type="checkbox" id="remember-me" name="remember-me">
				<label for="remember-me" id="remember-me-text"> Remember me</label><br><br>
			</div>
           	<input type="submit" value="Login" id="login-button" disabled>

			<div style="text-align: center; margin: -4% 0 4% 0">
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
		//SESSIONE
		if(!session_start()) exit("Troubles starting session.");
		
		if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email']) && isset($_POST['pass'])) {	//ha inserito i dati
			$email = htmlspecialchars($_POST['email']);
			$password = $_POST['pass'];

			include "../Management/connection.php";
			$res = selectDb("email, password", "email = '$email'");
			if ($res->num_rows == 0) {
				echo "<script>alert('User not found')</script>";
				if(session_status() == PHP_SESSION_ACTIVE)
					session_abort();
				echo "	<script> setTimeout(function() {
							window.location.href = 'login.php';
							}, 2000);
						</script>";
				exit;
			}
			$row = $res->fetch_assoc();
			if (!password_verify($password, $row['password'])) {
				echo "<script>alert('Incorrect password')</script>";
				if(session_status() == PHP_SESSION_ACTIVE)
					session_abort();
				echo "	<script> setTimeout(function() {
							window.location.href = 'login.php';
							}, 2000);
						</script>";
				exit;
			}
			$_SESSION['logged'] = $email;
			if(isset($_POST['remember-me'])) {
				$bytes = random_bytes(12);
				setcookie("remember-me", $bytes, time() + (86400 * 30), "/");
				$cookie = hash("sha256", $bytes);
				updateDb("remember_token", "'$cookie'", "email = '$email'");
				updateDb("remember_token_created_at", "CURRENT_TIMESTAMP", "email = '$email'");
			}
			
			header("Location: ../Pages/index.php");
			exit;

		} else {
			if($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['submit']))
				header("Location: login.php");
			//else wait for data...
		}
	?>
</body>
</html>
