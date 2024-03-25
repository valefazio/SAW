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
		if(isset($_GET['usersFavorites'])){
			unset($_GET['usersFavorites']);
			$doors = selectQuery("SELECT D.name, D.address, D.door_picture_path as 'doorPic', C.name as 'country', D.reviews FROM doors AS D LEFT JOIN countries AS C ON D.country = C.id WHERE D.reviews >= 2 ORDER BY D.reviews DESC");
		}
		else if(isset($_GET['saved'])) {
			if(!isLogged())	header("Location: ../Pages/Access/login.html");
			unset($_GET['saved']);
			$doors = selectQuery("SELECT D.name, D.address, D.door_picture_path as 'doorPic', C.name as 'country', D.reviews FROM doors AS D LEFT JOIN countries AS C ON D.country = C.id WHERE D.address IN (SELECT door FROM preferites WHERE monster = '" . $_SESSION['logged'] . "') ORDER BY D.name ASC");
			if($doors->num_rows == 0) {
				echo "<h3 style='text-align: center'> There are no destinations saved</h3>";
				return;
			}
		} else 
			$doors = selectQuery("SELECT D.name, D.address, D.door_picture_path as 'doorPic', C.name as 'country', D.reviews FROM doors AS D LEFT JOIN countries AS C ON D.country = C.id ORDER BY D.name ASC");




		if ($doors->num_rows > 0) {
			while ($row = $doors->fetch_assoc()) {
				echo "<div class='box'>";
				//echo "<img class='heart' src='../Management/Images/heart.png' alt='heart icon'>";
		
				$heart = "<p class='heart";
				if (isLogged()) {
					$res = selectDb("preferites", ["monster", "door"], ["monster", "door"], [$_SESSION['logged'], $row["address"]]);
					if ($res->num_rows > 0)
						$heart .= " heart_red";
				}
				$heart .= "' onclick='toggle(" . strval($i) . ")'>❤</p>";
				echo $heart;

				$kid = selectQuery("SELECT K.name, K.profile_picture_path, K.scaredOf FROM kids AS K JOIN resides AS R ON K.id = R.kid WHERE R.door = '" . $row["address"] . "'");
				$scaredOf = "";
				if ($kid->num_rows > 0) {
					echo "<img class='doorPic' src='../" . $row["doorPic"] . "' alt='image of the Door'>";
					$kids = 0;
					while ($kiddo = $kid->fetch_assoc()) {
						if($scaredOf != "" && $kids > 0)
							$scaredOf .= "<br> ";
						$kids++;
						if ($kiddo["profile_picture_path"] == NULL)
							echo "<img class='kid' style=' margin-left: " . $kids*(-50) . "px' 
									src='../Management/Images/00.jpg' title='" . $kiddo["name"] . "'>";
						else
							echo "<img class='kid'  style=' margin-left: " . $kids*(-50) . "px' 
									src='../" . $kiddo["profile_picture_path"] . "' title='" . $kiddo["name"] . "'>";
						$scaredOf .= $kiddo["name"] . " is scared of " . $kiddo["scaredOf"];
					}
				}
				echo "<div class='box_text'>";
				echo "<h2>" . $row["name"] . "</h2>";
				if ($row["reviews"] > 0)
					echo "<p class='reviews'>" . $row["reviews"] . "⭐</p>";
				if ($scaredOf != "")
					echo "<p class='scaredOf'>" . $scaredOf . "</p>";
				//aggiungere descrizione paure bimbi fino a tot caratteri
				echo "<p style='font-size: 13px' class='address'><i>" . $row["address"];
				if (!str_contains(strtolower($row["address"]), strtolower($row["country"]))) {
					echo ", " . $row["country"];
				}
				echo "</i></p>";
				echo "</div></div>";
				$i++;
			}
		}
		?>
	</div>

	<script>
		const heart = document.getElementsByClassName('heart');
		function toggle(i) {
			if (!heart[i].classList.contains('heart_red')) {
				$.ajax({
					type: "POST",
					url: "../Management/insertFavourite.php",
					data: { div_n: i, action: 'add', room: heart[i].parentElement.getElementsByClassName("address")[0].innerText },
					success: function (res) {
						if (res == true)
							heart[i].classList.add('heart_red');
						else window.location.href = "../Pages/Access/login.html";
					}
				});
			} else {
				$.ajax({
					type: "POST",
					url: "../Management/insertFavourite.php",
					data: { div_n: i, action: 'remove', room: heart[i].parentElement.getElementsByClassName("address")[0].innerText },
					success: function (res) {
						if (res == true)
							heart[i].classList.remove('heart_red');
						else console.log("Error remove");
					}
				});
			}
		}
	</script>
</body>

</html>