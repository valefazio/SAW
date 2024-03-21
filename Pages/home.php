<!DOCTYPE html>
<html lang="it">

<head>
	<title>Home</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../Management/Style/home.css">
	<link rel="stylesheet" href="../Management/Style/calendar.css">
	<script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>

<body id="top">
	<nav id="navbar">
		<script>
			$(function () {
				$("#navbar").load("../Management/navbar.html");
			});
		</script>
	</nav>
	<div class="header">
		<div class="text">
			<span style="font-size: 120px;">Find Your Next</span>
			<span style="font-size: 135px;">Victim</span>
		</div>
	</div>
	<div id="door_home">
		<script>
			$(function () {
				$("#door_home").load("../Management/showHouses.php");
			});
		</script>
	</div>
	<div class="website_description">
		<div class="description">
			<h1>What is SCREAM?</h1>
			<p>SCREAM is a website that allows you to find the best places to visit in the world. You can search for
				destinations, filter them by location, number of calendars and reviews, and find the best place for your
				next
				vacation. You can also find the best employees of the month and the most liked destinations by other
				users.</p>
		</div>
		<div class="description">
			<h1>How does it work?</h1>
			<p>SCREAM is a website that allows you to find the best places to visit in the world. You can search for
				destinations, filter them by location, number of calendars and reviews, and find the best place for your
				next
				vacation. You can also find the best employees of the month and the most liked destinations by other
				users.</p>
		</div>
		<div id="footer">
			<script>
				$(function () {
					$("#footer").load("../Management/footer.html");
				});
			</script>
	</div>
</body>

</html>