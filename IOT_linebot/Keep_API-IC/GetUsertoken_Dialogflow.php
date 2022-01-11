<?php
// require "../vendor/autoload.php";
// include './db_connect.php';
// $accessToken = "y0Wkplvd9qOrcRsx/RBSpvkEc5NR+P1a78ju3UnrSEOO7Q70aDDAZXOvJ6AtwebyYNXuoSQ2wVp8kX7RFiy4gA8T41nttrmP5OXGdcdUSXWHp7iWGD85tIrAwSkoCYdRUnopXYei0KrowUKXe/9h6wdB04t89/1O/w1cDnyilFU=";//copy Channel access token ตอนที่ตั้งค่ามาใส่
$accessToken = getallheaders()['token'];
$json = file_get_contents('php://input');
$request = json_decode($json, true);
$queryText = $request["queryResult"]["queryText"];
$userId = $request['originalDetectIntentRequest']['payload']['data']['source']['userId'];
$replyToken = $request['originalDetectIntentRequest']['payload']['data']['replyToken'];
file_put_contents('Dialogflow.txt', file_get_contents('php://input') . PHP_EOL, FILE_APPEND);
$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$accessToken}";
$arrayPostData['replyToken'] = $replyToken;
$usernameLine = profile($userId,$accessToken)['displayName'];


if($queryText == "token")
{

        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = $userId;
        replyMsg($arrayHeader,$arrayPostData);

}
function profile($userId,$accessToken){
    $urlprofile = 'https://api.line.me/v2/bot/profile/'.$userId;
    $headers = array('Authorization: Bearer ' . $accessToken );
    $profileline = curl_init($urlprofile);
    curl_setopt($profileline, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($profileline, CURLOPT_HTTPHEADER, $headers);
    curl_setopt($profileline, CURLOPT_FOLLOWLOCATION, 1);
    $resultprofile = curl_exec($profileline);
    curl_close($profileline);
    return json_decode($resultprofile, true); 
}


function replyMsg($arrayHeader,$arrayPostData){
    $strUrl = "https://api.line.me/v2/bot/message/reply";
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
exit;
   

?>
