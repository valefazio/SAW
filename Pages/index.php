<!DOCTYPE html>
<html>
<head>
    <title>Pages</title>
    <?php
		include("../Management/navbar.php");
	?>
</head>
<body><main>
	<?php
		for($i = 0; $i < 100; $i++) {
			echo $i . "<br>";
		}
    ?>
</main></body>
</html>