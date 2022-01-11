<?php
// require "../vendor/autoload.php";
include './db_connect.php';
header ("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
$accessToken = "k3dpCHPmnU8h2tcQNkBEseVOKQZZZAXcTqp57qQIzsMqnmoleJxna5AtFd/Q6/1AEDph9zvbcUVAIWw5dRpnD897s4WwRO1q/liTOhPUI+Qm9JgHf4YF7lLP25Bou7Jd2INDKnuPsuAeOEZcSK8+rlGUYhWQfeY8sLGRXgo3xvw=";//copy Channel access token ตอนที่ตั้งค่ามาใส่
// $accessToken = getallheaders()['token'];
$json = file_get_contents('php://input');
$request = json_decode($json, true);
$queryText = $request["queryResult"]["queryText"];
$userId = $request['originalDetectIntentRequest']['payload']['data']['source']['userId'];
$replyToken = $request['originalDetectIntentRequest']['payload']['data']['replyToken'];
file_put_contents('./Log/Test_BOT.txt', file_get_contents('php://input') . PHP_EOL, FILE_APPEND);
$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$accessToken}";
$arrayPostData['replyToken'] = $replyToken;

// $usernameLine = profile($userId, $accessToken)['displayName'];
$massage =  explode(" : ",  $queryText);

if ($massage[0] == "ข้อมูลของโรงน้ำแข็ง") {
// 1
    $sql = "SELECT [site_name],[customer_no], [site_code] ,[factory_name] ,[ReplyLine] FROM [dbo].[VW_API_LINE_Site] WHERE [lineToken] = '$userId' ";
    $getResults = sqlsrv_query($conn, $sql);
    
    if (sqlsrv_has_rows($getResults) === TRUE) {
        $arrayDB = [];
        while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
            $Info = [];
            array_push($Info, $row["site_name"]);
            array_push($Info, $row["factory_name"]);
            array_push($Info, $row["ReplyLine"]);
            array_push($Info, $row["customer_no"]);
            array_push($Info, $row["site_code"]);
            array_push($arrayDB, $Info);
            //print_r($arrayDB);
        }
      
        if (count($arrayDB) > 0) {
            include("../FlexMassage-IC/Side.php");

            for ($i = 0; $i < count($arrayDB); $i++) {
                $arrayBoxNew['type'] = "button";
                $arrayBoxNew['action']['type'] = "message";
                $arrayBoxNew['action']['label'] = $arrayDB[$i][0];
                $arrayBoxNew['action']['text'] = "ข้อมูลของโรงน้ำแข็งที่เลือก : " . $arrayDB[$i][3] . " : " . $arrayDB[$i][4];
                $arrayBoxNew['color'] = "#144391";
                $arrayBoxNew['height'] = "sm";
                $arrayBoxNew['style'] = "primary";
                $arrayBoxNew['gravity'] = "top";
                array_push($jsonflex['contents']['footer']['contents'], $arrayBoxNew);
            }
            sleep(1);
            //print_r($jsonflex);
            $arrayPostData['messages'][0] = $jsonflex;

            replyMsg($arrayHeader, $arrayPostData);
        }
    }
 
} 
//2
else if ($massage[0] == "ข้อมูลของโรงน้ำแข็งที่เลือก") {

    
    
    $sql = "SELECT [site_name],[customer_no], [site_code] ,[factory_name] ,[ReplyLine] FROM [dbo].[VW_API_LINE_Site] WHERE [lineToken] = '$userId' AND [customer_no]= '$massage[1]' AND [site_code]  = '$massage[2]' ";
    $getResults = sqlsrv_query($conn, $sql);
    if (sqlsrv_has_rows($getResults) === TRUE) {
        $arrayDB = [];
        while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
            $Info = [];
            array_push($Info, $row["site_name"]);
            array_push($Info, $row["factory_name"]);
            array_push($Info, $row["ReplyLine"]);
            array_push($arrayDB, $Info);
            print_r($arrayDB);
        } 

        if (count($arrayDB) > 0) {
            include("../FlexMassage-IC/Factory.php");

            for ($i = 0; $i < count($arrayDB); $i++) {
                $arrayBoxNew['type'] = "button";
                $arrayBoxNew['action']['type'] = "message";
                $arrayBoxNew['action']['label'] = $arrayDB[$i][1];
                $arrayBoxNew['action']['text'] = $arrayDB[$i][2];
                $arrayBoxNew['color'] = "#144391";
                $arrayBoxNew['height'] = "sm";
                $arrayBoxNew['style'] = "primary";
                $arrayBoxNew['gravity'] = "top";
                array_push($jsonflex['contents']['footer']['contents'], $arrayBoxNew);
            }
            print_r($jsonflex);
            $arrayPostData['messages'][0] = $jsonflex;

            replyMsg($arrayHeader, $arrayPostData);
        }
    }
    
}  
//3
else if ($massage[0] == "ข้อมูลเครื่องจักรของโรงน้ำแข็ง") {

    
    
        $sql = "SELECT [main_machine_ID],[main_machine_desc],[customer_no] ,[site_code],[factory_no],[factory_name]  FROM [IOTPatkol].[dbo].[VW_API_Machine_Factory] WHERE [customer_no] = '$massage[1]' AND [site_code] = '$massage[2]' AND [factory_no] = '$massage[3]'";
         $getResults = sqlsrv_query($conn, $sql);
        if (sqlsrv_has_rows($getResults) === TRUE) {
            $arrayDB = [];
            while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
                $Info = [];
                array_push($Info, $row["main_machine_ID"]);
                array_push($Info, $row["main_machine_desc"]);
                array_push($Info, $row["customer_no"]);
                array_push($Info, $row["site_code"]);
                array_push($Info, $row["factory_no"]);
                array_push($Info, $row["factory_name"]);
                array_push($arrayDB, $Info);
            }

        if (count($arrayDB) > 0) {
            include("../FlexMassage-IC/Machine_Bubble.php");

            for ($i = 0; $i < count($arrayDB); $i++) {
                $arrayBoxNew['type'] = "button";
                $arrayBoxNew['action']['type'] = "message";
                $arrayBoxNew['action']['label'] = $arrayDB[$i][1];
                $arrayBoxNew['action']['text'] = "รายละเอียดเครื่องจักร : ". $arrayDB[$i][2] . " : " .$arrayDB[$i][4]. " : " .$arrayDB[$i][3]. " : " .$arrayDB[$i][0];
                $arrayBoxNew['color'] = "#144391";
                $arrayBoxNew['height'] = "sm";
                $arrayBoxNew['style'] = "primary";
                $arrayBoxNew['gravity'] = "top";
                array_push($jsonflex['contents']['footer']['contents'], $arrayBoxNew);
            }
            print_r($jsonflex);
            $arrayPostData['messages'][0] = $jsonflex;
            replyMsg($arrayHeader, $arrayPostData);

        }
    }
 
    
}

else if ($massage[0] == "รายละเอียดเครื่องจักร") {

    
    
    $sql = "SELECT [main_machine_ID],[main_machine_desc],[customer_no] ,[site_code],[factory_no],[factory_name]  FROM [IOTPatkol].[dbo].[VW_API_Machine_Factory] WHERE [customer_no] = '$massage[1]' AND [factory_no] = '$massage[2]' AND [site_code] = '$massage[3]' AND [main_machine_ID] = '$massage[4]'";
    $getResults = sqlsrv_query($conn, $sql);
    if (sqlsrv_has_rows($getResults) === TRUE) {
        $arrayDB = [];
        while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
                array_push($arrayDB, $row["main_machine_ID"]);
                array_push($arrayDB, $row["main_machine_desc"]);
                array_push($arrayDB, $row["customer_no"]);
                array_push($arrayDB, $row["site_code"]);
                array_push($arrayDB, $row["factory_no"]);
                array_push($arrayDB, $row["factory_name"]);
        }
     
        
        include("../FlexMassage-IC/Machine_Detail_Bubble.php");
            $arrayBoxNew['type'] = "button";
            $arrayBoxNew['action']['type'] = "message";
            $arrayBoxNew['action']['label'] = "สถานะการทำงาน";
            $arrayBoxNew['action']['text'] = "สถานะการทำงาน : ". $arrayDB[0] ;
            $arrayBoxNew['color'] = "#144391";
            $arrayBoxNew['height'] = "sm";
            $arrayBoxNew['style'] = "primary";
            $arrayBoxNew['gravity'] = "top";
            array_push($jsonflex['contents']['footer']['contents'], $arrayBoxNew);
            $arrayBoxNew['type'] = "button";
            $arrayBoxNew['action']['type'] = "message";
            $arrayBoxNew['action']['label'] = "ข้อมูลแบบละเอียด";
            $arrayBoxNew['action']['text'] = "ข้อมูลโดยละเอียด : ". $arrayDB[2] . " : " .$arrayDB[4]. " : " .$arrayDB[3]. " : " .$arrayDB[0];
            $arrayBoxNew['color'] = "#144391";
            $arrayBoxNew['height'] = "sm";
            $arrayBoxNew['style'] = "primary";
            $arrayBoxNew['gravity'] = "top";
            array_push($jsonflex['contents']['footer']['contents'], $arrayBoxNew);
        print_r($jsonflex);
        $arrayPostData['messages'][0] = $jsonflex;
        replyMsg($arrayHeader, $arrayPostData);
        
    }
  
    
}

else if ($massage[0] == "สถานะการทำงาน") {
 
    $sql = "EXEC SP_API_Line_Status_Machine '$massage[1]','Normal'";
    $getResults = sqlsrv_query($conn, $sql);

    if (sqlsrv_has_rows($getResults) === TRUE) {
        $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = $row['ReplyLine'];
        replyMsg($arrayHeader, $arrayPostData);
    }
 
}

else if ($massage[0] == "ข้อมูลโดยละเอียด") {
    $sql = "SELECT [main_machine_ID],[main_machine_desc],[customer_no] ,[site_code],[factory_no],[factory_name]  FROM [IOTPatkol].[dbo].[VW_API_Machine_Factory] WHERE [customer_no] = '$massage[1]' AND [factory_no] = '$massage[2]' AND [site_code] = '$massage[3]' AND [main_machine_ID] = '$massage[4]'";
      $getResults = sqlsrv_query($conn, $sql);
    
        if (sqlsrv_has_rows($getResults) === TRUE) {
            $Button = ['กำลังการผลิต','เวลาที่น้ำแข็งรอบต่อไปจะตก','สถานะของเครื่อง'];
            $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
            include("../FlexMassage-IC/Machine_Detail_data_Bubble.php");
            for ($i=0; $i < count($Button); $i++) {
                $arrayBoxNew['type'] = "button";
                $arrayBoxNew['action']['type'] = "message";
                $arrayBoxNew['action']['label'] = "$Button[$i]";
                $arrayBoxNew['action']['text'] = "$Button[$i] : ". $row['main_machine_ID'] ;
                $arrayBoxNew['color'] = "#144391";
                $arrayBoxNew['height'] = "sm";
                $arrayBoxNew['style'] = "primary";
                $arrayBoxNew['gravity'] = "top";
                array_push($jsonflex['contents']['footer']['contents'], $arrayBoxNew);
                
            }
            $arrayPostData['messages'][0] = $jsonflex;
            replyMsg($arrayHeader, $arrayPostData);
        }

} else if ($massage[0] == "กำลังการผลิต") {
     //Coding Temp(4/2/2020)*can't use \n for new line
    $sql = "EXEC SP_API_Line_Status_Machine_20203101 '$massage[1]','Cycle'";
    $getResults = sqlsrv_query($conn, $sql);
    
     if (sqlsrv_has_rows($getResults) === TRUE) {
         $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
         $row['ReplyLine'] = str_replace("(n)", "\n", $row['ReplyLine']);

         $arrayPostData['messages'][0]['type'] = "text";
         $arrayPostData['messages'][0]['text'] = $row['ReplyLine'] ;
       
         replyMsg($arrayHeader, $arrayPostData);
     }
 
}


else if ($massage[0] == "เวลาที่น้ำแข็งรอบต่อไปจะตก") {    
    $sql = "EXEC SP_API_Line_Status_Machine '$massage[1]','FreezingTime'"; //ERROR FreezingTime
    $getResults = sqlsrv_query($conn, $sql); 
    if (sqlsrv_has_rows($getResults) === TRUE) {
        $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = $row['ReplyLine'];
        replyMsg($arrayHeader, $arrayPostData);
    }

}else if ($massage[0] == "สถานะของเครื่อง") {
       
    $sql = "EXEC SP_API_Line_Status_Machine '$massage[1]','MachineStatus'"; //ERROR MachineStatus
    $getResults = sqlsrv_query($conn, $sql);
 
    if (sqlsrv_has_rows($getResults) === TRUE) {
        $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = $row['ReplyLine'];
        replyMsg($arrayHeader, $arrayPostData);
    }

}

else if($queryText == "token")
{
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = $userId;
        replyMsg($arrayHeader,$arrayPostData);
}
sqlsrv_close($conn);
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

exit;


