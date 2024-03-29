<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Show general</title>
	<link rel="stylesheet" href="../Management/Style/showHouses.css">
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	<script src="../Management/scripts/showHousesScripts.js" defer></script>
	<?php
	include "../Management/accessControl.php";
	?>
</head>

<body>
	<div id="boxes">
		<?php
		$i = 0;
		if (isset($_GET['usersFavorites'])) {
			unset($_GET['usersFavorites']);
			$doors = selectQuery(
				"SELECT D.name, D.address, D.door_picture_path as 'doorPic', C.name as 'country', D.reviews 
				FROM doors AS D LEFT JOIN countries AS C ON D.country = C.id 
				WHERE D.reviews >= 2 ORDER BY D.reviews DESC"
			);
		} else if (isset($_GET['saved'])) {
			if (!isLogged())
				header("Location: ../Pages/Access/login.html");
			unset($_GET['saved']);
			$doors = selectQuery(
				"SELECT D.name, D.address, D.door_picture_path as 'doorPic', C.name as 'country', D.reviews 
				FROM doors AS D LEFT JOIN countries AS C ON D.country = C.id 
				WHERE D.address IN (
					SELECT door FROM preferites WHERE monster = '" . $_SESSION['logged'] . "') 
				ORDER BY D.name ASC"
			);
			if ($doors->num_rows == 0) {
				echo "<h3 style='text-align: center'> There are no destinations saved</h3>";
				return;
			}
		} else if (isset($_GET['search'])) {
			unset($_GET['search']);
			//da fare
			if ($doors->num_rows == 0) {
				echo "<h3 style='text-align: center'> No results found</h3>";
				return;
			}
		} else if (isset($_GET['bookings'])) {
			if (!isLogged())
				header("Location: ../Pages/Access/login.html");
			unset($_GET['bookings']);
			$doors = selectQuery(
				"SELECT D.name, D.address, D.door_picture_path as 'doorPic', C.name as 'country', D.reviews 
				FROM doors AS D LEFT JOIN countries AS C ON D.country = C.id 
					RIGHT JOIN calendar AS Ca ON D.address = Ca.door AND Ca.monster = '" . $_SESSION['logged'] . "'
				WHERE Ca.date >= CURDATE()
				ORDER BY Ca.date ASC"
			);
			if ($doors->num_rows == 0) {
				echo "<h3 style='text-align: center'> There are no bookings</h3>";
				return;
			}
		} else
			$doors = selectQuery("SELECT D.name, D.address, D.door_picture_path as 'doorPic', C.name as 'country', D.reviews FROM doors AS D LEFT JOIN countries AS C ON D.country = C.id ORDER BY D.name ASC");




		if ($doors->num_rows > 0) {
			while ($row = $doors->fetch_assoc()) {
				echo "<div class='box'>";


				$kid = selectQuery("SELECT K.name, K.profile_picture_path, K.scaredOf FROM kids AS K JOIN resides AS R ON K.id = R.kid WHERE R.door = '" . $row["address"] . "'");

				$scaredOf = "";
				if ($kid->num_rows > 0) {	//se ci sono bimbi che vivono in quella stanza
					/* HEART - SAVED */
					$heart = "<p class='heart";
					if (isLogged()) {	//se l'utente è loggato controllo se la stanza è nei preferiti
						$res = selectDb("preferites", ["monster", "door"], ["monster", "door"], [$_SESSION['logged'], $row["address"]]);
						if ($res->num_rows > 0)
							$heart .= " heart_red";
					}
					$heart .= "' onclick='hearts(" . strval($i) . ")'>❤</p>";
					echo $heart;

					/* DOOR - image */
					echo "<img class='doorPic' src='../" . $row["doorPic"] . "' alt='image of the Door'>";
					
					/* KIDS - images */
					$kids = 0;
					while ($kiddo = $kid->fetch_assoc()) {
						if ($scaredOf != "" && $kids > 0)
							$scaredOf .= "<br> ";
						$kids++;
						if ($kiddo["profile_picture_path"] == NULL)
							echo "<img class='kid' style=' margin-left: " . $kids * (-50) . "px' 
									src='../Management/Images/00.jpg' title='" . $kiddo["name"] . "'>";
						else
							echo "<img class='kid'  style=' margin-left: " . $kids * (-50) . "px' 
									src='../" . $kiddo["profile_picture_path"] . "' title='" . $kiddo["name"] . "'>";
						$scaredOf .= "<b>" . $kiddo["name"] . "</b> is scared of " . $kiddo["scaredOf"];
					}
				}
				echo "<div class='box_text'>";
				/* NOME STANZA */
				echo "<h2>" . $row["name"] . "</h2>";
				/* REVIEWS */
				if ($row["reviews"] > 0)
					echo "<p class='reviews'>" . $row["reviews"] . "⭐</p>";
				/* KIDS - scared of */
				if ($scaredOf != "")
					echo "<p class='scaredOf'>" . $scaredOf . "</p>";
				/* COUNTRY */
				echo "<p style='font-size: 13px' class='address'><i>" . $row["address"];
				if (!str_contains(strtolower($row["address"]), strtolower($row["country"])))
					echo ", " . $row["country"];
				
				echo "</i></p>";
				echo "</div></div>";
				$i++;
			}
		}
		?>
	</div>
</body>

</html>