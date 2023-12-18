<?php
    include "credentials.php";
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
        
        $stmt = $conn->prepare("INSERT INTO $table ($columns) VALUES ($values)");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        
        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }
        
        $stmt->close();
        $conn->close();
    }

    function selectDb($columns, $where="") {
        global $table;
        $conn = accessDb();
        $condition = ($where != "") ? " WHERE $where" : "";
        $stmt = $conn->prepare("SELECT $columns FROM $table $condition");
        if (!$stmt) {
            die("Prepare failed: " . $conn->error);
        }
        if (!$stmt->execute()) {
            die("Execute failed: " . $stmt->error);
        }
        $res = $stmt->get_result();
        if (!$res) {
            die("Unable to execute query: table '$table' not found.");
        }
        mysqli_close($conn);
        return $res;
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
		return selectDb("username, email", "email = '$email'");
	}
    function getUsers($email) {
		return selectDb("username, email, admin");
	}

    function toArray($res) {
        $array = array();
        while($row = $res->fetch_assoc())
            $array[] = $row;
        return $array;
    }
	
?>
