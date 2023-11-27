<?php
    function accessDb() {
        $dbhost = 'localhost:3306';
        $dbuser = 'vale';
        $dbpass = 'uni23';
        $dbname = 'prove';
        
        $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
        if ($conn->connect_error)
            die("Connection failed: " . $conn->connect_error);
        return $conn;
    }

    function insertDb($columns, $values) {
        $table = "utenti";
        $conn = accessDb();
        $sql = "INSERT INTO $table ($columns) VALUES ($values)";
        $res = $conn->query($sql);
        if(!$res) {
            mysqli_close($conn);
            die("Unable to execute query: table '$table' not created.");
        }
        mysqli_close($conn);
    }

    function selectDb($columns, $where) {
        $table = "utenti";
        $conn = accessDb();
        $sql = "SELECT $columns FROM $table WHERE $where";
        $res = $conn->query($sql);
        if(!$res) {
            mysqli_close($conn);
            die("Unable to execute query: table '$table' not created.");
        }
        mysqli_close($conn);
        return $res;
    }

    function updateDb($columns, $values, $where) {
        $table = "utenti";
        $conn = accessDb();
        $sql = "UPDATE $table SET $columns = $values WHERE $where";
        $res = $conn->query($sql);
        if(!$res) {
            mysqli_close($conn);
            die("Unable to execute query: table '$table' not created.");
        }
        mysqli_close($conn);
    }
?>
