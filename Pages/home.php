<!DOCTYPE html>
<html lang="it">

<head>
	<title>Home</title>
	<link rel="stylesheet" href="../Management/Style/home.css">
	<link rel="stylesheet" href="../Management/Style/calendar.css">
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
	<script src="../Management/searchBarScripts.js" defer></script>

	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body id="top">
	<div class="header">
		<nav id="navbar">
			<script>
				$(function () {
					$("#navbar").load("../Management/navbar.html");
				});
			</script>
		</nav>
		<div class="text">
			<span style="font-size: 120px;">Find Your Next</span>
			<span style="font-size: 135px;">Victim</span>
		</div>
		<div class="search-bar">
			<form action="" method="POST">
				<div class="field">
					<label for="location">Location</label>
					<select type="text" id="location" placeholder="Which country">
						<option value="anywhere">Anywhere</option>
						<option value="italy">Italy</option>
						<option value="france">France</option>
						<option value="spain">Spain</option>
						<option value="germany">Germany</option>
						<option value="uk">United Kingdom</option>
						<option value="usa">United States</option>
						<option value="japan">Japan</option>
						<option value="china">China</option>
						<option value="russia">Russia</option>
						<option value="australia">Australia</option>
					</select>
				</div>
				<div class="field">
					<label>Night</label>
					<input type="text" id="calendar" placeholder="Add date" readonly></p>
				</div>
				<div class="field" style="min-width: 60px; margin: 0; padding: 0;">
					<label>Level</label><br>
					<div class="level">
						<div class="g"><span class="material-symbols-outlined">remove</span></div>
						<div class="g">
							<input type="text" id="nLevel" placeholder="0" readonly></p>
						</div>
						<div class="g"><span class="material-symbols-outlined">add</span></div>
					</div>
				</div>
				<button type="submit">
					<p id="eye">O</p>
				</button>
			</form>
		</div>
	</div>
	<div id="footer">
		<script>
			$(function () {
				$("#footer").load("../Management/footer.html");
			});
		</script>
	</div>
</body>
<script>
	document.getElementsByTagName("form")[0].addEventListener("submit", function (event) {
		event.preventDefault();
		var location = document.getElementById("location").value;
		var checkin = document.getElementById("calendar").value || "anytime"; //ERROR
		var level = document.getElementById("nLevel").value || "0";
		var url = "http://localhost/SAW/Pages/search.php?location=" + location + "&checkin=" + checkin + "&level=" + level;	//ERROR assoluto
		window.location.href = url;
		return;
	});
</script>

</html>