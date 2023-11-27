<?php
    $dbhost = 'localhost:3306';
    $dbuser = 'vale';
    $dbpass = 'uni23';
    $dbname = 'prove';
    $table = "users";
    function accessDb() {
        global $dbhost, $dbuser, $dbpass, $dbname;
        $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        if ($conn->connect_error)
            die("Connection failed: " . $conn->connect_error);
        return $conn;
    }

    function insertDb($columns, $values) {
        global $table;
        $conn = accessDb();
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $res = $conn->query($sql);
        if(!$res) {
            mysqli_close($conn);
            die("Unable to execute query: values were not inserted into table '$table'.");
        }
        mysqli_close($conn);
    }

    function selectDb($columns, $where) {
		global $table;
		$conn = accessDb();
		$sql = "SELECT $columns FROM $table WHERE $where";
		$res = $conn->query($sql);
		if (!$res) {
			mysqli_close($conn);
			die("Unable to execute selection query.");
		}
		mysqli_close($conn);
	
		$data = array(); // Initialize an array to store the result
		while ($row = $res->fetch_assoc()) {
			$data[] = $row;
		}
		return $data;
	}
	

    function updateDb($columns, $values, $where) {
        global $table;
        $conn = accessDb();
        $sql = "UPDATE $table SET $columns = $values WHERE $where";
        $res = $conn->query($sql);
        if(!$res) {
            mysqli_close($conn);
			die("Unable to execute query: table '$table' not updated.");
        }
        mysqli_close($conn);
    }

    function getUserProfileData($email) {
		$profileData = selectDb("username, email", "email = '$email'");
		return $profileData;
	}
	
?>
