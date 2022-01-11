
<?php

try {
    $conn = new PDO("sqlsrv:server = tcp:203.150.197.173,1433; Database =IOTPatkol_PlateIce", "sa", "{@Patkol.com}");
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    print("Error connecting to SQL Server.");
    die(print_r($e));
}

$serverName = "tcp:203.150.197.173";
$userName = 'sa';
$userPassword = '@Patkol.com';
$dbName = "IOTPatkol_PlateIce";
$connectionInfo = array("Database" => $dbName, "UID" => $userName, "PWD" => $userPassword, "MultipleActiveResultSets" => true, "CharacterSet"  => 'UTF-8');
sqlsrv_configure('WarningsReturnAsErrors', 0);
$conn = sqlsrv_connect($serverName, $connectionInfo);

?>