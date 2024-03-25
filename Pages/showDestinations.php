<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
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
        if ($queryParam === 'usersFavorites')
            $_GET['usersFavorites'] = true;
        else if ($queryParam === 'saved')
            $_GET['saved'] = true;
        include ("../Management/showHouses.php");
        ?>
    </div>
    <?php
    include ("../Management/footer.html");
    ?>
</body>

</html>