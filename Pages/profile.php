<?php
	include("../Management/navbar.php");
    // Get the user's profile information from the database
    include "../Management/connection.php";
    $profileData = getUserProfileData($_SESSION['logged']);

    // Display the profile information
?>
<!DOCTYPE html>
<html>
<head>
    <title>Profile Page</title>
</head>
<body>
    <?php
        // Note: Removed redundant assignment to $profileData
        if ($profileData) {
            foreach ($profileData as $profile) {
    ?>
                <h1>Welcome, <?php echo $profile['username']; ?></h1>
                
                <h2>Profile Information</h2>
                <p>Name: <?php echo $profile['username']; ?></p>
                <p>Email: <?php echo $profile['email']; ?></p>
    <?php
            }
        } else {
            echo "User not found.";
        }
    ?>
</body>
</html>
