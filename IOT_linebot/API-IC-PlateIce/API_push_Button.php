<?php
require('./db_connect.php');
$access_token = 'wzsqEYxW4I9M5l7Mu6rGdNnnB3QC9gVx/vsq0LA1twR26pHvv5fooXEwAScQmr/IIjf74l/ARy04qGt9hcSGtkXd6DGQZZJlvTznnoq+EZgkrdzh2Dxc342GZnFApsFslj9bEsGK7dMKIIPaOaUaogdB04t89/1O/w1cDnyilFU=';
// $access_token = 'oBMZMMuMVxboOZUW8cWoPeS3FrFMey/Z6ffz+kPiO3lFzDr/4DTFl7+iXFIdeJ9HuRG5mxq0tmay1ndBQ6qKCX3tZo0m1kLcO0IWQ4AyXEpjoZewZiw6f6xpG7uNfrZYyqta0Ka5dA7R7g5YA+rGewdB04t89/1O/w1cDnyilFU=';
$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$access_token}";

$trans_ID = $_POST['trans_ID'];
// $trans_ID = '11425';

echo $Datasql = "EXEC [SP_IOT_Alarm_LineConfig] " . $trans_ID;
$getDataResults = sqlsrv_query($conn, $Datasql);
$MSg_Line = array();
if (sqlsrv_has_rows($getDataResults) === TRUE) {
  while ($row = sqlsrv_fetch_array($getDataResults, SQLSRV_FETCH_ASSOC)) {
    array_push($MSg_Line, $row["Msg_Line"]);
    $Msg_Line_Stop = $row["Msg_Line_Stop"];
    $factory_no =  $row["factory_no"];
    $site_code =  $row["site_code"];
    $customer_no =  $row["customer_no"];
    print_r($row);
  }
}

$arrayPostData['messages'][0]['type'] = "text";
$arrayPostData['messages'][0]['text'] = $MSg_Line[0];

// $arrayPostData['messages'][0]['type'] = "text";
// $arrayPostData['messages'][0]['text'] = $trans_ID ;

if (count($MSg_Line) == 1) {

  if ($Msg_Line_Stop != "Not Msg") {

    $emoji = [];
    $message =  explode("(E)", $Msg_Line_Stop);
    for ($j = 1; $j < count($message); $j++) { //ดึงค่าตัวเลข จาก(E)ไปใส่ Array
      array_push($emoji, substr($message[$j], 0, 6));
    }

    for ($j = 0; $j < count($emoji); $j++) { //เอาค่า ในArray มาreplace แทน ตัวเลขหลัง E
      $Msg_Line_Stop = str_replace($emoji[$j], EncodeEmoji($emoji[$j]), $Msg_Line_Stop);
    }

    $Msg_Line_Stop = str_replace("(n)", "\n", $Msg_Line_Stop); //replace(n)ขึ้นบรรทัดใหม่
    $Msg_Line_Stop = str_replace("(E)", "", $Msg_Line_Stop); //ลบ(E)ทิ้ง
    $arrayPostData['messages'][1]['type'] = "text";
    $arrayPostData['messages'][1]['text'] = $Msg_Line_Stop;
  }
  // print_r($MSg_Line);
}

// Start User
$Usersql = "EXEC SP_IOT_Alarm_Member '$factory_no','$site_code',$customer_no";
$getUserResults = sqlsrv_query($conn, $Usersql);
$pushID = array();
if (sqlsrv_has_rows($getUserResults) === TRUE) {
  while ($row = sqlsrv_fetch_array($getUserResults, SQLSRV_FETCH_ASSOC)) {
      array_push($pushID, $row["lineToken"]);
  }
}
// EndUser
// print_r($pushID);
//$pushID = ['Ud205faa9bce3595ac9961fcb6c2c85c1'];

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
