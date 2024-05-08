<!DOCTYPE html>
<html>

<head>
	<title>404 Page Not Found</title>

	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>
	<nav id="navbar">
		<?php
		include ("../Management/navbar.html");
		?>
	</nav>
	<div id="error" style="text-align: center;">
		<h1>404 Page Not Found</h1>
		<p>The page you are looking for could not be found.</p>
	</div>
	<?php
	include ("../Management/footer.html");
	?>
</body>

<script>
	const footerElement = document.querySelector("footer");
	if(window.getComputedStyle(footerElement).getPropertyValue("position") === "fixed") {
		document.getElementById("error").style.paddingTop = window.innerHeight / 2 - footerElement.clientHeight + "px";
	}
</script>

</html>