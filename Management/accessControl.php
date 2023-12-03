<?php
	if(!session_start()) exit("Troubles starting session.");
    function isLogged() {
        $logged = false;
		
		if(isset($_COOKIE['remember-me']) && $_COOKIE['remember-me']) { //utente già loggato dal remember-me
			$cookie = $_COOKIE['remember-me'];
			$cookie = hash("sha256", $cookie);
			include "../Management/connection.php";
			$res = selectDb("email", "remember_token = '$cookie'");
			if ($res->num_rows > 0) {	//cookie di remember-me corrisponde
				$logged = true;
				if(!isset($_SESSION['logged']))	//se non è già presente una sessione attiva setto la variabile di sessione
					$_SESSION['logged'] = $res->fetch_assoc()['email'];
			} else {	//cookie remember-me non trovato nel db
				$logged = false;
			}
		} else if (isset($_SESSION['logged'])) {	//utente appena loggato -> sessione attiva
			$logged = true;
		} else {	//utente non ancora loggato
			$logged = false;
		}

        return $logged;
    }
?>