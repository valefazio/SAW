<?php
header('Content-Type: application/json');
include "accessControl.php";
if($_POST['opt'] == "grid") {
	$res = selectWithFinalConditions("calendar", [], ["monster", "date"], [$_SESSION["email"], $_POST["date"]], "ORDER BY date");

	$events = [];
	while($row = $res->fetch_assoc()) {
		$doors = selectDb("doors", ["name"], ["address"], [$row["door"]]);
		$door = $doors->fetch_assoc();
		$events[] = [
			'name' => $door['name'],
			'door' => $row['door'],
			'date' => $row['date']
		];
	}
	echo json_encode($events);
} else {
	$res = selectDb("calendar", [], ["monster"], [$_SESSION["email"]]);
	$events = [];
	while($row = $res->fetch_assoc()) {
		$doors = selectDb("doors", ["name"], ["address"], [$row["door"]]);
		$door = $doors->fetch_assoc();
		$events[] = [
			'name' => $door['name'],
			'door' => $row['door'],
			'date' => $row['date']
		];
	}
	echo json_encode($events);
}