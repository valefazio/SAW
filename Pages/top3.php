<!DOCTYPE html>
<html lang="en">

<head>
    <title>Top 3 Impiegati del Mese</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Management/Style/employee.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-1.10.2.js"></script>
</head>

<body>
    <nav id="navbar">
        <script>
            $(function () {
                $("#navbar").load("../Management/navbar.php");
            });
        </script>
    </nav>

    <h1>IMPIEGATI DEL MESE</h1>

    <!-- Le informazioni poi verrano prese dal databse -->
    <div class="employee-card">
        <img src="immagine1.jpg" alt="Foto Profilo John Doe">
        <div class="employee-info">
            <h2>John Doe</h2>
            <p>Punteggio: 95</p>
        </div>
    </div>

    <div class="employee-card">
        <img src="immagine2.jpg" alt="Foto Profilo Jane Smith">
        <div class="employee-info">
            <h2>Jane Smith</h2>
            <p>Punteggio: 90</p>
        </div>
    </div>

    <div class="employee-card">
        <img src="immagine3.jpg" alt="Foto Profilo Michael Johnson">
        <div class="employee-info">
            <h2>Michael Johnson</h2>
            <p>Punteggio: 85</p>
        </div>
    </div>

</body>

</html>

<?php
include ("../Management/accessControl.php");
checkAccess(isLogged()); //Accessibile solo a chi loggato per privacy?



?>