<!DOCTYPE html>
<html lang="en">
	<link rel="stylesheet" href="../Management/Style/sidebar.css">
	<script src="../Management/scripts/sideBarScripts.js" defer></script>
	<link href="https://fonts.googleapis.com/icon?family=Material+Icons+Outlined" rel="stylesheet" />
	<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
	<link
		href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
		rel="stylesheet">
<body>
    <ul id="bar">
        <li>
            <span class="material-icons-outlined clickable" onclick="affixColumnBar()" id="menu"
                title="affix column bar">
                account_circle
            </span>
            <ul id="column"></ul>
        </li>
    </ul>

    <?php
    include "accessControl.php";
    if(isLogged()) {
        echo "<script>createNewElement('../Pages/profile.php', 'manage_accounts', 'Profile');</script>";
        echo "<script>createNewElement('../Pages/showDestinations.php?bookings', 'door_front', 'Your bookings');</script>";
        echo "<script>createNewElement('../Pages/showDestinations.php?saved', 'favorite', 'Saved');</script>";
        echo "<script>createNewElement('../Pages/calendar.php', 'calendar_month', 'Calendar');</script>";
        echo "<script>createNewElement('../Pages/Access/logout.php', 'logout', 'Logout');</script>";
    } else {
        echo "<script>createNewElement('../Pages/Access/login.html', 'login', 'Login');</script>";
        echo "<script>createNewElement('../Pages/Access/registration.html', 'add_box', 'Register');</script>";
    }
    ?>

</body>
</html>