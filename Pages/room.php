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
    <link rel="stylesheet" href="../Management/Style/calendarSelect.css">
    <link rel="stylesheet"
        href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200" />
</head>

<?php

$roomID = selectDb("doors_id", [], ["id"], [$_SERVER['QUERY_STRING']])->fetch_assoc()['address'];
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
    for ($i = 0; $i < $resKidsInfo->num_rows; $i++) {
        $kidsName[$i] = $rowKidsInfo['name'];
        $kidsPhone[$i] = $rowKidsInfo['phone'];
        $kidsPicture[$i] = $rowKidsInfo['profile_picture_path'];
    }
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
        <div id="header">
            <div id="RoomName">
                <h1><?php print (strtolower($name)); ?></h1>
            </div>
            <div id="headerbtns">
                <button id="save" onclick="window.location.href='Save.php'">Save</button>
                <button id="share" onclick="window.location.href='Share.php'">Share</button>
            </div>
        </div>
        <div id="RoomPicture">
            <img src="<?php print ("../");
            print ($picture); ?>" alt="Room Picture">
        </div>
        <div id="info">
            <div id="RoomInfos">
                <div id="firstArea">
                    <div id="RoomAddress">
                        <h2><?php print ($address); ?></h2>
                    </div>
                    <div id="RoomReviews">
                        <h2>Reviews</h2>
                        <p><?php print ($reviews); ?></p>
                    </div>
                    <div id="RoomDescription">
                        <h2>Description</h2>
                        <p>Here you can find a description of the room</p>
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
            </div>
            <div id="bookingArea">
                <div id="RoomBooking">
                    <h2>Booking</h2>
                    <p>Here you can find information about the booking</p>
                </div>
                <div id="RoomCalendar">
                    <div class="field" style="max-width: 70px; display: contents; align-items: center">
                        <input type="text" id="calendar" readonly style="max-width:70px; margin-left: 15px"
                            name="calendar">
                        <span class="material-symbols-outlined" id="calendar_arrow"
                            style="font-size: 18px">expand_more</span>
                    </div>
                    <button id="RoomBookButton" onclick="window.location.href='book.php'">Book</button>
                    <button id="RoomReviewButton" onclick="window.location.href='review.php'">Review</button>
                </div>
            </div>
        </div>
    </div>
    <?php
    include ("../Management/footer.html");
    ?>
</body>

</html>