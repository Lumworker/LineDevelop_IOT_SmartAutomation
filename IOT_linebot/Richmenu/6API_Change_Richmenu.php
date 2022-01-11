<?php
$access_token = 'oBMZMMuMVxboOZUW8cWoPeS3FrFMey/Z6ffz+kPiO3lFzDr/4DTFl7+iXFIdeJ9HuRG5mxq0tmay1ndBQ6qKCX3tZo0m1kLcO0IWQ4AyXEpjoZewZiw6f6xpG7uNfrZYyqta0Ka5dA7R7g5YA+rGewdB04t89/1O/w1cDnyilFU=';
$arrayHeader = array();
$Body = array();

// $richMenuId ="richmenu-b8fb4981a0a96b1b50a7b5968c23a68f";
$richMenuId ="richmenu-5a48d3a987847d6203fe7f6ce8ab8e66";

$userID = ["Ud205faa9bce3595ac9961fcb6c2c85c1","Ud8831cb0a337722b1bfd3f747c76febe"];


$arrayHeader[] = "Authorization: Bearer {$access_token}";

if (count($userID) != 1) {
  $arrayHeader[] = "Content-Type: application/json";
  $Body[] = "richMenuId:$richMenuId";
  $Body[] = "userIds:$userID";
  print_r($arrayHeader);
  print_r($Body);
  echo (endpoint("https://api.line.me/v2/bot/richmenu/bulk/link", $arrayHeader, $Body));
 
}
else
{
  $Body[] = "richMenuId:$richMenuId";
  $Body[] = "userId:$userID[0]";
  // print_r($Body);
  echo (endpoint("https://api.line.me/v2/bot/user/$userID[0]/richmenu/$richMenuId", $arrayHeader, $Body));
}
  function endpoint($url, $arrayHeader, $Body)
  {
    $strUrl = $url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $strUrl);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($Body));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
  }