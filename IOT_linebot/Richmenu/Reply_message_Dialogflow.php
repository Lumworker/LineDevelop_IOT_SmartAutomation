<?php

// include('../db_connect.php');
$accessToken = "oBMZMMuMVxboOZUW8cWoPeS3FrFMey/Z6ffz+kPiO3lFzDr/4DTFl7+iXFIdeJ9HuRG5mxq0tmay1ndBQ6qKCX3tZo0m1kLcO0IWQ4AyXEpjoZewZiw6f6xpG7uNfrZYyqta0Ka5dA7R7g5YA+rGewdB04t89/1O/w1cDnyilFU=";//copy Channel access token ตอนที่ตั้งค่ามาใส่
// $accessToken = getallheaders()['token'];
$json = file_get_contents('php://input');
$request = json_decode($json, true);
// $queryText = $request["queryResult"];
$queryText = $request["queryResult"]["queryText"];
file_put_contents('Dialogflow.txt', file_get_contents('php://input') . PHP_EOL, FILE_APPEND);
$userId = $request['originalDetectIntentRequest']['payload']['data']['source']['userId'];
$replyToken = $request['originalDetectIntentRequest']['payload']['data']['replyToken'];
$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$Body =array();
$arrayHeader[] = "Authorization: Bearer {$accessToken}";
$arrayPostData['replyToken'] = $replyToken;
$message =  explode(" : ",  $queryText);


print_r (profile($userId, $accessToken)) ;  
echo  profile($userId, $accessToken)['statusMessage'] ; 



if(strtolower($message[0]) == "token"){
    $arrayPostData['messages'][0]['type'] = "text";
    $arrayPostData['messages'][0]['text'] = $userId;
  
    replyMsg($arrayHeader,$arrayPostData);
} 

else if($message[0] == "main"){
 
  $richMenuId ="richmenu-2cad042d883ffcd4a9baabaf760e508b";
  $Body[] = "richMenuId:$richMenuId";
  $Body[] = "userId:$userId";
  $richHeader2[] = array();
  $richHeader2[] = "Authorization: Bearer {$accessToken}";
  replyMsg($arrayHeader, $arrayPostData);

  endpoint("https://api.line.me/v2/bot/user/$userId/richmenu/$richMenuId", $richHeader2, $Body);
} 
else if($message[0] == "Tube Ice menu"){
 
  $richMenuId ="richmenu-c2ff6af4c559f9c167a06e8363b03e20";
  $Body[] = "richMenuId:$richMenuId";
  $Body[] = "userId:$userId";
  $richHeader2[] = array();
  $richHeader2[] = "Authorization: Bearer {$accessToken}";
  replyMsg($arrayHeader, $arrayPostData);

  endpoint("https://api.line.me/v2/bot/user/$userId/richmenu/$richMenuId", $richHeader2, $Body);
} 
else if($message[0] == "Plate Ice menu"){
 
  $richMenuId ="richmenu-61fa40bc18fab085f5ef5462641bb813";
  $Body[] = "richMenuId:$richMenuId";
  $Body[] = "userId:$userId";
  $richHeader2[] = array();
  $richHeader2[] = "Authorization: Bearer {$accessToken}";
  replyMsg($arrayHeader, $arrayPostData);

  endpoint("https://api.line.me/v2/bot/user/$userId/richmenu/$richMenuId", $richHeader2, $Body);
} 
else if($message[0] == "Register"){
 
  $richMenuId ="richmenu-4d7d14b00f5d96407ac6dfea683d1a2d";
  $Body[] = "richMenuId:$richMenuId";
  $Body[] = "userId:$userId";
  $richHeader2[] = array();
  $richHeader2[] = "Authorization: Bearer {$accessToken}";
  replyMsg($arrayHeader, $arrayPostData);

  endpoint("https://api.line.me/v2/bot/user/$userId/richmenu/$richMenuId", $richHeader2, $Body);
} 


// else if (strtolower($message[0]) == "old emoji"){
//     $Msg_Line_Stop ="(E)100096 LINE emoji OLD (E)100085";
//     //Emoji Index
//     $emoji = [];
//     $message =  explode("(E)", $Msg_Line_Stop);
//     for ($j = 1; $j < count($message); $j++) { //ดึงค่าตัวเลข จาก(E)ไปใส่ Array
//       array_push($emoji, substr($message[$j], 0, 6));
//     }

//     for ($j = 0; $j < count($emoji); $j++) { //เอาค่า ในArray มาreplace แทน ตัวเลขหลัง E
//       $Msg_Line_Stop = str_replace($emoji[$j], EncodeEmoji($emoji[$j]), $Msg_Line_Stop);
//     }
//     $Msg_Line_Stop = str_replace("(E)", "", $Msg_Line_Stop); //ลบ(E)ทิ้ง
//     $arrayPostData['messages'][0]['type'] = "text";
//     $arrayPostData['messages'][0]['text'] = $Msg_Line_Stop;
//     replyMsg($arrayHeader,$arrayPostData);
// }


function EncodeEmoji($inputemoji)
{
  $bin = hex2bin(str_repeat('0', 8 - strlen($inputemoji)) . $inputemoji);
  $emojiOutput = mb_convert_encoding($bin, 'UTF-8', 'UTF-32BE');
  return $emojiOutput;
}


function profile($userId, $accessToken)
{
    $urlprofile = 'https://api.line.me/v2/bot/profile/' . $userId;
    $headers = array('Authorization: Bearer ' . $accessToken);
    $profileline = curl_init($urlprofile);
    curl_setopt($profileline, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($profileline, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($profileline, CURLOPT_FOLLOWLOCATION, 1);
    $resultprofile = curl_exec($profileline);
    curl_close($profileline);
    return json_decode($resultprofile, true);
}


function replyMsg($arrayHeader, $arrayPostData)
{
    $strUrl = "https://api.line.me/v2/bot/message/reply";
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

exit;



?>

