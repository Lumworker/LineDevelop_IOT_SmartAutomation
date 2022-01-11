<?php
try 
    {
        $conn = new PDO("sqlsrv:server =PATKOL-01; Database =IOTPatkol", "sa", "{@Patkol.com}");
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
    catch (PDOException $e) 
    {
        print("Error connecting to SQL Server.");
        die(print_r($e));
    }
    
    $serverName = "PATKOL-01";
    $userName = 'sa';
    $userPassword = '@Patkol.com';
    $dbName = "IOTPatkol";
    $connectionInfo = array("Database"=>$dbName, "UID"=>$userName, "PWD"=>$userPassword, "MultipleActiveResultSets"=>true ,"CharacterSet"  =>'UTF-8');
    sqlsrv_configure('WarningsReturnAsErrors', 0);
    
    $conn = sqlsrv_connect($serverName, $connectionInfo);

?>