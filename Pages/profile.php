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
            echo "<script> window.location.href = 'Access/login.html';</script>";
            exit;
        }
        $result = getUsers($_SESSION["email"]);
        if ($result->num_rows ==1)
            $row = $result->fetch_assoc();
    ?>
    <form action="update_profile.php" method="post" enctype="multipart/form-data">
    <div class="container rounded bg-white mt-5">
        <div class="row">
            <div class="col-md-4 border-right">
                <div class="d-flex flex-column align-items-center text-center p-3 py-5">
                    <img class="rounded-circle mt-5" src=
                    <?php
                        if ($row["profile_picture"])
                            echo "data:image/jpeg;base64," . base64_encode($row["profile_picture"]);
                        else
                            echo "../Management/Images/users/00.jpg";
                    ?>
                    width="90">
                    <input type="file" name="profile_picture" accept="image/*">
                </div>
            </div>
            <div class="col-md-8">
                <div class="p-3 py-5">
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
                    <button type="submit" id="update-button">Update Profile</button>
                </div>
            </div>
        </div>
    </div>
</form>
</body>
</html>