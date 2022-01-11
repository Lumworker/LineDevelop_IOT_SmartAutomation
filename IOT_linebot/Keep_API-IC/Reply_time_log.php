<?php
// require "../vendor/autoload.php";
include './db_connect.php';
header ("Last-Modified: " . gmdate ("D, d M Y H:i:s") . " GMT");
$accessToken = "vn6FAZOgRTZCzMnD4FpPAf0bmLx3cdOBGq6rsS7umCO+KglToVBAFUjCod3kCdhlvfcNdqkwPbFrGNtMRGEW7uXi4uE+YSK/kieDwhPEzbenIVsx4dnRaXb71hlxEPaDvSQQ0d5lmAF0dtRKbPCiEgdB04t89/1O/w1cDnyilFU=";//copy Channel access token ตอนที่ตั้งค่ามาใส่
// $accessToken = getallheaders()['token'];
$json = file_get_contents('php://input');
$request = json_decode($json, true);
$queryText = $request["queryResult"]["queryText"];
$userId = $request['originalDetectIntentRequest']['payload']['data']['source']['userId'];
$replyToken = $request['originalDetectIntentRequest']['payload']['data']['replyToken'];
// file_put_contents('./Log/Test_BOT.txt', file_get_contents('php://input') . PHP_EOL, FILE_APPEND);
$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$accessToken}";
$arrayPostData['replyToken'] = $replyToken;

date_default_timezone_set("Asia/Bangkok");
$myfile = fopen("./Log/".date("h").".txt", "a") or die("Unable to open file!");

// $usernameLine = profile($userId, $accessToken)['displayName'];
$massage =  explode(" : ",  $queryText);

if ($massage[0] == "ข้อมูลของโรงน้ำแข็ง") {
// 1
    $txt = $massage[0]."\r\n"." [Query Start] : ".SaveTimeLog()."\r\n";
    fwrite($myfile, $txt);
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
        $txt = " [Query End] : ".SaveTimeLog()."\r\n";
        fwrite($myfile, $txt);

        $txt = " [FLEX Start] : ".SaveTimeLog()."\r\n";
        fwrite($myfile, $txt);
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
            // sleep(1);
            //print_r($jsonflex);
            $arrayPostData['messages'][0] = $jsonflex;

            replyMsg($arrayHeader, $arrayPostData);
        }
    }
    $txt = " [FLEX End] : ".SaveTimeLog()."\r\n";
    fwrite($myfile, $txt);
    $txt = " ________________________________________________ "."\r\n";
    fwrite($myfile, $txt);
} 
//2
else if ($massage[0] == "ข้อมูลของโรงน้ำแข็งที่เลือก") {

    $txt = $massage[0]."\r\n"." [Query Start] : ".SaveTimeLog()."\r\n";
    fwrite($myfile, $txt);
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

        $txt = " [Query End] : ".SaveTimeLog()."\r\n";
        fwrite($myfile, $txt);

        $txt = " [FLEX Start] : ".SaveTimeLog()."\r\n";
        fwrite($myfile, $txt);

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
    $txt = " [FLEX End] : ".SaveTimeLog()."\r\n";
    fwrite($myfile, $txt);
    $txt = " ________________________________________________ "."\r\n";
    fwrite($myfile, $txt);
}  
//3
else if ($massage[0] == "ข้อมูลเครื่องจักรของโรงน้ำแข็ง") {

    $txt = $massage[0]."\r\n"." [Query Start] : ".SaveTimeLog()."\r\n";
    fwrite($myfile, $txt);
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
        $txt = " [Query End] : ".SaveTimeLog()."\r\n";
        fwrite($myfile, $txt);

        $txt = " [FLEX Start] : ".SaveTimeLog()."\r\n";
        fwrite($myfile, $txt);

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
    $txt = " [FLEX End] : ".SaveTimeLog()."\r\n";
    fwrite($myfile, $txt);
    $txt = " ________________________________________________ "."\r\n";
    fwrite($myfile, $txt);
}

else if ($massage[0] == "รายละเอียดเครื่องจักร") {

    $txt = $massage[0]."\r\n"." [Query Start] : ".SaveTimeLog()."\r\n";
    fwrite($myfile, $txt);
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
        $txt = " [Query End] : ".SaveTimeLog()."\r\n";
        fwrite($myfile, $txt);

        $txt = " [FLEX Start] : ".SaveTimeLog()."\r\n";
        fwrite($myfile, $txt);
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
    $txt = " [FLEX End] : ".SaveTimeLog()."\r\n";
    fwrite($myfile, $txt);
    $txt = " ________________________________________________ "."\r\n";
    fwrite($myfile, $txt);
}

else if ($massage[0] == "สถานะการทำงาน") {
    $txt = $massage[0]."\r\n"." [Query Start] : ".SaveTimeLog()."\r\n";
    fwrite($myfile, $txt);
    $sql = "EXEC SP_API_Line_Status_Machine '$massage[1]','Normal'";
    $getResults = sqlsrv_query($conn, $sql);
    $txt = " [Query End] : ".SaveTimeLog()."\r\n";
        fwrite($myfile, $txt);

    $txt = " [Msg Start] : ".SaveTimeLog()."\r\n";
    fwrite($myfile, $txt);

    if (sqlsrv_has_rows($getResults) === TRUE) {
        $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = $row['ReplyLine'];
        replyMsg($arrayHeader, $arrayPostData);
    }
    $txt = " [Msg End] : ".SaveTimeLog()."\r\n";
    fwrite($myfile, $txt);
    $txt = " ________________________________________________ "."\r\n";
    fwrite($myfile, $txt);
}

else if ($massage[0] == "ข้อมูลโดยละเอียด") {

     $txt = $massage[0]."\r\n"." [Query Start] : ".SaveTimeLog()."\r\n";
    fwrite($myfile, $txt);
    $sql = "SELECT [main_machine_ID],[main_machine_desc],[customer_no] ,[site_code],[factory_no],[factory_name]  FROM [IOTPatkol].[dbo].[VW_API_Machine_Factory] WHERE [customer_no] = '$massage[1]' AND [factory_no] = '$massage[2]' AND [site_code] = '$massage[3]' AND [main_machine_ID] = '$massage[4]'";
      $getResults = sqlsrv_query($conn, $sql);
       $txt = " [Query End] : ".SaveTimeLog()."\r\n";
            fwrite($myfile, $txt);
    
        if (sqlsrv_has_rows($getResults) === TRUE) {
            //Buttonname
            $Button = ['กำลังการผลิต','เวลาที่น้ำแข็งรอบต่อไปจะตก','สถานะของเครื่อง'];

            $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
            include("../FlexMassage-IC/Machine_Detail_data_Bubble.php");
            $txt = " [FLEX Start] : ".SaveTimeLog()."\r\n";
            fwrite($myfile, $txt);
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
    $txt = " [FLEX End] : ".SaveTimeLog()."\r\n";
    fwrite($myfile, $txt);
    $txt = " ________________________________________________ "."\r\n";
    fwrite($myfile, $txt);

} else if ($massage[0] == "กำลังการผลิต") {
     //Coding Temp(4/2/2020)*can't use \n for new line
    $txt = $massage[0]."\r\n"." [Query Start] : ".SaveTimeLog()."\r\n";
    fwrite($myfile, $txt);
    $sql = "EXEC SP_API_Line_Status_Machine_20203101 '$massage[1]','Cycle'";
    $getResults = sqlsrv_query($conn, $sql);
    $txt = " [Query End] : ".SaveTimeLog()."\r\n";
    fwrite($myfile, $txt);

    $txt = " [Msg Start] : ".SaveTimeLog()."\r\n";
    fwrite($myfile, $txt);
     if (sqlsrv_has_rows($getResults) === TRUE) {
         $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
         $row['ReplyLine'] = str_replace("(n)", "\n", $row['ReplyLine']);

         $arrayPostData['messages'][0]['type'] = "text";
         $arrayPostData['messages'][0]['text'] = $row['ReplyLine'] ;
       
         replyMsg($arrayHeader, $arrayPostData);
     }
    $txt = " [Msg End] : ".SaveTimeLog()."\r\n";
    fwrite($myfile, $txt);
    $txt = " ________________________________________________ "."\r\n";
    fwrite($myfile, $txt);
}


else if ($massage[0] == "เวลาที่น้ำแข็งรอบต่อไปจะตก") {
    $txt = $massage[0]."\r\n"." [Query Start] : ".SaveTimeLog()."\r\n";
    fwrite($myfile, $txt);
    $sql = "EXEC SP_API_Line_Status_Machine '$massage[1]','FreezingTime'"; //ERROR FreezingTime
    $getResults = sqlsrv_query($conn, $sql);
    $txt = " [Query End] : ".SaveTimeLog()."\r\n";
        fwrite($myfile, $txt);
        
    $txt = " [Msg Start] : ".SaveTimeLog()."\r\n";
    fwrite($myfile, $txt);
    if (sqlsrv_has_rows($getResults) === TRUE) {
        $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = $row['ReplyLine'];
        replyMsg($arrayHeader, $arrayPostData);
    }
    $txt = " [Msg End] : ".SaveTimeLog()."\r\n";
    fwrite($myfile, $txt);
    $txt = " ________________________________________________ "."\r\n";
    fwrite($myfile, $txt);

}else if ($massage[0] == "สถานะของเครื่อง") {
    $txt = $massage[0]."\r\n"." [Query Start] : ".SaveTimeLog()."\r\n";
    fwrite($myfile, $txt);
    $sql = "EXEC SP_API_Line_Status_Machine '$massage[1]','MachineStatus'"; //ERROR MachineStatus
    $getResults = sqlsrv_query($conn, $sql);
    $txt = " [Query End] : ".SaveTimeLog()."\r\n";
        fwrite($myfile, $txt);
        
    $txt = " [Msg Start] : ".SaveTimeLog()."\r\n";
    fwrite($myfile, $txt);
    if (sqlsrv_has_rows($getResults) === TRUE) {
        $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = $row['ReplyLine'];
        replyMsg($arrayHeader, $arrayPostData);
    }
    $txt = " [Msg End] : ".SaveTimeLog()."\r\n";
    fwrite($myfile, $txt);
    $txt = " ________________________________________________ "."\r\n";
    fwrite($myfile, $txt);
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

function SaveTimeLog()
{
    $now = DateTime::createFromFormat('U.u', microtime(true));
    date_timezone_set($now, timezone_open('Asia/Bangkok'));
   
    return ($now->format("i s.u"));
}
exit;


