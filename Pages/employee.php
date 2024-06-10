<!DOCTYPE html>
<html lang="en">

<head>
    <title>Employees of the month</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Management/Style/employee.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

    <body>
        <nav id="navbar">
            <?php
            include ("../Management/navbar.html");
            ?>
        </nav>
        <h1>eMPlOyees Of the mOnth</h1>

    <div class="employee-box">
        <?php
        include ("../Management/accessControl.php");

        /*if(!isLogged()) {
            echo "<script> window.location.html = 'login.php';</script>";
            exit;
        } //Accessibile solo a chi loggato per privacy?
        */

        // Query per ottenere i top 3 impiegati
        $conn = accessDb();
        $sql = "SELECT * FROM users ORDER BY reviews DESC LIMIT 3";
        $result = $conn->query($sql);
        $i = 1;

        // Generazione dei card dei dipendenti
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo '<div class="employee-card">';
                if ($i == 1) {
                    echo '<img src="../Management/Images/gold.png" alt="#1" class="medals">';
                } else if ($i == 2) {
                    echo '<img src="../Management/Images/silver.png" alt="#2" class="medals">';
                } else {
                    echo '<img src="../Management/Images/bronze.png" alt="#3" class="medals">';
                }
                if ($row["profile_picture"]) {
                    echo '<img class="images" src="data:image/jpeg;base64,' . base64_encode($row["profile_picture"]) . '" alt="Foto profilo">';
                } else {
                    echo '<img class="images" src="../Management/Images/users/00.jpg" alt="Default Profile Picture">';
                }
                echo '<div class="employee-info">';
                echo '<h2>' . $row["firstname"] . ' ' . $row["lastname"] . '</h2>';
                echo '<p>Punteggio: ' . $row["reviews"] . '</p>';
                echo '</div>';
                echo '</div>';
                $i++;
            }
        } else {
            echo "Nessun risultato trovato";
        }
        ?>
    </div>

    <?php
    include ("../Management/footer.html");
    ?>

</body>

</html>