<?php
require('./db_connect.php');
// $access_token = "VFjampKMj3v39fFWov+AxQX1EcUDU6HEu0Yr0APxxPVjAbNq8xdT8hmSnD2yOFqZOqlcU6yQmWFP8bK0dssANfZXLagaNak3S64KZUMtRuNRdYx3KLCZ+zVoorpnC3iTO09osfdOYrP6jEuFW0F5MFGUYhWQfeY8sLGRXgo3xvw=";
// $access_token = "JZmqP+IjlLvAh9REu3DtOwPcFUsunfvwNqfhyVQd5G7vl7qr+khQBA2b1gqT+pmLkTMfIEcA4pwa/DPjyivPf+B0Vyb/Z8TQ7qtrcJmgD1E1B+pLFA/XM7RtQH0mWWeFYfWaA5o9OVwhdO7f6khDqwdB04t89/1O/w1cDnyilFU=";
// $access_token = "wx22cSe3Jv77+pA6wps5ARjETzj6at2/3uRRacSVyB4rPRwKfi4B3fGSpCI8kZWY6sg1ycnDVYS4+LfL6J2j1a1QJpVWZCo68tjR46P2IdjDPoBNwYOmKINZ4UKWSkKVj2e31iedKG+YIu+ue3kMFwdB04t89/1O/w1cDnyilFU=";
include ('./access_token.php');
// print_r($_POST);

$trans_ID = $_POST['trans_ID'];
$Datasql = "EXEC SP_IOT_Alarm_LineConfig ".$trans_ID;
$getDataResults = sqlsrv_query($conn, $Datasql);
$MSg_Line = array();

if (sqlsrv_has_rows($getDataResults) === TRUE) {

  while ($row = sqlsrv_fetch_array($getDataResults, SQLSRV_FETCH_ASSOC)) {
    array_push($MSg_Line, $row["Msg_Line"]);
    $factory_no =  $row["factory_no"];
    $site_code =  $row["site_code"];
    $customer_no =  $row["customer_no"];
  }
}
$msg = $MSg_Line[0];
$msg2 = $MSg_Line[1];
$url1 = $MSg_Line[2];
$url2 = $MSg_Line[3];
// $url1 = "https://google.co.th";
// $url2 = "https://google.co.th";
$text3 = $MSg_Line[4];
print_r($MSg_Line);
$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$access_token2}";

$arrayPostData['messages'][0]['type'] = "text";
$arrayPostData['messages'][0]['text'] = $msg;

if(count($MSg_Line ) > 1){
  $arrayPostData['messages'][1]['type'] = "text";
  $arrayPostData['messages'][1]['text'] = $msg2;
  
  include("../FlexMassage/Button.php");
  $arrayPostData['messages'][2] = $jsonFlex;
  $arrayPostData['messages'][3] = $jsonFlex2;
}



$Usersql = "EXEC SP_IOT_Alarm_Member '$factory_no','$site_code',$customer_no";
$getUserResults = sqlsrv_query($conn, $Usersql);
$pushID = array();
if (sqlsrv_has_rows($getUserResults) === TRUE) {
  while ($row = sqlsrv_fetch_array($getUserResults, SQLSRV_FETCH_ASSOC)) {
    array_push($pushID, $row["lineToken"]);
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
