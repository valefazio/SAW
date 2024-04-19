<!DOCTYPE html>
<html lang="it">

<?php
include("../Management/utility.php");
include("../Management/Database/connection.php");
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Management/Style/room.css">
    <link rel="stylesheet" href="../Management/Style/home.css">
</head>

<?php
$roomID = "111 Sussex Dr, Ottawa, ON K1A 0A1, Canada";
$res = selectDb("doors", [], ["address"], [$roomID]);
	if ($res->num_rows != 0) {
		$row = $res->fetch_assoc();
        $name = $row['name'];
        $address = $row['address'];
        $country = $row['country'];
        $picture = $row['door_picture_path'];
        $reviews = $row['reviews'];
	}
?>

<body>
    <nav id="navbar">
        <?php
        include ("../Management/navbar.html");
        ?>
    </nav>

    <div id="RoomName">
        <h1><?php print($name); ?></h1>
    </div>
    <?php
    include ("../Management/footer.html");
    ?>

</body>

</html>