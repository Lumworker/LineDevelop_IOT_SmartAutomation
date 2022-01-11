<?php

$access_token = 'VFjampKMj3v39fFWov+AxQX1EcUDU6HEu0Yr0APxxPVjAbNq8xdT8hmSnD2yOFqZOqlcU6yQmWFP8bK0dssANfZXLagaNak3S64KZUMtRuNRdYx3KLCZ+zVoorpnC3iTO09osfdOYrP6jEuFW0F5MFGUYhWQfeY8sLGRXgo3xvw=';

$pushID = ['U1d3716eba447cb90bc808199b319922b'];

$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$access_token}";
include './db_connect.php';

$sql = "SELECT [site_name],[customer_no], [site_code] ,[factory_name] ,[ReplyLine] FROM [dbo].[VW_API_LINE_Site] WHERE [lineToken] = 'U1d3716eba447cb90bc808199b319922b' ";
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

    }
}


print_r($pushID);
if (count($pushID) > 1) {
  $arrayPostData['to'] = $pushID;
  replyMsg("https://api.line.me/v2/bot/message/multicast", $arrayHeader, $arrayPostData);
} else {
  $arrayPostData['to'] = $pushID[0];
  replyMsg("https://api.line.me/v2/bot/message/push", $arrayHeader, $arrayPostData);
}


function replyMsg($url,$arrayHeader,$arrayPostData){
    $strUrl = $url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL,$strUrl);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);    
    curl_setopt($ch, CURLOPT_POSTFIELDS,json_encode($arrayPostData));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close ($ch);
}

function EncodeEmoji($inputemoji){
    $bin = hex2bin(str_repeat('0',8-strlen($inputemoji)).$inputemoji);
    $emojiOutput = mb_convert_encoding($bin,'UTF-8','UTF-32BE');
    return $emojiOutput;
}


exit;

?>