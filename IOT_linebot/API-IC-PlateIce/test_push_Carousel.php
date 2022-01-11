<?php

// include './db_connect.php';


$access_token = 'Slle1/KNUDZluGCELZxuhAmRlxXDxqiDqG51VwMGj/3L7joSUhOmy3ntxE/IBGN+k0uQsCoV3R5yQ7c0GUe8Yd5A+G9oQjMmU6/VWcxo45xT/6YFgvQ3h2Q0onXrP7GghIdDkYmBUXfznggbRfoRkAdB04t89/1O/w1cDnyilFU=';
$pushID = ['U0cfb6e104a4950d326e9b5354ec6f8dd','U58f9aa06ab1292a9f548b48f0eea62d7'];
$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$access_token}";
  
    
    include("../FlexMassage-IC-PlateIce/test_flex_C.php");
    
    $arrayPostData['messages'][0] = $jsonflex;
    print_r($jsonflex);



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