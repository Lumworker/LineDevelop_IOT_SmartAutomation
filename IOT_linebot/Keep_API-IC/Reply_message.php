<?php
$accessToken = "y0Wkplvd9qOrcRsx/RBSpvkEc5NR+P1a78ju3UnrSEOO7Q70aDDAZXOvJ6AtwebyYNXuoSQ2wVp8kX7RFiy4gA8T41nttrmP5OXGdcdUSXWHp7iWGD85tIrAwSkoCYdRUnopXYei0KrowUKXe/9h6wdB04t89/1O/w1cDnyilFU="; //copy Channel access token ตอนที่ตั้งค่ามาใส่
//Token
include './db_connect.php';
$content = file_get_contents('php://input');
$arrayJson = json_decode($content, true);
file_put_contents('log.txt', file_get_contents('php://input') . PHP_EOL, FILE_APPEND);
$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$accessToken}";

//รับข้อความจากผู้ใช้
$message = $arrayJson['events'][0]['message']['text'];
if ($massage == "ข้อมูลของโรงน้ำแข็ง") {

    $sql = "SELECT [site_name],[customer_no], [site_code] ,[factory_name] ,[ReplyLine] FROM [dbo].[VW_API_LINE_Site] WHERE [lineToken] = '$userId' ";
    $getResults = sqlsrv_query($conn, $sql);
    if (sqlsrv_has_rows($getResults) === TRUE) {
        $arrayDB = [];
        while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
            $Info = [];
            array_push($Info, $row["site_name"]);
            array_push($Info, $row["factory_name"]);
            array_push($Info, $row["ReplyLine"]);
            array_push($Info, $row["customer_no"]);
            array_push($Info, $row["site_code"]);
            array_push($arrayDB, $Info);
            print_r($arrayDB);
        }
        if (count($arrayDB) > 0) {
            include("../FlexMassage-IC/Side.php");

            for ($i = 0; $i < count($arrayDB); $i++) {
                $arrayBoxNew['type'] = "button";
                $arrayBoxNew['action']['type'] = "message";
                $arrayBoxNew['action']['label'] = $arrayDB[$i][0];
                $arrayBoxNew['action']['text'] = "ข้อมูลของโรงน้ำแข็งที่เลือก : " . $arrayDB[$i][3] . " : " . $arrayDB[$i][4];
                $arrayBoxNew['color'] = "#144391";
                $arrayBoxNew['height'] = "sm";
                $arrayBoxNew['style'] = "primary";
                $arrayBoxNew['gravity'] = "top";
                array_push($jsonflex['contents']['footer']['contents'], $arrayBoxNew);
            }

            print_r($jsonflex);
            $arrayPostData['messages'][0] = $jsonflex;

            replyMsg($arrayHeader, $arrayPostData);
        }
    }
}

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
