<?php

include './db_connect.php';

$access_token = 'wzsqEYxW4I9M5l7Mu6rGdNnnB3QC9gVx/vsq0LA1twR26pHvv5fooXEwAScQmr/IIjf74l/ARy04qGt9hcSGtkXd6DGQZZJlvTznnoq+EZgkrdzh2Dxc342GZnFApsFslj9bEsGK7dMKIIPaOaUaogdB04t89/1O/w1cDnyilFU=';
$pushID = ['U0cfb6e104a4950d326e9b5354ec6f8dd'];
$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$access_token}";

// //Start Step Test
//     include("../FlexMassage-IC/test_flex.php");
//     $arrayPostData['messages'][0] = $jsonflex;
//     print_r($jsonflex);
// //End Step Test


$sql = "SELECT [customer_no],[site_code],[factory_no],[site_name],[factory_name],[main_machine_ID],[main_machine_desc] FROM [dbo].[VW_API_ListMachine] WHERE [lineToken] = 'U0cfb6e104a4950d326e9b5354ec6f8dd' ";
$getResults = sqlsrv_query($conn, $sql, array(), array("Scrollable" => 'static'));
if (sqlsrv_has_rows($getResults) === TRUE) {
  $arrayDB = ['วันนี้'];
  $i = 1;
  $row_count = sqlsrv_num_rows($getResults);
  $namefic = "";
  $Msg = "";
  while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
    if ($namefic == "") {
      $namefic = $row['factory_name'];
      $Msg = "".$row['factory_name']."\n";
    } else if ($namefic != $row['factory_name']) {
      array_push($arrayDB, $Msg);
      $Msg = "".$row['factory_name']."\n";
      $namefic = $row['factory_name'];
    } else if ($namefic == $row['factory_name']) {
      $Msg = $Msg . " \n ";
    }

    $sql2 = "EXEC [dbo].[SP_Machine_Summary_HG] '" . $row['main_machine_ID'] . "'";
    $getResults2 = sqlsrv_query($conn, $sql2);
    while ($row2 = sqlsrv_fetch_array($getResults2, SQLSRV_FETCH_ASSOC)) {
      $Msg .= $row['main_machine_desc']."\n    -ผลิตน้ำแข็งไปแล้วจำนวน ".$row2['Cycle'] . " รอบ\n" . "    -พลังงานที่ใช้ไป " . $row2['PowerUsed']  . " หน่วย\n" ."     -ปริมาณน้ำที่ใช้ ". $row2['WaterUsed']." คิว\n" ;
    }

    if ($i == $row_count) {
      array_push($arrayDB, $Msg);
    }
    $i++;
  }

  for ($i=0; $i < count($arrayDB); $i++) { 
  $arrayPostData['messages'][$i]['type'] = "text";
  $arrayPostData['messages'][$i]['text'] = $arrayDB[$i] ;
  }
  print_r($arrayDB);
}




//Start Step ข้อมูลของโรงน้ำแข็ง 
// echo $sql = "SELECT [site_name],[customer_no], [site_code] ,[factory_no] ,[factory_name] FROM [dbo].[VW_API_LINE_Site] WHERE [lineToken] = 'U86ff9444ba5744b77a3f0b4e54c0fdef'";
// $getResults = sqlsrv_query($conn, $sql);

// if (sqlsrv_has_rows($getResults) === TRUE) {
//   include("../FlexMassage-IC/Machine_Carousel.php");
//   while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
//     $arrayBoxNew = [];

//     $arrayBoxNew['type'] = "bubble";
//     $arrayBoxNew['direction'] = "ltr";
//     $arrayBoxNew['hero']['type'] = "image";
//     $arrayBoxNew['hero']['url'] = "https://patkolpae.com/IOT_linebot/images/Patkol_314.jpg";
//     $arrayBoxNew['hero']['align'] = "center";
//     $arrayBoxNew['hero']['size'] = "full";
//     $arrayBoxNew['hero']['aspectRatio'] = "20:13";
//     $arrayBoxNew['hero']['aspectMode'] = "cover";
//     $arrayBoxNew['body']['type'] = "box";
//     $arrayBoxNew['body']['layout'] = "vertical";
//     $arrayBoxNew['body']['contents'][0]['type'] = "text";
//     $arrayBoxNew['body']['contents'][0]['text'] = "" . $row['site_name'] . "";
//     $arrayBoxNew['body']['contents'][0]['size'] = "xl";
//     $arrayBoxNew['body']['contents'][0]['align'] = "center";
//     $arrayBoxNew['body']['contents'][0]['weight'] = "bold";
//     $arrayBoxNew['body']['contents'][0]['color'] = "#000000";

//     $arrayBoxNew['body']['contents'][1]['type'] = "text";
//     $arrayBoxNew['body']['contents'][1]['margin'] = "sm";
//     $arrayBoxNew['body']['contents'][1]['text'] = "เลือกเครื่องทำน้ำแข็งที่ต้องการ";
//     $arrayBoxNew['body']['contents'][1]['size'] = "lg";
//     $arrayBoxNew['body']['contents'][1]['align'] = "center";
//     $arrayBoxNew['body']['contents'][1]['color'] = "#000000";

//     $arrayBoxNew['body']['contents'][2]['type'] = "box";
//     $arrayBoxNew['body']['contents'][2]['margin'] = "md";
//     $arrayBoxNew['body']['contents'][2]['layout'] = "vertical";
//     $arrayBoxNew['body']['contents'][2]['contents'] = [];

//     $sql_machine = "SELECT [main_machine_ID],[main_machine_desc],[customer_no] ,[site_code],[factory_no],[factory_name],[main_machine_size]  FROM [IOTPatkol].[dbo].[VW_API_Machine_Factory] WHERE [customer_no] = '" . $row['customer_no'] . "' AND [site_code] = '" . $row['site_code'] . "' AND [factory_no] = '" . $row['factory_no'] . "' ORDER BY [main_machine_ID] , [main_machine_size]";
//     $get_machine = sqlsrv_query($conn, $sql_machine);
//     $i = 0;
//     while ($row_machine = sqlsrv_fetch_array($get_machine, SQLSRV_FETCH_ASSOC)) {
//       if ($row_machine['main_machine_size'] == 41) {
//         $color = "#000D7F";
//       } elseif ($row_machine['main_machine_size'] == 19) {
//         $color = "#2290FB";
//       }
//       $arrayBoxNew['body']['contents'][2]['contents'][$i]['type'] = "button";
//       $arrayBoxNew['body']['contents'][2]['contents'][$i]['action']['type'] = "message";
//       $arrayBoxNew['body']['contents'][2]['contents'][$i]['action']['label'] = "" . $row_machine['main_machine_desc'] . "";
//       $arrayBoxNew['body']['contents'][2]['contents'][$i]['action']['text'] = "รายละเอียดเครื่องจักร : " . $row_machine['customer_no'] . " : " . $row_machine['factory_no'] . " : " . $row_machine['site_code'] . " : " . $row_machine['main_machine_ID'];
//       $arrayBoxNew['body']['contents'][2]['contents'][$i]['color'] = $color;
//       $arrayBoxNew['body']['contents'][2]['contents'][$i]['margin'] = "sm";
//       $arrayBoxNew['body']['contents'][2]['contents'][$i]['height'] = "sm";
//       $arrayBoxNew['body']['contents'][2]['contents'][$i]['style'] = "primary";
//       $arrayBoxNew['body']['contents'][2]['contents'][$i]['gravity'] = "top";
//       $i++;
//     }
//     array_push($jsonflex['contents']['contents'], $arrayBoxNew);
//   }

//   $arrayPostData['messages'][0] = $jsonflex;


//   print_r($arrayPostData['messages']);
// }

//  END Step ข้อมูลของโรงน้ำแข็ง

//     //Start Step รายละเอียดเครื่องจักร
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
//                 array_push($jsonflex['contents']['body']['contents'][2]['contents'], $arrayBoxNew);

//                 $arrayBoxNew['type'] ="button";
//                 $arrayBoxNew['action']['type'] ="message";
//                 $arrayBoxNew['action']['label'] ="เวลาที่น้ำแข็งรอบต่อไปจะตก";
//                 $arrayBoxNew['action']['text'] ="เวลาที่น้ำแข็งรอบต่อไปจะตก : ".$row["main_machine_ID"]."";
//                 $arrayBoxNew['color'] ="#4E4E4E";
//                 $arrayBoxNew['margin'] = "sm";
//                 $arrayBoxNew['height'] ="sm";
//                 $arrayBoxNew['style'] ="primary";
//                 array_push($jsonflex['contents']['body']['contents'][2]['contents'], $arrayBoxNew);

//                 $arrayBoxNew['type'] ="button";
//                 $arrayBoxNew['action']['type'] ="message";
//                 $arrayBoxNew['action']['label'] ="สถานะการทำงาน";
//                 $arrayBoxNew['action']['text'] ="สถานะการทำงาน : ".$row["main_machine_ID"]."";
//                 $arrayBoxNew['color'] ="#4E4E4E";
//                 $arrayBoxNew['margin'] = "sm";
//                 $arrayBoxNew['height'] ="sm";
//                 $arrayBoxNew['style'] ="primary";
//                 array_push($jsonflex['contents']['body']['contents'][2]['contents'], $arrayBoxNew);

//                 $arrayBoxNew['type'] ="button";
//                 $arrayBoxNew['action']['type'] ="message";
//                 $arrayBoxNew['action']['label'] ="สรุปปัญหาประจำวัน";
//                 $arrayBoxNew['action']['text'] ="สรุปปัญหาประจำวัน : ".$row["main_machine_ID"]."";
//                 $arrayBoxNew['color'] ="#4E4E4E";
//                 $arrayBoxNew['margin'] = "sm";
//                 $arrayBoxNew['height'] ="sm";
//                 $arrayBoxNew['style'] ="primary";
//                 array_push($jsonflex['contents']['body']['contents'][2]['contents'], $arrayBoxNew);

//             $arrayPostData['messages'][0] = $jsonflex;
//         }
//     }

//     print_r($arrayPostData);
//     //End Step รายละเอียดเครื่องจักร

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