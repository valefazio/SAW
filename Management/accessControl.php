<?php
	if(!session_start()) exit("Troubles starting session.");
	include("Database/connection.php");
	include("utility.php");
    function isLogged() {
        $logged = 0;
		
		if (isset($_SESSION['email'])) {	//utente appena loggato -> sessione attiva
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
		} else header("Location: ../Management/checkAccess.php?login");	/* MANAGE: mandiamo al login??? */
	}
