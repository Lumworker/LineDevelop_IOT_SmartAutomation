<?php

include '../API-IC/db_connect.php';


$access_token = 'VFjampKMj3v39fFWov+AxQX1EcUDU6HEu0Yr0APxxPVjAbNq8xdT8hmSnD2yOFqZOqlcU6yQmWFP8bK0dssANfZXLagaNak3S64KZUMtRuNRdYx3KLCZ+zVoorpnC3iTO09osfdOYrP6jEuFW0F5MFGUYhWQfeY8sLGRXgo3xvw=';
$channelSecret = 'da110c7f0191984db34de3c0574fc08c';
$pushID = ['U1d3716eba447cb90bc808199b319922b'];
// $pushID = ['U1d3716eba447cb90bc808199b319922b','U7530749e9262ca82cffa048f8205377d'];

$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$access_token}";

$queryText = "ข้อมูลเครื่องจักรของโรงน้ำแข็ง : TH10104 : VPIP : 1";
$massage =  explode(" : ",  $queryText);

print_r($massage);

$sql = "SELECT [main_machine_ID]  ,[main_machine_desc],[customer_no] , [site_code] , [factory_no] FROM [dbo].[TB_MainMachine] WHERE [customer_no] = '$massage[1]' AND [site_code] = '$massage[2]' AND [factory_no] = '$massage[3]'";
$getResults = sqlsrv_query($conn, $sql);
if (sqlsrv_has_rows($getResults) === TRUE) {
    $arrayDB = [];
    while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
        $Info = [];
        array_push($Info, $row["main_machine_ID"]);
        array_push($Info, $row["main_machine_desc"]);
        array_push($arrayDB, $Info);
       
    }



    print_r($arrayDB);
    //     if (count($arrayDB) > 0) {
    include("../FlexMassage-IC/Machine_Carousel.php");
    //   include("../FlexMassage-IC/test2.php");
    for ($i = 0; $i < count($arrayDB); $i++) {

        $arrayBoxNew['type'] = "bubble";
        $arrayBoxNew['direction'] = "ltr";
        $arrayBoxNew['hero']['type'] = "image";
        $arrayBoxNew['hero']['url'] = "https://sv1.picz.in.th/images/2019/06/05/1YNDAu.png";
        $arrayBoxNew['hero']['align'] = "center";
        $arrayBoxNew['hero']['size'] = "full";
        $arrayBoxNew['hero']['aspectRatio'] = "1.91:1";
        $arrayBoxNew['hero']['aspectMode'] = "fit";
        $arrayBoxNew['body']['type'] = "box";
        $arrayBoxNew['body']['layout'] = "vertical";
        $arrayBoxNew['body']['contents'][0]['type'] = "text";
        $arrayBoxNew['body']['contents'][0]['text'] = $arrayDB[$i][1];
        $arrayBoxNew['body']['contents'][0]['size'] = "xl";
        $arrayBoxNew['body']['contents'][0]['align'] = "center";
        $arrayBoxNew['body']['contents'][0]['weight'] = "bold";
        $arrayBoxNew['footer']['type'] = "box";
        $arrayBoxNew['footer']['layout'] = "vertical";
        $arrayBoxNew['footer']['spacing'] = "sm";
        $arrayBoxNew['footer']['contents'][0]['type'] = "button";
        $arrayBoxNew['footer']['contents'][0]['action']['type'] = "message";
        $arrayBoxNew['footer']['contents'][0]['action']['label'] = "ข้อมูลเบื้องต้น";
        $arrayBoxNew['footer']['contents'][0]['action']['text'] = "ข้อมูลเบื้องต้น : " . $arrayDB[$i][0];
        $arrayBoxNew['footer']['contents'][0]['color'] = "#0F4DB6";
        $arrayBoxNew['footer']['contents'][0]['height'] = "sm";
        $arrayBoxNew['footer']['contents'][0]['style'] = "primary";
        $arrayBoxNew['footer']['contents'][0]['gravity'] = "top";

        $arrayBoxNew['footer']['contents'][1]['type'] = "button";
        $arrayBoxNew['footer']['contents'][1]['action']['type'] = "message";
        $arrayBoxNew['footer']['contents'][1]['action']['label'] = "ข้อมูลแบบละเอียด";
        $arrayBoxNew['footer']['contents'][1]['action']['text'] = "ข้อมูลแบบละเอียด : " . $arrayDB[$i][0];
        $arrayBoxNew['footer']['contents'][1]['color'] = "#0F4DB6";
        $arrayBoxNew['footer']['contents'][1]['height'] = "sm";
        $arrayBoxNew['footer']['contents'][1]['style'] = "primary";
        $arrayBoxNew['footer']['contents'][1]['gravity'] = "top";
        array_push($jsonflex['contents']['contents'], $arrayBoxNew);
    }

    print_r($jsonflex);


    $arrayPostData['messages'][0] = $jsonflex;
}
// }


print_r($pushID);
if (count($pushID) > 1) {
    $arrayPostData['to'] = $pushID;
    replyMsg("https://api.line.me/v2/bot/message/multicast", $arrayHeader, $arrayPostData);
} else {
    $arrayPostData['to'] = $pushID[0];
    replyMsg("https://api.line.me/v2/bot/message/push", $arrayHeader, $arrayPostData);
}


function replyMsg($url, $arrayHeader, $arrayPostData)
{
    $strUrl = $url;
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

function EncodeEmoji($inputemoji)
{
    $bin = hex2bin(str_repeat('0', 8 - strlen($inputemoji)) . $inputemoji);
    $emojiOutput = mb_convert_encoding($bin, 'UTF-8', 'UTF-32BE');
    return $emojiOutput;
}

?>

<script type='text/javascript'>
    <!--
    settimeout('self.close()', 0000);
    -->
</script>