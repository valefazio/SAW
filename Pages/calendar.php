<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<link rel="stylesheet" href="../Management/Style/calendar.css">
	<title>Calendar</title>
	<?php
	include "../Management/accessControl.php";
	if(!isLogged())
		header("Location: ../Management/checkAccess.php?login");
	?>
</head>

<body>
	<nav id="navbar">
		<?php
		include ("../Management/navbar.html");
		?>
	</nav>
	
	<div id="eventsCalendar">
		<script src="../Management/scripts/calendarScripts.js"></script>
	</div>

	<?php
	include ("../Management/footer.html");
	?>
</body>
</html>