<?php

include '../API-IC/db_connect.php';

$access_token = 'y0Wkplvd9qOrcRsx/RBSpvkEc5NR+P1a78ju3UnrSEOO7Q70aDDAZXOvJ6AtwebyYNXuoSQ2wVp8kX7RFiy4gA8T41nttrmP5OXGdcdUSXWHp7iWGD85tIrAwSkoCYdRUnopXYei0KrowUKXe/9h6wdB04t89/1O/w1cDnyilFU=';
$channelSecret = 'da110c7f0191984db34de3c0574fc08c';
$pushID = ['U1d3716eba447cb90bc808199b319922b'];
// $pushID = ['U1d3716eba447cb90bc808199b319922b','U7530749e9262ca82cffa048f8205377d'];

$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$access_token}";

$sql = "SELECT [site_name] ,[factory_name] ,[ReplyLine] FROM [dbo].[VW_API_LINE_Site] WHERE [lineToken] = 'Uead7d55a3e75763a67b2058fa776146e' ";
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
        // include("../FlexMassage-IC/Side_Carousel_DS.php");

        include("../FlexMassage-IC/Side_Carousel.php");
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
            $arrayBoxNew['footer']['contents'][1]['action']['text'] = "ข้อมูลแบบละเอียด : " . $arrayDB[$i][0] . " : " . $arrayDB[$i][1];
            $arrayBoxNew['footer']['contents'][1]['color'] = "#0F4DB6";
            $arrayBoxNew['footer']['contents'][1]['height'] = "sm";
            $arrayBoxNew['footer']['contents'][1]['style'] = "primary";
            $arrayBoxNew['footer']['contents'][1]['gravity'] = "top";


            // $arrayBoxNew['type'] = "bubble";
            // $arrayBoxNew['direction'] = "ltr";
            // $arrayBoxNew['hero']['type'] = "image";
            // $arrayBoxNew['hero']['url'] = "https://sv1.picz.in.th/images/2019/06/05/1SXgtV.jpg";
            // $arrayBoxNew['hero']['size'] = "full";
            // $arrayBoxNew['hero']['aspectRatio'] = "1.91:1";
            // $arrayBoxNew['hero']['aspectMode'] = "cover";
            // $arrayBoxNew['body']['type'] ="box";
            // $arrayBoxNew['body']['layout'] ="vertical";
            // $arrayBoxNew['body']['contents'][0]['type'] = "text";
            // $arrayBoxNew['body']['contents'][0]['text'] = "123456";
            // $arrayBoxNew['body']['contents'][0]['size'] = "xl";
            // $arrayBoxNew['body']['contents'][0]['gravity'] = "top";
            // $arrayBoxNew['body']['contents'][0]['weight'] = "bold";

            // $arrayBoxNew['body']['contents'][1]['type'] = "box";
            // $arrayBoxNew['body']['contents'][1]['layout'] = "baseline";
            // $arrayBoxNew['body']['contents'][1]['margin'] = "md";
            // $arrayBoxNew['body']['contents'][1]['contents'][0]['type'] = "text";
            // $arrayBoxNew['body']['contents'][1]['contents'][0]['text'] = $arrayDB[$i][0];
            // $arrayBoxNew['body']['contents'][1]['contents'][0]['size'] = "md";
            // $arrayBoxNew['body']['contents'][1]['contents'][0]['align'] = "start";
            // $arrayBoxNew['body']['contents'][1]['contents'][0]['gravity'] = "top";
            // $arrayBoxNew['body']['contents'][1]['contents'][0]['weight'] = "bold";

            // $arrayBoxNew['footer']['type'] = "box";
            // $arrayBoxNew['footer']['layout'] = "vertical";
            // $arrayBoxNew['footer']['flex'] = "0";
            // $arrayBoxNew['footer']['spacing'] = "sm";
            // $arrayBoxNew['footer']['contents'][0]['type'] = "button";
            // $arrayBoxNew['footer']['contents'][0]['action']['type'] = "message";
            // $arrayBoxNew['footer']['contents'][0]['action']['label'] = $arrayDB[$i][1];
            // $arrayBoxNew['footer']['contents'][0]['action']['text'] = $arrayDB[$i][2];
            // $arrayBoxNew['footer']['contents'][0]['color'] = "#144391";
            // $arrayBoxNew['footer']['contents'][0]['height'] = "sm";
            // $arrayBoxNew['footer']['contents'][0]['style'] = "primary";
            // $arrayBoxNew['footer']['contents'][0]['gravity'] = "top";

            // $arrayBoxNew['footer']['contents'][1]['type'] = "separator";
            // $arrayBoxNew['footer']['contents'][1]['margin'] = "md";
            // $arrayBoxNew['footer']['contents'][1]['color'] = "#FFFFFF";

            // $arrayBoxNew['styles']['hero']['separatorColor'] = "#FFFFFF";


            array_push($jsonflex['contents']['contents'], $arrayBoxNew);
        }

        print_r($jsonflex);
        $arrayPostData['messages'][0] = $jsonflex;
    }
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