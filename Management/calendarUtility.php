<?php
header('Content-Type: application/json');
include "accessControl.php";
if($_POST['opt'] == "list") {
	$res = selectDb("calendar", [], ["monster"], [$_SESSION["email"]]);
	$events = [];
	while($row = $res->fetch_assoc()) {
		$door = selectDb("doors", ["name"], ["address"], [$row["door"]])->fetch_assoc();
		$row_id = selectDb("doors_id", ["id"], ["address"], [$row["door"]])->fetch_assoc();
		$events[] = [
			'name' => $door['name'],
			'door' => $row['door'],
			'date' => $row['date'],
			'num' => $row_id['id']
		];
	}
	echo json_encode($events);
} else if($_POST['opt'] == "grid") {
	$res = selectWithFinalConditions("calendar", [], ["monster", "date"], [$_SESSION["email"], $_POST["date"]], "ORDER BY date");

	$events = [];
	while($row = $res->fetch_assoc()) {
		$door = selectDb("doors", ["name"], ["address"], [$row["door"]])->fetch_assoc();
		$row_id = selectDb("doors_id", ["id"], ["address"], [$row["door"]])->fetch_assoc();
		$events[] = [
			'name' => $door['name'],
			'door' => $row['door'],
			'date' => $row['date'],
			'num' => $row_id['id']
		];
	}
	echo json_encode($events);
}