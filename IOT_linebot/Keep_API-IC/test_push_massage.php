<?php
//Emoji https:developers.line.biz/en/docs/messaging-api/message-types/
// $access_token = $_POST['Accesstoken'];
// $channelSecret = $_POST['channelSecret'];
// $pushID = explode(";",  $_POST['TokenUser']);
// $Msg = "TEST APi";

$access_token = 'rtsuNwc4cknjdA0ZM+M9tspXbX5pwSSIEpb2rqoOfdWbu4akWsdq6XHLMdCY6E4tkTMfIEcA4pwa/DPjyivPf+B0Vyb/Z8TQ7qtrcJmgD1FOg027A+rzrKVyDixVJvb1hncbuJctlHFfBoBksOVW21GUYhWQfeY8sLGRXgo3xvw=';
// $channelSecret = 'da110c7f0191984db34de3c0574fc08c';
$pushID = ['Ua4c3b2de2a194dac8f78c64b1283b1a6'];
// // $pushID = ['U1d3716eba447cb90bc808199b319922b','U7530749e9262ca82cffa048f8205377d'];
// $Msg = "Hello world";

$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$access_token}";

$arrayPostData['messages'][0]['type'] = "text";
$arrayPostData['messages'][0]['text'] = "123123";

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