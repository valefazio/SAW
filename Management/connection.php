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
        if(!$res) {
            mysqli_close($conn);
            die("Unable to execute query: table '$table' not found.");
        }
        mysqli_close($conn);
        if($res->num_rows == 0)
            return array();
        return $res;
	}

    function selectDbColumns($columns) {
		global $table;
		$conn = accessDb();
		$sql = "SELECT $columns FROM $table";
		$res = $conn->query($sql);
        if(!$res) {
            mysqli_close($conn);
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
		return selectDbColumns("username, email, admin");
	}

    function toArray($res) {
        $array = array();
        while($row = $res->fetch_assoc())
            $array[] = $row;
        return $array;
    }
	
?>
