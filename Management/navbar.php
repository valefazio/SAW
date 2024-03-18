<!DOCTYPE html>
<html lang="it">

<head>
	<link rel="stylesheet" href="../Management/Style/navbar.css">
	<script src="../Management/scripts/searchBarScripts.js" defer></script>
	<link rel="stylesheet"
		href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="preconnect" href="https://fonts.googleapis.com">
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>

<body>
	<a href="http://localhost/SAW/Pages/home.php" id="logo">SCREAM</a> <!--ERROR assoluto-->
	<ul class="nav-links">
		<li><a href="top3.php">Employee of the month</a></li>
		<li><a href="#">Favorite destinations</a></li>
	</ul>
	<div class="search-bar">
		<form action="" method="POST">
			<!-- Location -->
			<div class="field">
				<select type="text" id="location" placeholder="Which country">
					<option value="anywhere">Location</option>
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
			<!-- Calendar -->
			<div class="field" style="max-width: 70px; display: contents; align-items: center">
				<input type="text" id="calendar" readonly style="max-width:70px; margin-left: 15px">
				<span class="material-symbols-outlined" style="font-size: 18px">expand_more</span>
			</div>
			<!-- Level: -->
			<div class="field" style="margin-left: 15px;">
				<select type="text" id="level" placeholder="0">
					<option value="any" disabled selected hidden>Scare level</option>
					<option value="0" style="text-align: center">0</option>
					<option value="1" style="text-align: center">1</option>
					<option value="2" style="text-align: center">2</option>
					<option value="3" style="text-align: center">3</option>
					<option value="4" style="text-align: center">4</option>
					<option value="5" style="text-align: center">5</option>
				</select>
			</div>
			<div class="field">
				<button type="submit">
					<p id="eye">O</p>
				</button>
			</div>
		</form>
	</div>
	<!-- <a href="Access/checkAccess.php?login" class="account">Account</a> -->
	<div id="sidebar">
		<script>
			$(function () {
				$("#sidebar").load("../Management/sidebar.php");
			});
		</script>
	</div>
</body>
</html>