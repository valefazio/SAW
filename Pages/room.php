<!DOCTYPE html>
<html lang="en">

<?php
include ("../Management/accessControl.php");
if (!isLogged()) {
	relocation("../Management/checkAccess.php?login");
}
?>

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" type="text/css" href="../Management/Style/room.css">
	<link rel="stylesheet" href="../Management/Style/home.css">
	<link rel="stylesheet" href="../Management/Style/calendarSelect.css">
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
	<script src="../Management/scripts/showHousesScripts.js" defer></script>
</head>

<?php

//funzione che controlla se la stanza è già stata prenotata per quel giorno
function notBooked(string $address, string $date): bool
{
	$res = selectDb("calendar", [], ["door", "date"], [$address, $date]);
	return ($res->num_rows == 0);
}

//
$roomID = selectDb("doors_id", [], ["id"], [$_SERVER['QUERY_STRING']])->fetch_assoc()['address'];
$res = selectDb("doors", [], ["address"], [$roomID]);
if ($res->num_rows != 0) {
	$row = $res->fetch_assoc();
	$name = $row['name'];
	$address = $row['address'];
	$country = $row['country'];
}

$resRoomPicture = selectDb("room_pics", [], ["room_id"], [$roomID]);
if ($resRoomPicture->num_rows != 0) {
	$rowRoomPicture = $resRoomPicture->fetch_assoc();
	$picture = $rowRoomPicture['filename'];
}
?>

<body>
	<nav id="navbar">
		<?php
		include ("../Management/navbar.html");
		?>
	</nav>
	<div id="main">
		<div id="header">
			<div id="RoomName">
				<h1><?php print (strtolower($name)); ?></h1>
			</div>
			<div id="headerbtns">
				<?php
				/* HEART - SAVED */
				$heart = "<p class='heart";
				// controllo se la stanza è nei preferiti e nel caso metto il cuore rosso
				$res = selectDb("preferites", ["monster", "door"], ["monster", "door"], [$_SESSION['email'], $row["address"]]);
				if ($res->num_rows > 0)
					$heart .= " heart_red";
				// aggiungo l'event listener per il click 
				$heart .= "' onclick='hearts(" . strval(0) . ")'>❤</p>";
				echo $heart;
				echo "<p class='address' hidden>" . $address . "</p>";
				?>
				<button id="share">Share</button>
				<script>
					//sharing link system with clipboard API
					document.getElementById("share").addEventListener("click", function () {
						var text = window.location.href;
						navigator.clipboard.writeText(text).then(function () {
							alert("URL copiato negli appunti!");
						}).catch(function () {
							alert("Copia negli appunti fallita!");
						});
					});
				</script>
			</div>
		</div>
		<div id="pictureAndFirst">
			<div id="RoomPicture">
				<img src="<?php print ("../");
				print ($picture); ?>" alt="Room Picture">
			</div>
			<div id="firstArea">
				<h2>DESCRIPTION</h2>
				<div id="RoomAddress">
					<h2>Address</h2>
					<p><?php print ($address); ?></p>
				</div>
				<div id="RoomReviews">
					<h2>Reviews</h2>
					<div id="reviewsBox" style="overflow-y:scroll;">
						<?php
						//want to print all the reviews in column
						$reviews = selectDb("reviews", ["review", "review_text", "monster", "review_date"], ["door"], [$roomID]);
						if ($reviews->num_rows != 0) {
							$review = $reviews->fetch_assoc();
							while ($review) {
								echo "<p>" . $review["review"] . "⭐️,  " . $review["review_text"] . " by <b>" . $review["monster"] . ", " . $review["review_date"] . "</b></p>";
								$review = $reviews->fetch_assoc();
							}
						} else
							print ("No reviews yet");
						?>
					</div>
				</div>
			</div>
		</div>

		<div id="info">
			<div id="RoomInfos">
				<div id="RoomKids">
					<h2>KIDS</h2>
					<?php
					$resKids = selectDb("resides", [], ["door"], [$roomID]);
					$kids = 0;
					$scaredOf = "";
					if ($resKids->num_rows != 0) {
						foreach ($resKids as $kidsHere) {
							echo "<div class='kidContainer'>";
							$kiddo = selectDb("kids", [], ["id"], [$kidsHere['kid']])->fetch_assoc();
							echo "<img class='kid' title='" . $kiddo["name"] . "' alt='image of " . $kiddo["name"] . "'src='../";
							if ($kiddo["profile_picture_path"] == NULL)
								echo "Management/Images/00.jpg'";//>";
							else
								echo $kiddo["profile_picture_path"] . "'";// . "'>";
							if ($kids == 0)
								echo " style='margin-left: 0px'>";
							else
								echo " style='margin-left:" . (($kids) * (80)) . "px; margin-top: -117px; position: absolute;'>";
							?>

							<script>
								var nameTag = document.createElement("p");
								nameTag.innerHTML = "<?php print ($kiddo["name"]); ?>";
								nameTag.classList.add("nameTag");
								var kids = document.getElementsByClassName("kid").length - 1;
								nameTag.style.marginTop = "-30px";
								nameTag.style.marginLeft = (20 + kids * 80) + "px";
								nameTag.style.position = "absolute";
								document.getElementsByClassName("kidContainer")[kids].appendChild(nameTag);
							</script>
							<?php

							$scareQuery = selectQuery("SELECT S.scare FROM kids AS K JOIN scaredOf AS S ON K.id = S.kid WHERE K.name = '" . $kiddo["name"] . "'");
							$scaredOf .= "<b>" . $kiddo["name"] . "</b> is scared of ";
							if ($scareQuery->num_rows > 0) {
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
								$scaredOf .= "nothing<br>";
							$kids++;
							echo "</div>";
						}
						echo "<br>" . $scaredOf;
					} else {
						print ("<p>No kids in this room</p>");
					}
					?>

				</div>
			</div>
			<div id="bookingArea">
				<div id="RoomBooking">
					<h2>BOOKING</h2>
				</div>
				<div id="RoomCalendar">
					<form method="POST" action="">
						<label for="bookingDate">Choose a date:</label>
						<input type="date" id="bookingDate" name="bookingDate" required><br>
						<button type="submit" id="RoomBookButton" name="RoomBookButton">Book</button>
					</form>
					<?php
					if (isset($_POST['RoomBookButton'])) {
						$date = $_POST['bookingDate'];
						if ($date < date("Y-m-d")) {
							alert("You can\'t book a room in the past");
						} else {
							if (notBooked($roomID, $date)) {
								if (insertDb("calendar", ["date", "door", "monster"], [$date, $roomID, $_SESSION['email']])) {
									alert("room booked successfully!");
									relocation("room.php?" . $_SERVER['QUERY_STRING']);
								} else {
									relocation("404.php");
								}
							} else {
								print ("the room  is already booked for that day");
							}
						}
					}
					?>
				</div>
			</div>
			<div id="ReviewArea">
				<h2>REVIEW</h2>
				<?php
				$dates = selectQuery("SELECT date 
									FROM calendar 
									WHERE door = '$roomID' 
									AND monster = '" . $_SESSION['email'] . "' 
									AND date NOT IN (
										SELECT booking_date 
										FROM reviews 
										WHERE door = '$roomID' 
										AND monster = '" . $_SESSION['email'] . "'
									) 
									AND date < CURDATE() 
									ORDER BY date DESC
									");
				if ($dates->num_rows != 0) { ?>
					<form method="POST" action="">
						<label for="review">Leave a rating:</label>
						<select id="review" name="review">
							<option value="1" title="one star">⭐️</option>
							<option value="2" title="two stars">⭐️⭐️</option>
							<option value="3" title="three stars">⭐️⭐️⭐️</option>
							<option value="4" title="four stars">⭐️⭐️⭐️⭐️</option>
							<option value="5" title="five stars">⭐️⭐️⭐️⭐️⭐️</option>
						</select><br>
						<?php
						$numdates = 0;
						if ($dates->num_rows != 0) {
							$rowDates = $dates->fetch_assoc();
							echo "<label for='bookedDates'>Choose a booking to review:</label> <select id='bookedDates' name='bookedDates'>";
							do {
								echo "<option value='" . $rowDates['date'] . "'>" . $rowDates['date'] . "</option>";
								$numdates++;
							} while ($rowDates = $dates->fetch_assoc());
							echo "</select><br>";
						}
						?>
						<label for="comment">Leave a comment:</label>
						<textarea id="comment" name="comment" maxlength="50" required></textarea><br>
						<button id="RoomReviewButton" type="submit" name="RoomReviewButton">Review</button>
					</form>
					<?php
					if (isset($_POST['RoomReviewButton'])) {
						if ($numdates > 0) {
							if (isset($_POST['review'])) {
								$comment = $_POST['comment'];
								$review = $_POST['review'];
								if (isset($_POST['review'])) {
									$comment = $_POST['comment'];
									$review = $_POST['review'];
									if (insertDb("reviews", ["review", "door", "monster", "booking_date", "review_date", "review_text"], [$review, $roomID, $_SESSION['email'], $_POST['bookedDates'], date("Y-m-d"), $comment])) {
										alert("Review left successfully!");
										relocation("room.php?" . $_SERVER['QUERY_STRING']);
									} else {
										relocation("404.php");
									}
								}
							}

						} else {
							print ("There a are no bookings to review");
						}
					}
					?>
				<?php } else
					print ("there are no bookings to review"); ?>
			</div>
		</div>
	</div>
	<?php
	include ("../Management/footer.html");
	?>
</body>

</html>