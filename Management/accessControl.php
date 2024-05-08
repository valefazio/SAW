<?php
	if(!session_start()) exit("Troubles starting session.");
	include("Database/connection.php");
	include("utility.php");
    function isLogged() {
        $logged = 0;
		
		if(isset($_COOKIE['remember-me']) && $_COOKIE['remember-me']) { //utente già loggato dal remember-me
			$cookie = hash("sha256", $_COOKIE['remember-me']);
			$res = selectDb("users", ["email"], ["remember_token"], [$cookie]);
			if ($res->num_rows == 1) {	//cookie di remember-me corrisponde
				$logged = 1;
				if(!isset($_SESSION['email']))	//se non è già presente una sessione attiva setto la variabile di sessione
					$_SESSION['email'] = $res->fetch_assoc()['email'];
			} else {	//cookie remember-me non trovato nel db
				$logged = 0;
			}
		} else if (isset($_SESSION['email'])) {	//utente appena loggato -> sessione attiva
			$logged = 1;
		} else {	//utente non ancora loggato
			$logged = 0;
		}
		return $logged;
    }

	function isAdmin() {
		$res = selectDb("users", ["admin"], ["email"], [$_SESSION['email']]);
			
		if($res) {
			if ($res->num_rows > 0) {
				$row = $res->fetch_assoc();
				if(!$row['admin']) {
					return false;
				} else return true;
			}
		} else header("Location: login.html");	/* MANAGE: mandiamo al login??? */
	}
