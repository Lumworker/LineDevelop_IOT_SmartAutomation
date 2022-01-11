<?php
$access_token = 'oBMZMMuMVxboOZUW8cWoPeS3FrFMey/Z6ffz+kPiO3lFzDr/4DTFl7+iXFIdeJ9HuRG5mxq0tmay1ndBQ6qKCX3tZo0m1kLcO0IWQ4AyXEpjoZewZiw6f6xpG7uNfrZYyqta0Ka5dA7R7g5YA+rGewdB04t89/1O/w1cDnyilFU=';
$arrayHeader = array();

$richMenuId ="richmenu-61fa40bc18fab085f5ef5462641bb813";
$Body = "../Images/Step3_Tubeeice.png";
$arrayHeader[] = "Content-Type: image/png";
$arrayHeader[] = "Authorization: Bearer {$access_token}";
$c = file_get_contents($Body,true);
  echo (endpoint("https://api-data.line.me/v2/bot/richmenu/$richMenuId/content", $arrayHeader ,$c ));

function endpoint($url, $arrayHeader,$Body)
{
  $strUrl = $url;
  $ch = curl_init();
  curl_setopt($ch, CURLOPT_URL, $strUrl);
  curl_setopt($ch, CURLOPT_HEADER, false);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);
  curl_setopt($ch, CURLOPT_POSTFIELDS, $Body);
  curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
  curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
  $result = curl_exec($ch);
  curl_close($ch);
  return $result;
}

