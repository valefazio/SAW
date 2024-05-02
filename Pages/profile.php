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
    <h1>edit prOfile</h1>
        <?php
        include ("../Management/accessControl.php");
        if(!isLogged()) {
            echo "<script> window.location.href = 'Access/login.html';</script>";
            exit;
        }
        $result = getUsers($_SESSION["email"]);
        if ($result->num_rows ==1)
            $row = $result->fetch_assoc();
    ?>
    <div id="form-totale">
    <form action="update_profile.php" method="post" enctype="multipart/form-data" class="profile">
        <div class="row">
        <div class="d-flex flex-column align-items-center text-center p-3 py-5">
            <img id="profilePicture" class="rounded-circle mt-5" src=
                <?php
                    if ($row["profile_picture"])
                        echo "data:image/jpeg;base64," . base64_encode($row["profile_picture"]);
                    else
                        echo "../Management/Images/users/00.jpg";
                ?>
                width="90">
            <input id="fileInput" type="file" name="profile_picture" accept=".jpg, .jpeg, .png" style="display: none;">
        </div>

        <script>
            // Quando l'immagine del profilo viene cliccata, simula un click sull'input del file
            document.getElementById("profilePicture").addEventListener("click", function() {
                document.getElementById("fileInput").click();
            });

            // Quando un file viene selezionato, aggiorna l'immagine del profilo
            document.getElementById("fileInput").addEventListener("change", function(event) {
                var reader = new FileReader();
                reader.onload = function(e) {
                    document.getElementById("profilePicture").src = e.target.result;
                };
                reader.readAsDataURL(event.target.files[0]);
            });
        </script>
            <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" name="firstname" value="<?php echo $row["firstname"]; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="lastname">Last Name</label>
                <input type="text" name="lastname" value="<?php echo $row["lastname"]; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input type="email" name="email" value="<?php echo $row["email"]; ?>" class="form-control">
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input type="password" name="pass" class="form-control">
            </div>
            <button type="submit" id="update-button">Confirm Changes</button>
 
        </div>
    </form>
    </div>
</body>
</html>


<!-- da fare: campi circolari, aggiungere un bottone per eliminare l'account, foto profilo rotonda, form orizzontale con i dati a sinistra della foto profilo -->