<?php
    $accessToken = "2QFCK2OI2TlWFKuyqCBr+iVwaVNHjOzfygclG2zfbEt37z3m3pzxGAjPx99wKZAQYujCH5gv6SsM0QBz2YPvJr+iYDu6VLDLmBRWuE/LvIzDfPxBKu143G0mEwmbqlQgkaWymJLrLRw5H9acmr60PgdB04t89/1O/w1cDnyilFU=";//copy Channel access token ตอนที่ตั้งค่ามาใส่
    //Token
    $content = file_get_contents('php://input');
    $arrayJson = json_decode($content, true);
    file_put_contents('log.txt', file_get_contents('php://input') . PHP_EOL, FILE_APPEND);
    $arrayHeader = array();
    $arrayHeader[] = "Content-Type: application/json";
    $arrayHeader[] = "Authorization: Bearer {$accessToken}";
    //รับข้อความจากผู้ใช้
    // $message = $arrayJson['events'][0]['message']['text'];
    $UserToken = $arrayJson['events'][0]['source']['userId'];
    $postback = $arrayJson['events'][0]['postback']['data'];
#ตัวอย่าง Message Type "Text"
  
    // if ($postback == "richmenu2"){
    //     $richMenuId ="richmenu-62c4fd05949541d63a37ee6b3245cfb5";
    //     $Body[] = "richMenuId:$richMenuId";
    //     $Body[] = "userId:$UserToken";
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = $postback;
        replyMsg($arrayHeader,$arrayPostData);
        // unset($arrayHeader);
        // $arrayHeader[] = "Authorization: Bearer {$accessToken}";
    //     endpoint("https://api.line.me/v2/bot/user/$UserToken/richmenu/$richMenuId", $arrayHeader, $Body);
    // }
    // else if ($postback == "richmenu1"){
    //     $richMenuId ="richmenu-967abba3fad006d51c6997043ee7aba2";
    //     $Body[] = "richMenuId:$richMenuId";
    //     $Body[] = "userId:$UserToken";
    //     $arrayPostData['messages'][0]['type'] = "text";
    //     $arrayPostData['messages'][0]['text'] = $postback;
    //     replyMsg($arrayHeader,$arrayPostData);
    // //     unset($arrayHeader);
    // //    $arrayHeader[] = "Authorization: Bearer {$accessToken}";
        
    //     endpoint("https://api.line.me/v2/bot/user/$UserToken/richmenu/$richMenuId", $arrayHeader, $Body);
    // }

    // else {
    //     $arrayPostData['replyToken'] = $arrayJson['events'][0]['replyToken'];
    //     $arrayPostData['messages'][0]['type'] = "text";
    //     // $arrayPostData['messages'][0]['text'] = $UserToken ;
    //     $arrayPostData['messages'][0]['text'] = "มึงไม่มีสิทธิเรียกกูว่า ".$message." !!" ;
    //     replyMsg($arrayHeader,$arrayPostData);
    // }
    
    
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