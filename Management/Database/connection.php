<?php
include "credentials.php";

function logs($msg)
{   //writes $msg in console
    echo "<script> console.log('$msg'); </script>";
}

function accessDb(): mysqli
{
    global $dbhost, $dbuser, $dbpass, $dbname;
    $conn = new mysqli($dbhost, $dbuser, $dbpass, $dbname);
    if ($conn->connect_error)
        die ("Connection failed: " . $conn->connect_error);
    return $conn;
}

function disconnectDb(mysqli $conn): void {
    $conn->close();
}


function getTableInfoDb(string $table): ?array
{
    $conn = accessDb();
    $stmt = $conn->prepare("SHOW COLUMNS FROM {$table}");
    $stmt->execute();
    $colonne = $stmt->get_result();
    if (!$colonne)
        return null;

    $cols = array();
    $primaryKeys = array();

    while ($col = $colonne->fetch_assoc()) {
        $columnName = $col["Field"];
        $isPrimaryKey = $col["Key"] === "PRI"; // Check if the column is a primary key
        $cols[] = $columnName;
        if ($isPrimaryKey) {
            $primaryKeys[] = $columnName;
        }
    }

    disconnectDb($conn);
    return array("columnName" => $cols, "is_primary_key" => $primaryKeys);
}


function insertDb(string $table, array $columns, array $values): bool
{
    $conn = accessDb();
    $infoTab = getTableInfoDb($table);

    /* foreach($infoTab["is_primary_key"] as $key) {
        logs($key);
    } */

    //determine if query is already present in the db
    foreach ($infoTab["columnName"] as $col) {
        //logs($col . ": " . in_array($infoTab["columnName"], $infoTab["is_primary_key"]));
        if (in_array($infoTab["columnName"], $infoTab["is_primary_key"])) {
            $query = "SELECT * FROM {$table} WHERE {$col} = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $values[array_search($col, $columns)]);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                logs('record già presente con stessa chiave primaria');
                /* logs($result->num_rows);
                logs($result->fetch_assoc()["email"]); */
                return false;
            }
        }
    }

    $query = "INSERT INTO {$table} (";

    //check if columns are valid
    foreach ($columns as $colToInsert) {
        $found = false;
        foreach ($infoTab["columnName"] as $col) {
            if (strtolower($col) == strtolower($colToInsert)) {
                $query .= "{$col},";
                $found = true;
            }
        }
        if (!$found) {
            logs("vuoi inserire " . $colToInsert . " ma nel db non c'è");
            return false;
        }
    }

    $query = substr($query, 0, -1);	//rimuovo l'ultima virgola
    $query .= ") VALUES (";
    for ($i = 0; $i < count($columns); $i++)
        $query .= "?,";
    $query = substr($query, 0, -1);	//rimuovo l'ultima virgola
    $query .= ")";

    $stmt = $conn->prepare($query);
    $newValues = array_values($values);
    $result = $stmt->execute($newValues);
    if (!$result)
        return false;
    disconnectDb($conn);
    return true;
}

function selectDb(string $table, array $columns, array $whereCol, array $whereVal): ?mysqli_result {
    return selectWithFinalConditions($table, $columns, $whereCol, $whereVal, "");
}

function selectWithFinalConditions(string $table, array $columns, array $whereCol, array $whereVal, string $conds): ?mysqli_result {
    if(count($whereCol) != count($whereVal)) {
        logs("numero colonne e valori non corrispondono");
        return null;
    }
    $conn = accessDb();
    $infoTab = getTableInfoDb($table);

    $query = "SELECT ";

    if (count($columns) == 0)
        $query .= "* ,";	//se non specifico le colonne, prendo tutto
    else {
        foreach ($columns as $colToSelect) {
            $found = false;
            foreach ($infoTab["columnName"] as $col) {
                if (strtolower($col) == strtolower($colToSelect)) {
                    $query .= "{$col},";
                    $found = true;
                }
            }
            if (!$found) {
                logs("vuoi inserire " . $colToSelect . " ma nel db non c'è");
                return null;
            }
        }
    }
    $query = substr($query, 0, -1);	//rimuovo l'ultima virgola
    $query .= " FROM {$table}";
    if(count($whereCol) > 0) {
        $query .= " WHERE ";
        for ($i = 0; $i < count($whereCol); $i++) {
            $found = false;
            foreach ($infoTab["columnName"] as $col) {
                if (strtolower($col) == strtolower($whereCol[$i])) {
                    $query .= "{$col} = ? AND ";
                    $found = true;
                }
            }
            if (!$found) {
                logs("vuoi inserire " . $whereCol[$i] . " ma nel db non c'è");
                return null;
            }
        }
        $query = substr($query, 0, -4);	//rimuovo l'ultima virgola
    }
    $query .= " " . $conds;
    //echo "console.log('".$query."');";
    $stmt = $conn->prepare($query);
    $result = $stmt->execute($whereVal);
    if (!$result)
        return null;
    $result = $stmt->get_result();
    disconnectDb($conn);
    $stmt->close();
    return $result; 
}

function updateDb(string $table, array $columns, array $values, array $whereCol, array $whereVal): bool
{
    $conn = accessDb();

    if ((count($columns) != count($values)) || (count($whereCol) != count($whereVal))){
        logs("numero colonne e valori non corrispondono");
        return false;
    }
    $infoTab = getTableInfoDb($table);
    $query = "UPDATE {$table} SET ";

    foreach ($columns as $colToSelect) {
        $found = false;
        foreach ($infoTab["columnName"] as $col) {
            if (strtolower($col) == strtolower($colToSelect)) {
                $query .= "{$col} = ?,";
                $found = true;
            }
        }
        if (!$found) {
            logs("vuoi inserire " . $colToSelect . " ma nel db non c'è");
            return false;
        }
    }
    $query = substr($query, 0, -1);	//rimuovo l'ultima virgola
    if(count($whereCol) > 0) {
        $query .= " WHERE ";
        for ($i = 0; $i < count($whereCol); $i++) {
            $found = false;
            foreach ($infoTab["columnName"] as $col) {
                if (strtolower($col) == strtolower($whereCol[$i])) {
                    $query .= "{$col} = ? AND ";
                    $found = true;
                }
            }
            if (!$found) {
                logs("vuoi inserire " . $whereCol[$i] . " ma nel db non c'è");
                return false;
            }
        }
        $query = substr($query, 0, -4);	//rimuovo l'ultimo AND
    }
    $stmt = $conn->prepare($query);
    $newValues = array_merge(array_values($values), array_values($whereVal));
    $result = $stmt->execute($newValues);
    if (!$result)
        return false;
    disconnectDb($conn);
    return true;
}

function selectQuery(string $query): ?mysqli_result {
    $conn = accessDb();
    $stmt = $conn->prepare($query);
    $result = $stmt->execute();
    if (!$result)
        return null;
    $result = $stmt->get_result();
    disconnectDb($conn);
    $stmt->close();
    return $result;
}

function getUsers(string $email): ?mysqli_result {
    return selectDb("users", [], ["email"], [$email]);
}

function removeDb(string $table, array $whereCol, array $whereVal): bool
{
	$conn = accessDb();
	$infoTab = getTableInfoDb($table);
	$query = "DELETE FROM {$table} WHERE ";

	for ($i = 0; $i < count($whereCol); $i++) {
		$found = false;
		foreach ($infoTab["columnName"] as $col) {
			if (strtolower($col) == strtolower($whereCol[$i])) {
				$query .= "{$col} = ? AND ";
				$found = true;
			}
		}
		if (!$found) {
			logs("vuoi inserire " . $whereCol[$i] . " ma nel db non c'è");
			return false;
		}
	}
	$query = substr($query, 0, -4);	//rimuovo l'ultimo AND
	$stmt = $conn->prepare($query);
	$result = $stmt->execute($whereVal);
	if (!$result)
		return false;
	disconnectDb($conn);
	return true;
}