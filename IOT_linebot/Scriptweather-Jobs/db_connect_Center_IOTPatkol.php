
<?php
// header('Content-Type: application/json');
header('Content-type: text/html; charset=utf-8');
date_default_timezone_set('Asia/Bangkok');
try 
    {
        $conn = new PDO("sqlsrv:server = tcp:172.25.238.2,1433; Database =Center_IOTPatkol", "sa", "{@Patkol.com}");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) 
    {
        print("Error connecting to SQL Server.");
        die(print_r($e));
    }
    $serverName = "tcp:172.25.238.2";
    $userName = 'sa';
    $userPassword = '@Patkol.com';
    $dbName = "Center_IOTPatkol";
    $connectionInfo = array("Database"=>$dbName, "UID"=>$userName, "PWD"=>$userPassword, "MultipleActiveResultSets"=>true,"CharacterSet"  => 'UTF-8');
    sqlsrv_configure('WarningsReturnAsErrors', 0);
    $conn = sqlsrv_connect($serverName, $connectionInfo);

?>