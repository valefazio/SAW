<!DOCTYPE html>
<html lang"en">

<head>
	<title>Home</title>
	
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<link rel="stylesheet" href="../Management/Style/home.css">
</head>

<body id="top">
	<nav id="navbar">
		<?php
		include ("../Management/navbar.html");
		?>
	</nav>
	<div class="header">
		<p id="text"></p>
	</div>
	<div id="door_home">
		<?php
		include ("../Management/showHouses.php");
		?>
	</div>
	<?php
	include ("../Management/footer.html");
	?>
</body>

<script>
	// Text for typing effect
const text = "Find Your Next Victim";
const typingSpeed = 100; // Typing speed in milliseconds

// Get the text element
const textElement = document.getElementById('text');

// Function to simulate typing effect
function typeText(index) {
    if (index < text.length) {
        textElement.textContent += text.charAt(index);
        index++;
        setTimeout(function() {
            typeText(index);
        }, typingSpeed);
    }
}

// Start the typing effect when the page loads
document.addEventListener('DOMContentLoaded', function() {
    typeText(0);
});

</script>

</html>