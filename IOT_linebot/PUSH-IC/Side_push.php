<?php

include '../API-IC/db_connect.php';


$access_token = 'VFjampKMj3v39fFWov+AxQX1EcUDU6HEu0Yr0APxxPVjAbNq8xdT8hmSnD2yOFqZOqlcU6yQmWFP8bK0dssANfZXLagaNak3S64KZUMtRuNRdYx3KLCZ+zVoorpnC3iTO09osfdOYrP6jEuFW0F5MFGUYhWQfeY8sLGRXgo3xvw=';
$channelSecret = 'da110c7f0191984db34de3c0574fc08c';
$pushID = ['U1d3716eba447cb90bc808199b319922b'];
// $pushID = ['U1d3716eba447cb90bc808199b319922b','U7530749e9262ca82cffa048f8205377d'];

$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$access_token}";

 echo $sql = "SELECT [site_name] ,[factory_name] ,[ReplyLine] FROM [dbo].[VW_API_LINE_Site] WHERE [lineToken] = '$pushID[0]' ";
$getResults = sqlsrv_query($conn, $sql);
if (sqlsrv_has_rows($getResults) === TRUE) {
    $arrayDB = [];
    while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
        $Info = [];
        array_push($Info, $row["site_name"]);
        array_push($Info, $row["factory_name"]);
        array_push($Info, $row["ReplyLine"]);
        array_push($arrayDB, $Info);
        print_r($arrayDB);
    }
    if (count($arrayDB) > 0) {
        include("../FlexMassage-IC/Side.php");

        for ($i = 0; $i < count($arrayDB); $i++) {
            $arrayBoxNew['type'] = "button";
            $arrayBoxNew['action']['type'] = "message";
            $arrayBoxNew['action']['label'] = $arrayDB[$i][1];
            $arrayBoxNew['action']['text'] = $arrayDB[$i][2];
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

?>

<script type='text/javascript'>
<!--
settimeout('self.close()',0000);
--></script>