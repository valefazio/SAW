<!DOCTYPE html>
<html lang="en">

<head>
    <title>Top 3 Impiegati del Mese</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Management/Style/employee.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>
<body>
<nav id="navbar">
        <?php
            include("../Management/navbar.html");
        ?>
    </nav>
<h1>IMPIEGATI DEL MESE</h1>


</body>
</html>

<?php
    include("../Management/accessControl.php");
    
    /*if(!isLogged()) {
        echo "<script> window.location.href = 'Access/login.php';</script>";
        exit;
    } //Accessibile solo a chi loggato per privacy?
    */

    // Query per ottenere i top 3 impiegati
    $conn = accessDb();
    $sql = "SELECT * FROM users ORDER BY reviews DESC LIMIT 3";
    $result = $conn->query($sql);

    // Generazione dei card dei dipendenti
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            echo '<div class="employee-card">';
            echo '<img src="data:image/jpeg;base64,' . base64_encode($row["profile_picture"]) . '" alt="Foto Profilo ' . $row["firstname"] . ' ' . $row["lastname"] . '">';
            echo '<div class="employee-info">';
            echo '<h2>' . $row["firstname"] . ' ' . $row["lastname"] . '</h2>';
            echo '<p>Punteggio: ' . $row["reviews"] . '</p>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo "Nessun risultato trovato";
    }
?>
