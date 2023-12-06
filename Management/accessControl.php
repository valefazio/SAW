<?php
	if(!session_start()) exit("Troubles starting session.");
	include "connection.php";
    function isLogged() {
        $logged = 0;
		
		if(isset($_COOKIE['remember-me']) && $_COOKIE['remember-me']) { //utente già loggato dal remember-me
			$cookie = $_COOKIE['remember-me'];
			$cookie = hash("sha256", $cookie);
			$res = selectDb("email", "remember_token = '$cookie'");
			if ($res->num_rows > 0) {	//cookie di remember-me corrisponde
				$logged = 1;
				if(!isset($_SESSION['logged']))	//se non è già presente una sessione attiva setto la variabile di sessione
					$_SESSION['logged'] = $res->fetch_assoc()['email'];
			} else {	//cookie remember-me non trovato nel db
				$logged = 0;
			}
		} else if (isset($_SESSION['logged'])) {	//utente appena loggato -> sessione attiva
			$logged = 1;
		} else {	//utente non ancora loggato
			$logged = 0;
		}

		return $logged;
    }

	function isAdmin() {
		$logged = isLogged();
		//if user is not admin
		$res = selectDb("admin", "email = '$_SESSION[logged]'");
			
		if($res) {
			if ($res->num_rows > 0) {
				$row = $res->fetch_assoc();
				if(!$row['admin']) {
					return false;
				} else return true;
			}
		} else header("Location: login.php");
	}

	function checkAccess() {
		if(isLogged() == 0){
			echo "<script>window.location.href = '../Access/login.php';</script>";
			exit;
		}

		$currentFileName = basename($_SERVER['PHP_SELF']);

		//PAGINE AD ACCESSO RISTRETTO
		$restrictedAccess = ['registration.php', 'users.php'];

		if(in_array($currentFileName, $restrictedAccess) && !isAdmin()) {
			echo "<h1 syle='text-align: center';>Accesso riservato agli amministratori</h1>";
					echo "	<script> setTimeout(function() {
						window.location.href = '../Pages/home.php';
							}, 2000);
						</script>";
					exit;
		}
	}
?>