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
	<div class="header">
		<nav id="navbar">
			<script>
				$(function () {
					$("#navbar").load("../Management/navbar.php");
				});
			</script>
		</nav>
		<div class="text">
			<span style="font-size: 120px;">Find Your Next</span>
			<span style="font-size: 135px;">Victim</span>
		</div>
		<!-- <div class="rectangles">
			<div class="rectangle" onclick="location.href='#'">
				<h2>Most liked destinations</h2>
				<img class="foto-box" src="../Management/Images/stars.png" alt="Best reviews">
			</div>
			<div class="rectangle" onclick="location.href='#'">
				<h2>Inspire me</h2>
				<img class="foto-box" src="../Management/Images/light-bulb.png" alt="idea">
			</div>
			<div class="rectangle" onclick="location.href='#'">
				<h2>Employee of the Month</h2>
				<img class="foto-box" src="../Management/Images/coccarda.png" alt="Employee of the month cockade">
			</div>
		</div> -->
	</div>
	<div class="website_description">
		<div class="description">
			<h1>What is SCREAM?</h1>
			<p>SCREAM is a website that allows you to find the best places to visit in the world. You can search for
				destinations, filter them by location, number of calendars and reviews, and find the best place for your next
				vacation. You can also find the best employees of the month and the most liked destinations by other
				users.</p>
		</div>
		<div class="description">
			<h1>How does it work?</h1>
			<p>SCREAM is a website that allows you to find the best places to visit in the world. You can search for
				destinations, filter them by location, number of calendars and reviews, and find the best place for your next
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