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
			$query = "SELECT D.name, D.address, D.door_picture_path as 'doorPic', C.name as 'country', D.reviews 
				FROM doors AS D LEFT JOIN countries AS C ON D.country = C.id 
				WHERE D.reviews >= 2 ORDER BY D.reviews DESC";
			try {
				$doors = selectQuery($query);
			} catch (mysqli_sql_exception $e) {
				if ($e->getCode() == 1055) {
					// Handle the exception
					header("Location: ../Pages/404.php");
				} else {
					throw $e;
				}
			}
		} else if (isset($_GET['saved'])) {
			if (!isLogged())
				header("Location: ../Pages/Access/login.html");
			unset($_GET['saved']);
			$query = "SELECT D.name, D.address, D.door_picture_path as 'doorPic', C.name as 'country', D.reviews 
				FROM doors AS D LEFT JOIN countries AS C ON D.country = C.id 
				WHERE D.address IN (
					SELECT door FROM preferites WHERE monster = '" . $_SESSION['email'] . "') 
				ORDER BY D.name ASC";
			try {
				$doors = selectQuery($query);
			} catch (mysqli_sql_exception $e) {
				if ($e->getCode() == 1055) {
					// Handle the exception
					header("Location: ../Pages/404.php");
				} else {
					throw $e;
				}
			}
			if ($doors->num_rows == 0) {
				echo "<h3 style='text-align: center'> There are no destinations saved</h3>";
				return;
			}
		} else if (isset($_GET['search'])) {
			unset($_GET['search']);
			$query = "SELECT DISTINCT D.name, D.address, D.door_picture_path as 'doorPic', C.name as 'country', D.reviews 
						FROM doors AS D 
						LEFT JOIN countries AS C ON D.country = C.id 
						JOIN resides AS R ON D.address = R.door 
						JOIN kids AS K ON R.kid = K.id ";
			if (isset($_POST['location']) || isset($_POST['calendar']) || isset($_POST['level'])) {
				$query .= " WHERE ";
				$ands = false;
				if (isset($_POST['location'])) {
					$query .= "C.name = '" . strtolower($_POST['location']) . "'";
					$ands = true;
				}
				if (isset($_POST['calendar'])) {
					if ($ands)
						$query .= " AND ";
					else
						$ands = true;
					$query .= "D.address NOT IN (SELECT DISTINCT door FROM calendar WHERE calendar.date = STR_TO_DATE('" . $_POST['calendar'] . "', '%d/%m/%Y') AND calendar.door = D.address)";
					$ands = true;
				}
				if (isset($_POST['level'])) {
					if ($ands)
						$query .= " AND ";
					$levelScare = array(5, 4, 3, 2, 1, 0);
					$query .= "(SELECT COUNT(*) FROM scaredOf WHERE scaredOf.kid = K.id) = " . $levelScare[intval($_POST['level'])];
				}
			}

			$query .= " ORDER BY D.name ASC";
			try {
				$doors = selectQuery($query);
			} catch (mysqli_sql_exception $e) {
				if ($e->getCode() == 1055) {
					// Handle the exception
					header("Location: ../Pages/404.php");
				} else {
					throw $e;
				}
			}
			if ($doors->num_rows == 0) {
				echo "<h3 style='text-align: center'> No results found</h3>";
				return;
			}
		} else if (isset($_GET['bookings'])) {
			if (!isLogged())
				header("Location: ../Pages/Access/login.html");
			unset($_GET['bookings']);
			$query = "SELECT D.name, D.address, D.door_picture_path as 'doorPic', C.name as 'country', D.reviews 
				FROM doors AS D 
				LEFT JOIN countries AS C ON D.country = C.id 
				JOIN (
					SELECT Ca.door, MIN(Ca.date) AS min_date
					FROM calendar AS Ca 
					WHERE Ca.monster = '" . $_SESSION['email'] .
					 "' AND Ca.date >= CURDATE()
					GROUP BY Ca.door
				) AS CaDistinct ON D.address = CaDistinct.door
				ORDER BY CaDistinct.min_date ASC";
			try {
				$doors = selectQuery($query);
			} catch (mysqli_sql_exception $e) {
				if ($e->getCode() == 1055) {
					// Handle the exception
					header("Location: ../Pages/404.php");
				} else {
					throw $e;
				}
			}
			if ($doors->num_rows == 0) {
				echo "<h3 style='text-align: center'>There are no bookings</h3>";
				return;
			}
		} else {
			$query = "SELECT D.name, D.address, D.door_picture_path as 'doorPic', C.name as 'country', D.reviews FROM doors AS D LEFT JOIN countries AS C ON D.country = C.id ORDER BY D.name ASC";
			try {
				$doors = selectQuery($query);
			} catch (mysqli_sql_exception $e) {
				if ($e->getCode() == 1055) {
					// Handle the exception
					header("Location: ../Pages/404.php");
				} else {
					throw $e;
				}
			}
		}


		/* DISPLAY ROOMS */
		if ($doors->num_rows > 0) {
			while ($row = $doors->fetch_assoc()) {
				echo "<div class='box'>";
				$kid = selectQuery("SELECT K.name, K.profile_picture_path FROM kids AS K JOIN resides AS R ON K.id = R.kid WHERE R.door = '" . $row["address"] . "'");
				if ($kid->num_rows > 0) {	//se ci sono bimbi che vivono in quella stanza
					$scaredOf = "";

					/* HEART - SAVED */
					$heart = "<p class='heart";
					if (isLogged()) {	//se l'utente è loggato controllo se la stanza è nei preferiti
						$res = selectDb("preferites", ["monster", "door"], ["monster", "door"], [$_SESSION['email'], $row["address"]]);
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
						$kids++;
						if ($kiddo["profile_picture_path"] == NULL)
							echo "<img class='kid' style=' margin-left: " . $kids * (-50) . "px' 
									src='../Management/Images/00.jpg' title='" . $kiddo["name"] . "' alt='image of " . $kiddo["name"] . "'>";
						else
							echo "<img class='kid'  style=' margin-left: " . $kids * (-50) . "px' 
									src='../" . $kiddo["profile_picture_path"] . "' title='" . $kiddo["name"] . "' alt='image of " . $kiddo["name"] . "'>";
						$scareQuery = selectQuery("SELECT S.scare FROM kids AS K JOIN scaredOf AS S ON K.id = S.kid WHERE K.name = '" . $kiddo["name"] . "'");
						if ($scareQuery->num_rows > 0) {
							$scaredOf .= $kiddo["name"] . " is scared of ";
							$scare = $scareQuery->fetch_assoc();
							while ($scare) {
								$scaredOf .= $scare["scare"];
								$scare = $scareQuery->fetch_assoc();
								if ($scare)
									$scaredOf .= ", ";
								else
									$scaredOf .= "<br>";
							}
						} else
							$scaredOf .= $kiddo["name"] . " is scared of nothing<br>";

						/* LEVEL */
						$query = "SELECT COUNT(S.scare) as 'level' FROM kids AS K LEFT JOIN scaredOf AS S ON K.id = S.kid WHERE K.name = '" . $kiddo["name"] . "' GROUP BY K.name";
						$level = selectQuery($query);
						if ($level->num_rows > 0) {
							$level = $level->fetch_assoc();
							switch ($level["level"]) {
								case 5:
								case 4:
									echo "<p class='level' title='level: Easy' style=' margin-left: " . (250) + $kids * (-50) . "px' >🟢</p>";
									break;
								case 3:
								case 2:
									echo "<p class='level' title='level: Medium' style=' margin-left: " . (250) + $kids * (-50) . "px' >🟡</p>";
									break;
								case 1:
								case 0:
									echo "<p class='level' title='level: Hard' style=' margin-left: " . (250) + $kids * (-50) . "px' >🔴</p>";
									break;
							}
						}
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

				if (($idQuery = selectDb("doors_id", ["id"], ["address"], [$row["address"]])) == null)
					echo "<script>window.location.href = '../Pages/404.php';</script>";
				$row_id = $idQuery->fetch_assoc();
				?>
				<script>
					document.getElementsByClassName('box_text')[<?php echo $i; ?>].addEventListener('click', function () {
						window.location.href = 'room.php?' + '<?php echo $row_id['id']; ?>';
					});
					document.getElementsByClassName('doorPic')[<?php echo $i; ?>].addEventListener('click', function () {
						window.location.href = 'room.php?' + '<?php echo $row_id['id']; ?>';
					});
				</script>
				<?php
				echo "</div></div>";

				$i++;
			}
		}
		?>
	</div>
</body>

</html>