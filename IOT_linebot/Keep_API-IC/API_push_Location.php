<?php
//Emoji https:developers.line.biz/en/docs/messaging-api/message-types/
// $access_token = $_POST['Accesstoken']; 
// $channelSecret = $_POST['channelSecret'];
// $pushID = $_POST['TokenUser'];
// $title = $_POST['Title'];
// $address = $_POST['address'];
// $latitude = $_POST['latitude'];
// $longitude $_POST['longitude'];

$access_token = 'OT7880CKoGMp65dwSGUn5hx3LrB33CvJAn4lHidq9fq2VG/x1h8YI4ptmCfSZkw6OqlcU6yQmWFP8bK0dssANfZXLagaNak3S64KZUMtRuN01C/eDGGQwXZJ1su0FU9k/CCFcIXcD6T4BosevMvpzwdB04t89/1O/w1cDnyilFU=';
$channelSecret = 'da110c7f0191984db34de3c0574fc08c';
// $pushID = 'U1d3716eba447cb90bc808199b319922b';
$pushID = ['U1d3716eba447cb90bc808199b319922b','U7530749e9262ca82cffa048f8205377d'];
// $PackageId = '1';
// $StickerId = '131';

$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$access_token}";
$arrayPostData['to'] = $pushID; 
$arrayPostData['messages'][0]['type'] = "location";
$arrayPostData['messages'][0]['title'] = "สยามพารากอน";
$arrayPostData['messages'][0]['address'] = "13.7465354,100.532752";
$arrayPostData['messages'][0]['latitude'] = "13.7465354";
$arrayPostData['messages'][0]['longitude'] = "100.532752";

if(is_array($pushID)){
    if(count($pushID) > 0){
        replyMsg("https://api.line.me/v2/bot/message/multicast",$arrayHeader,$arrayPostData);
    }
    else{
      echo "No Data";
    }
  }else{
   	if($pushID != ""){
        replyMsg("https://api.line.me/v2/bot/message/push",$arrayHeader,$arrayPostData);
    }
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