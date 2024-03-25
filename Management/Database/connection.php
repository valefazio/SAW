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

function disconnectDb(mysqli $conn): void
{
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
        $primaryKeys[] = $isPrimaryKey;
    }

    disconnectDb($conn);
    return array("columnName" => $cols, "is_primary_key" => $primaryKeys);
}


function insertDb(string $table, array $columns, array $values): bool
{
    $conn = accessDb();
    $infoTab = getTableInfoDb($table);

    //determine if query is already present in the db
    /* foreach ($infoTab["columnName"] as $col) {
        if ($infoTab["is_primary_key"]) {
            $query = "SELECT * FROM {$table} WHERE {$col} = ?";
            $stmt = $conn->prepare($query);
            $stmt->bind_param("s", $values[array_search($col, $columns)]);
            $stmt->execute();
            $result = $stmt->get_result();
            if ($result->num_rows > 0) {
                logs('record già presente con stessa chiave primaria');
                return false;
            }
        }
    } */

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

function selectDb(string $table, array $columns, string $where): ?mysqli_result
{
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
    $condition = ($where != "") ? " WHERE {$where}" : "";
    $query .= " FROM {$table} " . $condition;
    $stmt = $conn->prepare($query);
    $result = $stmt->execute();

    if (!$result)
        return null;
    $result = $stmt->get_result();
    disconnectDb($conn);
    $stmt->close();
    return $result;
}

function updateDb(string $table, array $columns, array $values, string $where): bool
{
    $conn = accessDb();

    if (count($columns) != count($values)) {
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
    $condition = ($where != "") ? " WHERE {$where}" : "";
    $query .= $condition;
    $stmt = $conn->prepare($query);
    $result = $stmt->execute(array_values($values));
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

function selectWholeDb() {
    $conn = accessDb();
    $query = "SELECT * FROM athletes LEFT JOIN managers ON managers.id = athletes.manager_id; ";
}

function getUserProfileData(string $table, string $email): ?mysqli_result {
    return selectDb($table, ["username", "email"], "email = '$email'");
}
function getUsers(string $table, string $email): ?mysqli_result {
    return selectDb($table, ["username", "email", "admin"], "");
}

function removeDb(string $table, string $where): bool   //ERROR: da migliorare
{
    $conn = accessDb();
    $query = "DELETE FROM {$table} WHERE {$where}";
    $stmt = $conn->prepare($query);
    $result = $stmt->execute();
    if (!$result)
        return false;
    disconnectDb($conn);
    return true;
}