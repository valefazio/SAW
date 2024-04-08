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
        echo "<script> window.location.href = 'Access/login.html';</script>";
        exit;
    }
        $result = getUsers($_SESSION["email"]);
        if ($result->num_rows ==1){
            $row = $result->fetch_assoc();
    ?>
        <div class="container rounded bg-white mt-5">
            <div class="row">
                <div class="col-md-4 border-right">
                    <div class="d-flex flex-column align-items-center text-center p-3 py-5"><img class="rounded-circle mt-5" src=
                    <?php
                        echo "data:image/jpeg;base64," . base64_encode($row["profile_picture"]);
                    ?>
                    width="90"><span class="font-weight-bold">
                    <?php
                        echo $row["firstname"] . " " . $row["lastname"];
                    ?>
                    </span><span class="text-black-50">
                    <?php
                        echo $row["email"];
                    ?>
                    </span></div>
                </div>
                <div class="col-md-8">
                    <div class="p-3 py-5">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h6 class="text-right">Edit Profile</h6>
                        </div>
                        <div class="row mt-2">
                            <div class="col-md-6"><input type="text" class="form-control" placeholder="first name" value=
                            <?php
                                echo $row["firstname"];
                            ?>
                            ></div>
                            <div class="col-md-6"><input type="text" class="form-control" value=
                            <?php
                                echo $row["lastname"];
                            ?>
                        ></div>
                        </div>
                        <div class="row mt-3">
                            <div class="col-md-6"><input type="text" class="form-control" placeholder="Email" value=
                            <?php
                                echo $row["email"];
                            ?>
                            ></div>
                        </div>
                        <div class="mt-5 text-right"><button class="btn btn-primary profile-button" type="button">Save Profile</button></div>
                    </div>
                </div>
            </div>
        </div>
<?php
        }
        include ("../Management/footer.html");

?>    


