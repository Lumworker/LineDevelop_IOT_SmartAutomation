<?php
include './db_connect.php';
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
// $accessToken = "wzsqEYxW4I9M5l7Mu6rGdNnnB3QC9gVx/vsq0LA1twR26pHvv5fooXEwAScQmr/IIjf74l/ARy04qGt9hcSGtkXd6DGQZZJlvTznnoq+EZgkrdzh2Dxc342GZnFApsFslj9bEsGK7dMKIIPaOaUaogdB04t89/1O/w1cDnyilFU="; //copy Channel access token ตอนที่ตั้งค่ามาใส่
// $accessToken = getallheaders()['token'];
// $json = file_get_contents('php://input');
// $request = json_decode($json, true);
// $queryText = $request["queryResult"]["queryText"];
// $userId = $request['originalDetectIntentRequest']['payload']['data']['source']['userId'];
$userId ='U0cfb6e104a4950d326e9b5354ec6f8dd';
// $replyToken = $request['originalDetectIntentRequest']['payload']['data']['replyToken'];
// file_put_contents('./Log/Test_BOT.txt', file_get_contents('php://input') . PHP_EOL, FILE_APPEND);
// $arrayHeader = array();
// $arrayHeader[] = "Content-Type: application/json";
// $arrayHeader[] = "Authorization: Bearer {$accessToken}";
// $arrayPostData['replyToken'] = $replyToken;
// $massage =  explode(" : ",  $queryText);


    $sql = "SELECT [customer_no],[site_code],[factory_no],[site_name],[factory_name],[main_machine_ID],[main_machine_desc] FROM [dbo].[VW_API_ListMachine] WHERE [lineToken] = '$userId' ";
    $getResults = sqlsrv_query($conn, $sql);
    if (sqlsrv_has_rows($getResults) === TRUE) {
        while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
            $sql2 = "EXEC [SP_API_Line_Status_Machine_20200506] 'PK00001PKKK01PI01','TodayProductions'";
            $getResults2 = sqlsrv_query($conn, $sql2);
            if (sqlsrv_has_rows($getResults2) === TRUE) {
                $row2 = sqlsrv_fetch_array($getResults2, SQLSRV_FETCH_ASSOC);
                print_r($row2);

                // if( $row2 === false ) {
                //     if( ($errors = sqlsrv_errors() ) != null) {
                //         foreach( $errors as $error ) {
                //             echo "SQLSTATE: ".$error[ 'SQLSTATE']."<br />";
                //             echo "code: ".$error[ 'code']."<br />";
                //             echo "message: ".$error[ 'message']."<br />";
                //         }
                //     }
                // }
            }
        }

    }
sqlsrv_close($conn);
function profile($userId, $accessToken)
{
    $urlprofile = 'https://api.line.me/v2/bot/profile/' . $userId;
    $headers = array('Authorization: Bearer ' . $accessToken);
    $profileline = curl_init($urlprofile);
    curl_setopt($profileline, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($profileline, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($profileline, CURLOPT_FOLLOWLOCATION, 1);
    $resultprofile = curl_exec($profileline);
    curl_close($profileline);
    return json_decode($resultprofile, true);
}


function replyMsg($arrayHeader, $arrayPostData)
{
    $strUrl = "https://api.line.me/v2/bot/message/reply";
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $strUrl);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrayPostData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
}

exit;
