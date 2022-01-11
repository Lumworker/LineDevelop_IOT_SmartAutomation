<?php
$access_token = $_POST['Accesstoken'];
// $channelSecret = $_POST['channelSecret'];
$pushID = explode(";",  $_POST['TokenUser']);
$arrayMsg = $_POST['Image'];
print_r($arrayMsg );
// $access_token = 'y0Wkplvd9qOrcRsx/RBSpvkEc5NR+P1a78ju3UnrSEOO7Q70aDDAZXOvJ6AtwebyYNXuoSQ2wVp8kX7RFiy4gA8T41nttrmP5OXGdcdUSXWHp7iWGD85tIrAwSkoCYdRUnopXYei0KrowUKXe/9h6wdB04t89/1O/w1cDnyilFU=';

// $pushID = 'U1d3716eba447cb90bc808199b319922b';
// $arrayMsg = [
//   'Image' =>
//   [
//     ['https://www.petmd.com/sites/default/files/Acute-Dog-Diarrhea-47066074.jpg?hello=1234', 'message', 'Yes', 'text', 'yes'],
//     ['https://cdn.psychologytoday.com/sites/default/files/styles/article-inline-half/public/field_blog_entry_images/2018-02/vicious_dog_0.png?itok=nsghKOHs', 'uri', 'View detail', 'uri', 'http://example.com/page/222']
//   ]
// ];

$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$access_token}";

include("../FlexMassage/ImageCarousel.php");
$arrayPostData['messages'][0] = $jsonFlex;


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