<!DOCTYPE html>
<html lang="en">

<head>
    <title>Profile</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Management/Style/profile.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>
    <nav id="navbar">
        <?php
        include ("../Management/navbar.html");
        ?>
    </nav>
    <h1>Profile</h1>
    <?php
        include ("../Management/accessControl.php");

        if(!isLogged()) {
            echo "<script> window.location.href = 'Access/login.php';</script>";
            exit;
        }
        
        
        $result = getUsers($_SESSION["email"]);
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="profile-card">';
                echo '<img class="images" src="data:image/jpeg;base64,' . base64_encode($row["profile_picture"]) . '" alt="Foto Profilo ' . $row["firstname"] . ' ' . $row["lastname"] . '">';
                echo '<div class="profile-info">';
                echo '<h2>' . $row["firstname"] . ' ' . $row["lastname"] . '</h2>';
                echo '<p>Email: ' . $row["email"] . '</p>';
                echo '<p>Recensioni: ' . $row["reviews"] . '</p>';
                echo '</div>';
                echo '</div>';
            }
        } else {
            echo "Nessun risultato trovato";
        }
    ?>
       
 