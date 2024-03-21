<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Show general</title>
    <link rel="stylesheet" href="../Management/Style/showHouses.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
    <?php
    include "../Management/Database/connection.php";
    ?>
</head>

<body>
    <div id="boxes">
        <?php
        $doors = selectQuery("SELECT D.name, D.address, D.description, D.door_picture_path as 'doorPic', C.name as 'country', D.reviews FROM doors AS D LEFT JOIN countries AS C ON D.country = C.id");
        if ($doors->num_rows > 0) {
            while ($row = $doors->fetch_assoc()) {
                echo "<div class='box'>";
                //reviews
                echo "<img class='heart' src='../Management/Images/heart.png' alt='heart icon'>";
                echo "<img class='doorPic' src='../" . $row["doorPic"] . "' alt='image of the Door'>";
                echo "<div class='box_text'>";
                echo "<h2>" . $row["name"] . "</h2>";
				if($row["reviews"] > 0)
					echo "<p class='reviews'>" . $row["reviews"] . "⭐</p>";
                echo "<p>" . $row["description"] . "</p>";
                echo "<p style='font-size: 13px'><i>" . $row["address"];
                if (!str_contains(strtolower($row["address"]), strtolower($row["country"]))) {
                    echo ", " . $row["country"];
                }
                echo "</i></p>";
                echo "</div></div>";
            }
        }
        ?>
    </div>

    <script>
        var boxes = document.getElementsByClassName("box_text");
        for (var i = 0; i < boxes.length; i++) {
            boxes[i].addEventListener("click", function () {
                window.location.href = "../Pages/door.php?" . i;
            });
        }

        var hearts = document.getElementsByClassName("heart");
        var redHearts = document.getElementsByClassName("red_heart");
        var heartsSet = [hearts.length]
        for (var i = 0; i < hearts.length; i++)
            heartsSet[i] = 0;
        for (var i = 0; i < hearts.length; i++) {
            hearts[i].addEventListener("click", function () {
                if (this.getAttribute("class") == "heart") {
                    this.src = "../Management/Images/heart_red.png";
                    this.setAttribute("class", "heart_red");
                    redHearts = document.getElementsByClassName("red_heart");
					$door = selectDb("doors", ["id"], "name = " + this.parentElement.children[0].innerHTML);
					//if(insertDb("favorites", ["monster", "door"], [$_SESSION["user"], ]))
                } else {
                    this.src = "../Management/Images/heart.png";
                    this.setAttribute("class", "heart");
                }
            });
            hearts[i].addEventListener("mouseover", function () {
                this.src = "../Management/Images/heart_red.png";
                this.setAttribute("style", "transform: scale(1.03);");
            });
            hearts[i].addEventListener("mouseout", function () {
                this.src = "../Management/Images/heart.png";
                this.setAttribute("style", "transform: scale(1)");
            });
        }
    </script>
</body>

</html>