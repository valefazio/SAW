<!DOCTYPE html>
<html lang="it">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Villa Lovran Mansion</title>
    <link rel="stylesheet" type="text/css" href="../Management/Style/door.css">
    <link rel="stylesheet" href="../Management/Style/home.css">
</head>

<body>
    <?php
    include ("../Management/navbar.html");
    ?>
    <div class="container">
        <div class="gallery">
            <!-- Immagini della villa -->
            <img src="image1.jpg" alt="Villa Lovran Mansion">
            <!-- Aggiungi altre immagini qui -->
        </div>
        <div class="details">
            <h1>Villa Lovran Mansion per un massimo di 15 persone</h1>
            <p>Laurana, Croazia. Intero alloggio: villa</p>
            <p>15 ospiti · 7 camere da letto · 8 letti · 8 bagni</p>
            <div class="rating">
                <p>5.0</p>
                <p>4 recensioni</p>
            </div>
            <div class="host">
                <p>Nome dell'host: Luxoria</p>
                <p>2 anni di esperienza come host</p>
            </div>
            <div class="price">
                <p>1.538 € notte</p>
            </div>
            <div class="booking">
                <p>Check-in</p>
                <input type="date">
                <p>Check-out</p>
                <input type="date">
                <p>Ospiti</p>
                <select>
                    <!-- Opzioni per il numero di ospiti -->
                    <option value="1">1 ospite</option>
                    <!-- Aggiungi altre opzioni qui -->
                </select>
                <button>Prenota</button>
            </div>
        </div>
    </div>
    <?php
    include ("../Management/footer.html");
    ?>
</body>

</html>