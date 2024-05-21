<!DOCTYPE html>
<html>

<head>
    <title>Profile</title>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="../Management/Style/profile.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="../Management/scripts/checkFields.js"></script>
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
    if (!isLogged()) {
        echo "<script> window.location.href = 'login.html';</script>";
        exit;
    }
    $result = getUsers($_SESSION["email"]);
    if ($result->num_rows == 1)
        $row = $result->fetch_assoc();
    ?>
    <div id="form-totale" class="profile-container">
        <form action="update_profile.php" method="post" enctype="multipart/form-data" class="profile">
            <div class="ProfilePicture">
                <img id="profilePicture" class="rounded-circle mt-5" src=<?php
                if ($row["profile_picture"])
                    echo "data:image/jpeg;base64," . base64_encode($row["profile_picture"]);
                else
                    echo "../Management/Images/users/00.jpg";
                ?> width="90">
                <input id="fileInput" type="file" name="profile_picture" accept=".jpg, .jpeg, .png"
                    style="display: none;">
            </div>
			
            <div class="form-group">
                <label for="firstname">First Name</label>
                <input type="text" name="firstname" id="firstname" value="<?php echo $row["firstname"]; ?>"
                    class="form-control" required>
                <label for="lastname">Last Name</label>
                <input type="text" name="lastname" id="lastname" value="<?php echo $row["lastname"]; ?>"
                    class="form-control" required>
                <label for="email">Email</label>
                <input type="email" name="email" id="email" value="<?php echo $row["email"]; ?>" 
                    class="form-control" required>
                <label for="password">Password
                    <span class="help"
                        title="La password deve contenere almeno 8 caratteri, di cui almeno una lettera maiuscola, una minuscola e un numero">
                        help_outline
                    </span>
                </label>
                <input type="password" name="pass" id="pass" class="form-control">
                <input type="checkbox" id="show-pass" onclick="togglePassword()" style="width:10%"> Show Password
                <div class="button-container">
                    <button type="submit" id="update-button" style="cursor: pointer">Confirm Changes</button>
                    <button type="button" id="delete-button" style="cursor: pointer">Delete Account</button>
                </div>
            </div>
        </form>
    </div>
</body>

<script>

    // Quando l'immagine del profilo viene cliccata, simula un click sull'input del file
    document.getElementById("profilePicture").addEventListener("click", function () {
        document.getElementById("fileInput").click();
    });

    // Quando un file viene selezionato, aggiorna l'immagine del profilo
    document.getElementById("fileInput").addEventListener("change", function (event) {
        var reader = new FileReader();
        reader.onload = function (e) {
            document.getElementById("profilePicture").src = e.target.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    });

    document.getElementById("delete-button").addEventListener("click", function () {
        if (!confirm("Are you sure you want to delete your account?")) {
            event.preventDefault();
        }
        else {
            $.ajax({
			type: "POST",
			url: "../Management/profileUtility.php",
			data: {},
			success: function (res) {
				if (res == true)
                    window.location.href = "../Management/delete_profile.php";
				else console.log("Error remove");   //ERROR
			}
		});
        }
    });

    const firstnameInput = document.getElementById("firstname");
    const lastnameInput = document.getElementById("lastname");
    const emailInput = document.getElementById("email");
    const passwordInput = document.getElementById("pass");
    const updateButton = document.getElementById("update-button");

    // Aggiungi un gestore di eventi per verificare se tutti i campi sono stati riempiti
    firstnameInput.addEventListener("input", toggleUpdateButton);
    lastnameInput.addEventListener("input", toggleUpdateButton);
    emailInput.addEventListener("input", toggleUpdateButton);
    passwordInput.addEventListener("input", toggleUpdateButton);

    function toggleUpdateButton() {
        checkEmailFormat();

		/* if(passwordInput.value !== "") {
        	checkPasswordFormat();
			passwordInput.setAttribute("required", "required");
            fieldsToCheck.push(passwordInput);
		} */

        if (firstnameInput.value !== "" && lastnameInput.value !== ""/*  && passwordInput.value !== "" */ && emailInput.value !== "")
            updateButton.removeAttribute("disabled");
        else
            updateButton.setAttribute("disabled", "disabled");
        
    }

    /* function togglePassword() {	//show password in plain text or not
        var passField = document.getElementById("pass");
        var showPassCheckbox = document.getElementById("show-pass");

        if (showPassCheckbox.checked) {
            passField.type = "text";
        } else {
            passField.type = "password";
        }
        toggleUpdateButton();
    } */
</script>

<?php
    include ("../Management/footer.html");
?>

</html>