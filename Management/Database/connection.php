<?php
    include("credentials.php");
    //include("../../Management/utility.php");
    function accessDb() {
        global $dbhost, $dbuser, $dbpass, $dbname;
        $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        if ($conn->connect_error){
            writeLog("Connection failed: " . $conn->connect_error);
            alert("An error was encountered. Please try again later.", "error");
            timerRelocation("../../index.php");
        }
        return $conn;
    }

    function insertDb($columns, $values) {
        global $table;
        $conn = accessDb();
        
        $stmt = $conn->prepare("INSERT INTO $table ($columns) VALUES ($values)");
        if (!$stmt) {
            writeLog("Prepare failed: " . $conn->error);
            alert("An error was encountered. Please try again later.", "error");
            timerRelocation("../../index.php");
        }
        
        if (!$stmt->execute()) {
            writeLog("Execute failed: " . $stmt->error);
            alert("An error was encountered. Please try again later.", "error");
            timerRelocation("../../index.php");
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
            writeLog("Prepare failed: " . $conn->error);
            alert("An error was encountered. Please try again later.", "error");
            timerRelocation("../../index.php");
        }
        if (!$stmt->execute()) {
            writeLog("Execute failed: " . $stmt->error);
            alert("An error was encountered. Please try again later.", "error");
            timerRelocation("../../index.php");
        }
        $res = $stmt->get_result();
        if (!$res) {
            writeLog("Unable to execute query: table '$table' not found.");
            alert("An error was encountered. Please try again later.", "error");
            timerRelocation("../../index.php");
        }
        mysqli_close($conn);
        return $res;
    }
	

    function updateDb($columns, $values, $where) {
        global $table;
        $conn = accessDb();
		
		$stmt = $conn->prepare("UPDATE $table SET $columns = $values WHERE $where");
        if (!$stmt) {
            writeLog("Prepare failed: " . $conn->error);
            alert("An error was encountered. Please try again later.", "error");
            timerRelocation("../../index.php");
        }
        
        if (!$stmt->execute()) {
            writeLog("Execute failed: " . $stmt->error);
            alert("An error was encountered. Please try again later.", "error");
            timerRelocation("../../index.php");
        }
        
        $stmt->close();
        $conn->close();
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
