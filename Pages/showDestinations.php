<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <style>
        .title {
            text-align: center;
            margin-top: 20px;
        }
    </style>
</head>

<body>
    <nav id="navbar">
        <?php
        include ("../Management/navbar.html");
        ?>
    </nav>
    <div id="door_home">
        <?php
        $queryParam = $_SERVER['QUERY_STRING'];
        if ($queryParam === 'usersFavorites') {
			echo "<h1 class='title'>BEST REViEWED DESTinATiOn</h1>";
            $_GET['usersFavorites'] = true;
        } else if ($queryParam === 'saved') {
            echo "<h1 class='title'>YOuR SAVED DESTinATiOn</h1>";
            $_GET['saved'] = true;
        } else if ($queryParam === 'search') {
            echo "<h1  class='title'>SEARcH RESuLTS</h1>";
            $_GET['search'] = true;
        } else if ($queryParam === 'bookings') {
            echo "<h1 class='title'>YOuR BOOkinGs</h1>";
			echo "<p style='text-align: right; margin-right: 30px'>Go to CALENDAR to see the bookings per day</p><br>";
            $_GET['bookings'] = true;
        }
        include ("../Management/showHouses.php");
        ?>
    </div>
    <?php
    include ("../Management/footer.html");
    ?>
</body>

</html>