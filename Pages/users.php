<html>
<head>
    <meta charset="UTF-8">
    <title>Users</title>
    
    <?php
        include("../Management/navbar.php");
    ?>
</head>
<body>
<?php
    $users = getUsers($_SESSION['logged']);
    if ($users) {
        $usersArray = toArray($users);
        ?>
            <h1>List of allowed users</h1>
            <table>
                <tr>
                    <th>Username</th>
                    <th>Email</th>
                    <th>Admin</th>
                </tr>
        <?php
        foreach ($usersArray as $profile) {
            echo "<tr>";
            echo "<td>" . $profile['username'] . "</td>";
            echo "<td>" . $profile['email'] . "</td>";
            echo "<td>". $profile["admin"]. "</td>";
        }
        echo "</table>";
        echo json_encode($usersArray);
    } else {
        echo "User not found.";
    }
?>
</body>