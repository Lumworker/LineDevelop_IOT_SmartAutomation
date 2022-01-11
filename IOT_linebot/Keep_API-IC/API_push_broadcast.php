<?php
//Emoji https:developers.line.biz/en/docs/messaging-api/message-types/
// $channelSecret = $_POST['channelSecret'];
include ('./access_token.php');
$Msg ="สวัสดีจ้า broadcast";
// $Msg = $_POST['msg'];
// $Msg = $_POST[0]['msg'];
// $access_token = 'rtsuNwc4cknjdA0ZM+M9tspXbX5pwSSIEpb2rqoOfdWbu4akWsdq6XHLMdCY6E4tkTMfIEcA4pwa/DPjyivPf+B0Vyb/Z8TQ7qtrcJmgD1FOg027A+rzrKVyDixVJvb1hncbuJctlHFfBoBksOVW21GUYhWQfeY8sLGRXgo3xvw=';
// // $channelSecret = 'da110c7f0191984db34de3c0574fc08c';
// $pushID = 'Ua94ba716ab05e0cd7a6b373435a1bfa2';
// // $pushID = ['U1d3716eba447cb90bc808199b319922b','U7530749e9262ca82cffa048f8205377d'];
// $Msg = "Hello world";

$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$access_token}";

$arrayPostData['messages'][0]['type'] = "text";
$arrayPostData['messages'][0]['text'] = $Msg;

  replyMsg("https://api.line.me/v2/bot/message/broadcast", $arrayHeader, $arrayPostData);


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