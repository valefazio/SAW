<!DOCTYPE html>
<html lang="it">

<?php
include ("../Management/utility.php");
include ("../Management/Database/connection.php");
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="../Management/Style/room.css">
    <link rel="stylesheet" href="../Management/Style/home.css">
</head>

<?php
$roomID = "111 Sussex Dr, Ottawa, ON K1A 0A1, Canada";
$res = selectDb("doors", [], ["address"], [$roomID]);
if ($res->num_rows != 0) {
    $row = $res->fetch_assoc();
    $name = $row['name'];
    $address = $row['address'];
    $country = $row['country'];
    $reviews = $row['reviews'];
}

$resKids = selectDb("resides", [], ["door"], [$roomID]);
if ($resKids->num_rows != 0) {
    $rowKids = $resKids->fetch_assoc();
    $kids = $rowKids['kid'];
}

$resKidsInfo = selectDb("kids", [], ["id"], [$kids]);
if ($resKidsInfo->num_rows != 0) {
    $rowKidsInfo = $resKidsInfo->fetch_assoc();
    $kidsName = $rowKidsInfo['name'];
    $kidsPhone = $rowKidsInfo['phone'];
    $kidsPicture = $rowKidsInfo['profile_picture_path'];
}

$resScaredOf = selectDb("scaredOf", [], ["kid"], [$kids]);
if ($resScaredOf->num_rows != 0) {
    $rowScaredOf = $resScaredOf->fetch_assoc();
    $scaredOf = $rowScaredOf['scare'];
}

$resRoomPicture = selectDb("room_pics", [], ["room_id"], [$roomID]);
if ($resRoomPicture->num_rows != 0) {
    $rowRoomPicture = $resRoomPicture->fetch_assoc();
    $picture = $rowRoomPicture['filename'];
}


?>

<body>
    <nav id="navbar">
        <?php
        include ("../Management/navbar.html");
        ?>
    </nav>
    <div id="main">
        <div id="PresentationArea">
            <div id="RoomName">
                <h1><?php print (strtolower($name)); ?></h1>
            </div>
            <div id="RoomAddress">
                <h2><?php print ($address); ?></h2>
            </div>
            <div id="RoomPicture">
                <img src="<?php print ("../");
                print ($picture); ?>" alt="Room Picture">
            </div>
        </div>
        <div id="RoomKids">
            <h2>Kids</h2>
            <p>Here you can find information about the kids</p>
            <p><?php print ("kid name: ");
            print ($kidsName); ?></p>
            <p><?php print ("kid phone number: ");
            print ($kidsPhone); ?></p>
            <p><?php print ("Scared of: ");
            print ($scaredOf); ?></p>
            <img src="<?php print ("../");
            print ($kidsPicture); ?>" alt="Kids Picture">
        </div>
        <div id="bookingArea">
            <div id="RoomDescription">
                <h2>Description</h2>
                <p>Here you can find a description of the room</p>
            </div>
            <div id="RoomReviews">
                <h2>Reviews</h2>
                <p><?php print ($reviews); ?></p>
            </div>
            <div id="RoomButtons">
                <button id="RoomBookButton" onclick="window.location.href='book.php'">Book</button>
                <button id="RoomReviewButton" onclick="window.location.href='review.php'">Review</button>
            </div>
        </div>
    </div>
    <?php
    include ("../Management/footer.html");
    ?>

</body>

</html>