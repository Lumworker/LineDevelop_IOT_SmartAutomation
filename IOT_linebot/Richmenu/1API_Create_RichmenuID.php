<?php
$access_token = 'oBMZMMuMVxboOZUW8cWoPeS3FrFMey/Z6ffz+kPiO3lFzDr/4DTFl7+iXFIdeJ9HuRG5mxq0tmay1ndBQ6qKCX3tZo0m1kLcO0IWQ4AyXEpjoZewZiw6f6xpG7uNfrZYyqta0Ka5dA7R7g5YA+rGewdB04t89/1O/w1cDnyilFU=';
$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$access_token}";

include("./Richmenu_attr/Tubeice_menu.php");

  echo (endpoint("https://api.line.me/v2/bot/richmenu", $arrayHeader,$Body));


function endpoint($url, $arrayHeader,$Body)
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