<!DOCTYPE html>
<html>
<head>
    <title>Pages</title>
</head>
<body>
    <?php
		include("../Management/navbar.php");
        //$logged = isLogged(); viene già eseguito in navbar.php
		if (!$logged) {
			echo "<h1 style='text-align: center'>Welcome user not logged</h1>";
		} else {
			echo "<h1 style='text-align: center'>Welcome user :)</h1>";
		}
	?>
  </body>
</html>