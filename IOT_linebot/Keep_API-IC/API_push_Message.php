<?php
//Emoji https:developers.line.biz/en/docs/messaging-api/message-types/
$access_token = $_POST['Accesstoken'];
$channelSecret = $_POST['channelSecret'];
$pushID = explode(";",  $_POST['TokenUser']);
$Msg = $_POST['msg'];

// $access_token = 'Hj3LQT+uniAt9dASudAM7QveJeeVi6CmrsfEmnuYl+CO9mAR+n+AhXibhtLj85ZNLDNbtJsfcUu0MvR3c25On4YB9BvNKE+VDR5nMi+ham7gVrsP5bjtIV6YQhN6mOwODClf6UnenQz+GJHoH2QOAwdB04t89/1O/w1cDnyilFU=';
// // $channelSecret = 'da110c7f0191984db34de3c0574fc08c';
// $pushID = 'Ua94ba716ab05e0cd7a6b373435a1bfa2';
// // $pushID = ['U1d3716eba447cb90bc808199b319922b','U7530749e9262ca82cffa048f8205377d'];
// $Msg = "Hello world";

$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$access_token}";

$arrayPostData['messages'][0]['type'] = "text";
$arrayPostData['messages'][0]['text'] = $Msg;

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
  
  // settimeout('self.close()', 0000);
 
</script>