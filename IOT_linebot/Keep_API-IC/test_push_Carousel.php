<?php

include './db_connect.php';


$access_token = 'wzsqEYxW4I9M5l7Mu6rGdNnnB3QC9gVx/vsq0LA1twR26pHvv5fooXEwAScQmr/IIjf74l/ARy04qGt9hcSGtkXd6DGQZZJlvTznnoq+EZgkrdzh2Dxc342GZnFApsFslj9bEsGK7dMKIIPaOaUaogdB04t89/1O/w1cDnyilFU=';
$pushID = ['U0cfb6e104a4950d326e9b5354ec6f8dd'];
$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$access_token}";

$sql = "SELECT  [customer_no] ,[site_code],[factory_no],[site_name],[factory_name],[main_machine_ID],[main_machine_desc],[lineToken] FROM [dbo].[VW_API_ListMachine] WHERE [lineToken]='U86ff9444ba5744b77a3f0b4e54c0fdef'";

echo $sql = "SELECT [site_name],[customer_no], [site_code] ,[factory_no] ,[factory_name] FROM [dbo].[VW_API_LINE_Site] WHERE [lineToken] = 'U86ff9444ba5744b77a3f0b4e54c0fdef'";
$getResults = sqlsrv_query($conn, $sql);

if (sqlsrv_has_rows($getResults) === TRUE) {
  include("../FlexMassage-IC/Machine_Carousel.php");
  while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
    $arrayBoxNew = [];

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
    $arrayBoxNew['body']['contents'][0]['text'] = "" . $row['site_name'] . "";
    $arrayBoxNew['body']['contents'][0]['size'] = "xl";
    $arrayBoxNew['body']['contents'][0]['align'] = "center";
    $arrayBoxNew['body']['contents'][0]['weight'] = "bold";
    $arrayBoxNew['footer']['type'] = "box";
    $arrayBoxNew['footer']['layout'] = "vertical";
    $arrayBoxNew['footer']['spacing'] = "sm";


    echo $sql_machine = "SELECT [main_machine_ID],[main_machine_desc],[customer_no] ,[site_code],[factory_no],[factory_name]  FROM [IOTPatkol].[dbo].[VW_API_Machine_Factory] WHERE [customer_no] = '" . $row['customer_no'] . "' AND [site_code] = '" . $row['site_code'] . "' AND [factory_no] = '" . $row['factory_no'] . "'";
    $get_machine = sqlsrv_query($conn, $sql_machine);
    $i = 0;
    while ($row_machine = sqlsrv_fetch_array($get_machine, SQLSRV_FETCH_ASSOC)) {
      $arrayBoxNew['footer']['contents'][$i]['type'] = "button";
      $arrayBoxNew['footer']['contents'][$i]['action']['type'] = "message";
      $arrayBoxNew['footer']['contents'][$i]['action']['label'] = "" . $row_machine['main_machine_desc'] . "";
      $arrayBoxNew['footer']['contents'][$i]['action']['text'] = "รายละเอียดเครื่องจักร : " . $row_machine['customer_no'] . " : " . $row_machine['factory_no'] . " : " . $row_machine['site_code'] . " : " . $row_machine['main_machine_ID'];
      $arrayBoxNew['footer']['contents'][$i]['color'] = "#0F4DB6";
      $arrayBoxNew['footer']['contents'][$i]['height'] = "sm";
      $arrayBoxNew['footer']['contents'][$i]['style'] = "primary";
      $arrayBoxNew['footer']['contents'][$i]['gravity'] = "top";
      $i++;
    }
    array_push($jsonflex['contents']['contents'], $arrayBoxNew);
  }

  $arrayPostData['messages'][0] = $jsonflex;


  print_r($arrayPostData['messages']);
}

//   echo $sql = "SELECT [main_machine_ID],[main_machine_desc],[customer_no] ,[site_code],[factory_no],[factory_name],[site_name]  FROM [dbo].[VW_API_Machine_Factory] WHERE [customer_no] = 'TH10104' AND [factory_no] = '1' AND [site_code] = 'VPIP' AND [main_machine_ID] = 'TH10104VPIP01TI01'";
//     $getResults = sqlsrv_query($conn, $sql);
//     if (sqlsrv_has_rows($getResults) === TRUE) {
//         while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
//             $site_name = $row['site_name'];
//             $machine_desc = $row['main_machine_desc'];
//             include("../FlexMassage-IC/Machine_Detail_Bubble_2.php");

//                 $arrayBoxNew['type'] = "button";
//                 $arrayBoxNew['action']['type'] = "message";
//                 $arrayBoxNew['action']['label'] = "กำลังการผลิต";
//                 $arrayBoxNew['action']['text'] = "กำลังการผลิต : ". $row["main_machine_ID"] ."" ;
//                 $arrayBoxNew['color'] = "#4E4E4E";
//                 $arrayBoxNew['margin'] = "sm";
//                 $arrayBoxNew['height'] ="sm";
//                 $arrayBoxNew['style'] = "primary";
//                 array_push($jsonflex['contents']['footer']['contents'], $arrayBoxNew);

//                 $arrayBoxNew['type'] ="button";
//                 $arrayBoxNew['action']['type'] ="message";
//                 $arrayBoxNew['action']['label'] ="เวลาที่น้ำแข็งรอบต่อไปจะตก";
//                 $arrayBoxNew['action']['text'] ="เวลาที่น้ำแข็งรอบต่อไปจะตก : ".$row["main_machine_ID"]."";
//                 $arrayBoxNew['color'] ="#4E4E4E";
//                 $arrayBoxNew['margin'] = "sm";
//                 $arrayBoxNew['height'] ="sm";
//                 $arrayBoxNew['style'] ="primary";
//                 array_push($jsonflex['contents']['footer']['contents'], $arrayBoxNew);

//                 $arrayBoxNew['type'] ="button";
//                 $arrayBoxNew['action']['type'] ="message";
//                 $arrayBoxNew['action']['label'] ="สถานะการทำงาน";
//                 $arrayBoxNew['action']['text'] ="สถานะการทำงาน : ".$row["main_machine_ID"]."";
//                 $arrayBoxNew['color'] ="#4E4E4E";
//                 $arrayBoxNew['margin'] = "sm";
//                 $arrayBoxNew['height'] ="sm";
//                 $arrayBoxNew['style'] ="primary";
//                 array_push($jsonflex['contents']['footer']['contents'], $arrayBoxNew);

//                 $arrayBoxNew['type'] ="button";
//                 $arrayBoxNew['action']['type'] ="message";
//                 $arrayBoxNew['action']['label'] ="สรุปปัญหาประจำวัน";
//                 $arrayBoxNew['action']['text'] ="สรุปปัญหาประจำวัน : ".$row["main_machine_ID"]."";
//                 $arrayBoxNew['color'] ="#4E4E4E";
//                 $arrayBoxNew['margin'] = "sm";
//                 $arrayBoxNew['height'] ="sm";
//                 $arrayBoxNew['style'] ="primary";
//                 array_push($jsonflex['contents']['footer']['contents'], $arrayBoxNew);

//             $arrayPostData['messages'][0] = $jsonflex;
//         }
//     }

//     print_r($arrayPostData);

// print_r($pushID);
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
<!-- 
<script type='text/javascript'>
<!--
settimeout('self.close()',0000);
-->
</script> -->