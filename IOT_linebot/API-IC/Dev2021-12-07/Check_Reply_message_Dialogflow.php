<?php
// require "../vendor/autoload.php";
include './db_connect.php';
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
$accessToken = "mab9HWhQl17VsKAJXxlECoKOZ2bKoT3igeK/kJaAbN9KQcn5DDxj4fpyoqyvp/R2rWKrX0TiEilobD9EkurmygYSUUNSVTGbMg2H66JOJkQcppzJH4JRnK/jCmN4B2iDx0CRG/+NTtob2vYhUDhgGAdB04t89/1O/w1cDnyilFU="; //copy Channel access token ตอนที่ตั้งค่ามาใส่
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

// $usernameLine = profile($userId, $accessToken)['displayName'];
$massage =  explode(" : ",  $queryText);

date_default_timezone_set('Asia/Bangkok');
$Year = date('Y/m/d');
$Time = date('H:i');
$Date = $Year ."  ".$Time;

//---------PMS Step1----------
if ($massage[0] == "แจ้งยอดการผลิต") {
    $sql = "EXEC [dbo].[SP_CheckRole_Production_Data] '" . $userId . "','1'";
    $getResults = sqlsrv_query($conn, $sql);
    $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
    $haveRole = $row['haveRole'];
    if ($haveRole == "1") { //มีสิทธิ
        $sql0 = "EXEC [SP_GET_Production_Check_TV] '" . $userId . "','Operator'"; //-- check สถานะการแจ้งยอดล่าสุด
        $getResults0 = sqlsrv_query($conn, $sql0);
        $row0 = sqlsrv_fetch_array($getResults0, SQLSRV_FETCH_ASSOC);
        $statusPlan = $row0['statusPlan'];
        $trans_id = $row0['trans_id'];
        if ($statusPlan == "") { //Trans_id ล่าสุด เป็น สถานะ Complete
            include("./FlexMassage-IC/PMS_Start.php");
            $arrayPostData['messages'][0] = $jsonflex;
            replyMsg($arrayHeader, $arrayPostData);
        } else if ($statusPlan == "await" || $statusPlan == "confirmed") { //Trans_id ล่าสุดยังอยู่ใน  Step ของ Technician
            $sql2 = "EXEC [SP_GET_Production_DATA_TV] '" . $userId . "','$trans_id','Flex_Operator'";
            $getResults2 = sqlsrv_query($conn, $sql2);
            $row2 = sqlsrv_fetch_array($getResults2, SQLSRV_FETCH_ASSOC);
            $B = $row2['B'];
            $PB = $row2['PB'];
            $P2 = $row2['P2'];
            $PC_B = $row2['PC_B'];
            $R = $row2['R'];
            $S = $row2['S'];
            $PS = $row2['PS'];
            $PC_S = $row2['PC_S'];
            include("./FlexMassage-IC/PMS_Operator_Step2.php");
            $arrayPostData['messages'][0] = $jsonFlex;
            replyMsg($arrayHeader, $arrayPostData);
        } else if ($statusPlan == "new") { //Trans_id ล่าสุดยังอยู่ใน  Step ของ Operator
            $sql2 = "EXEC [SP_GET_Production_DATA_TV] '" . $userId . "','$trans_id','Flex_Operator'";
            $getResults2 = sqlsrv_query($conn, $sql2);
            $row2 = sqlsrv_fetch_array($getResults2, SQLSRV_FETCH_ASSOC);
            $B = $row2['B'];
            $PB = $row2['PB'];
            $P2 = $row2['P2'];
            $PC_B = $row2['PC_B'];
            $R = $row2['R'];
            $S = $row2['S'];
            $PS = $row2['PS'];
            $PC_S = $row2['PC_S'];
            include("./FlexMassage-IC/PMS_Operator_Step1.php");
            $arrayPostData['messages'][0] = $jsonFlex;
            replyMsg($arrayHeader, $arrayPostData);
        }
    } else {
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "ท่านไม่มีสิทธิในการแจ้งยอดการผลิต";
        replyMsg($arrayHeader, $arrayPostData);
    }
}
//---------PMS Step Return ----------
else if ($massage[0] == "แก้ไขยอดการผลิต" || $massage[0] == "แก้ไขแจ้งยอดการผลิต") {
    $sql = "EXEC [dbo].[SP_CheckRole_Production_Data] '" . $userId . "','1'";
    $getResults = sqlsrv_query($conn, $sql);
    $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
    $haveRole = $row['haveRole'];
    if ($haveRole == "1") { //มีสิทธิ
        $sql0 = "EXEC [SP_GET_Production_Check_TV] '" . $userId . "','Operator'"; //-- check สถานะการแจ้งยอดล่าสุด
        $getResults0 = sqlsrv_query($conn, $sql0);
        $row0 = sqlsrv_fetch_array($getResults0, SQLSRV_FETCH_ASSOC);
        $statusPlan = $row0['statusPlan'];
        $trans_id = $row0['trans_id'];
            include("./FlexMassage-IC/PMS_Operator_Rewrite.php");
            $arrayPostData['messages'][0] = $jsonflex;
            replyMsg($arrayHeader, $arrayPostData);
    } else {
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = "ท่านไม่มีสิทธิในการแจ้งยอดการผลิต";
        replyMsg($arrayHeader, $arrayPostData);
    }
}
//---------PMS Step2----------
else if ($massage[0] == "Operator") {
    $sql = "EXEC [dbo].[SP_CheckRole_Production_Data] '" . $userId . "','1'";
    $getResults = sqlsrv_query($conn, $sql);
    if (sqlsrv_has_rows($getResults) === TRUE) {
        //--------- PMS Step2 - 1 ----------
        if ($massage[1] == "แจ้งยอดการผลิต") {
            $trans_id = $massage[2];
            $sql2 = "EXEC [SP_GET_Production_DATA_TV] '" . $userId . "','$trans_id','Flex_Operator'";
            $getResults2 = sqlsrv_query($conn, $sql2);
            $row2 = sqlsrv_fetch_array($getResults2, SQLSRV_FETCH_ASSOC);
            $B = $row2['B'];
            $PB = $row2['PB'];
            $P2 = $row2['P2'];
            $PC_B = $row2['PC_B'];
            $R = $row2['R'];
            $S = $row2['S'];
            $PS = $row2['PS'];
            $PC_S = $row2['PC_S'];
            include("./FlexMassage-IC/PMS_Operator_Step1.php");
            $arrayPostData['messages'][0] = $jsonFlex;
            replyMsg($arrayHeader, $arrayPostData);
        }
        //--------- PMS Step2 - 2----------
        else if ($massage[1] == "ยืนยันแจ้งยอดการผลิต") {
            $trans_id = $massage[2];
            $sql0 = "EXEC [dbo].[SP_Check_Confirm_Production_Data] " . $trans_id;
            $getResults0 = sqlsrv_query($conn, $sql0);
            $row0 = sqlsrv_fetch_array($getResults0, SQLSRV_FETCH_ASSOC);
            if ($row0['role1_confirm'] == "0") {
                $sql2 = "EXEC [dbo].[SP_Update_Production_Data] " . $trans_id . ",1";
                $getResults2 = sqlsrv_query($conn, $sql2);
                $row2 = sqlsrv_fetch_array($getResults2, SQLSRV_FETCH_ASSOC);
                $replymsg = "Operator บันทึกเข้าระบบเรียบร้อย";
            } else if ($row0['role1_confirm'] == "1") {
                $replymsg = "Operator เคยบันทึกไปแล้ว กรุณารอ TimeKeeper ตรวจสอบ";
            }
            $arrayPostData['messages'][0]['type'] = "text";
            $arrayPostData['messages'][0]['text'] = $replymsg;
            replyMsg($arrayHeader, $arrayPostData);

            if ($replymsg == "Operator บันทึกเข้าระบบเรียบร้อย") {
                $sql3 = "EXEC [dbo].[SP_GET_Production_Data_Line] '" . $userId . "','" . $trans_id . "'";
                $getResults3 = sqlsrv_query($conn, $sql3);
                $row3 = sqlsrv_fetch_array($getResults3, SQLSRV_FETCH_ASSOC);
                $B = $row3['B'];
                $PB = $row3['PB'];
                $P2 = $row3['P2'];
                $PC_B = $row3['PC_B'];
                $R = $row3['R'];
                $S = $row3['S'];
                $PS = $row3['PS'];
                $PC_S = $row3['PC_S'];
                $LineToken_User2 = $row3['LineToken_User2'];
                include("./FlexMassage-IC/PMS_Technician_Step1.php"); //แปะ $trans_id ทีี่ปุ่ม link
                $pushID = array();
                array_push($pushID, $LineToken_User2);
                // array_push($pushID, 'U58f9aa06ab1292a9f548b48f0eea62d7'); //พี่มาย
                // array_push($pushID, 'U0cfb6e104a4950d326e9b5354ec6f8dd');//อ๋อง
                $arrayPush['messages'][0] = $jsonFlex;
                API_Push($pushID, $arrayPush, $arrayHeader);
            }
        }
        else if ($massage[1] == "ยืนยันแก้ไขยอดการผลิต"){
        $trans_id = $massage[2];
        $sql0 = "EXEC [dbo].[SP_Update_Production_Data] " . $trans_id . ",999";
        $getResults0 = sqlsrv_query($conn, $sql0);
        $row0 = sqlsrv_fetch_array($getResults0, SQLSRV_FETCH_ASSOC);
        
        $sql2 = "EXEC [SP_GET_Production_DATA_TV] '" . $userId . "','$trans_id','Flex_Operator'";
        $getResults2 = sqlsrv_query($conn, $sql2);
        $row2 = sqlsrv_fetch_array($getResults2, SQLSRV_FETCH_ASSOC);
        $B = $row2['B'];
        $PB = $row2['PB'];
        $P2 = $row2['P2'];
        $PC_B = $row2['PC_B'];
        $R = $row2['R'];
        $S = $row2['S'];
        $PS = $row2['PS'];
        $PC_S = $row2['PC_S'];
        include("./FlexMassage-IC/PMS_Operator_Step1.php");
        $arrayPostData['messages'][0] = $jsonFlex;
        replyMsg($arrayHeader, $arrayPostData);

        $sql3 = "EXEC [dbo].[SP_GET_Production_Data_Line] '" . $userId . "','" . $trans_id . "'";
        $getResults3 = sqlsrv_query($conn, $sql3);
        $row3 = sqlsrv_fetch_array($getResults3, SQLSRV_FETCH_ASSOC);
        $pushID = array();
        $LineToken_User2 = $row3['LineToken_User2'];
        $LineToken_User3 = $row3['LineToken_User3'];
        array_push($pushID, $LineToken_User2);
        array_push($pushID, $LineToken_User3);
        $arrayPush['messages'][0]['type'] = "text";
        $arrayPush['messages'][0]['text'] = "Operater ได้ทำการแก้ไข ยอดการผลิต";
        API_Push($pushID, $arrayPush, $arrayHeader);
        }
    }
} else if ($massage[0] == "Technician") {
    $trans_id = $massage[2];
    if ($massage[1] == "แจ้งยอดการผลิต") {
        $sql2 = "EXEC [dbo].[SP_GET_Production_Data_Line] '" . $userId . "','" . $trans_id . "'";
        $getResults2 = sqlsrv_query($conn, $sql2);
        $row2 = sqlsrv_fetch_array($getResults2, SQLSRV_FETCH_ASSOC);
        $Cycle_B = $row2['Cycle_B'];
        $Cycle_S = $row2['Cycle_S'];
        $B = $row2['B'];
        $PB = $row2['PB'];
        $P2 = $row2['P2'];
        $PC_B = $row2['PC_B'];
        $R = $row2['R'];
        $S = $row2['S'];
        $PS = $row2['PS'];
        $PC_S = $row2['PC_S'];
        $LineToken_User3 = $row2['LineToken_User3'];

        include("./FlexMassage-IC/PMS_Technician_Step2.php"); //แปะ $trans_id ทีี่ปุ่ม link
        $sql3 = "EXEC [dbo].[SP_GET_Production_Data_Line] '" . $userId . "','" . $trans_id . "'";
        $getResults3 = sqlsrv_query($conn, $sql3);
        while ($row3 = sqlsrv_fetch_array($getResults3, SQLSRV_FETCH_ASSOC)) {
            $arrayBoxNew = [];
            $main_machine_ID = $row3['main_machine_ID'];
            $Size = $row3['Size'];
            $Cycle = $row3['Cycle'];
            $arrayBoxNew['type'] = "box";
            $arrayBoxNew['layout'] = "baseline";
            $arrayBoxNew['contents'][0]['type'] = "text";
            $arrayBoxNew['contents'][0]['text'] = $main_machine_ID;
            $arrayBoxNew['contents'][0]['flex'] = 0;
            $arrayBoxNew['contents'][0]['margin'] = "sm";
            $arrayBoxNew['contents'][0]['contents'] = [];
            $arrayBoxNew['contents'][1]['type'] = "text";
            $arrayBoxNew['contents'][1]['text'] = $Cycle . "รอบ";
            $arrayBoxNew['contents'][1]['size'] = "md";
            $arrayBoxNew['contents'][1]['color'] = "#000000FF";
            $arrayBoxNew['contents'][1]['align'] = "end";
            $arrayBoxNew['contents'][1]['contents'] = [];
            if ($Size == "B") {
                array_push($jsonflex['contents']['body']['contents'][2]['contents'], $arrayBoxNew);
            } else if ($Size == "S") {
                array_push($jsonflex['contents']['body']['contents'][4]['contents'], $arrayBoxNew);
            }
        }
        $arrayPostData['messages'][0] = $jsonflex;
        replyMsg($arrayHeader, $arrayPostData);
    } else if ($massage[1] == "ยืนยันแจ้งยอดการผลิต") {
        $trans_id = $massage[2];
        $sql0 = "EXEC [dbo].[SP_Check_Confirm_Production_Data] " . $trans_id;
        $getResults0 = sqlsrv_query($conn, $sql0);
        $row0 = sqlsrv_fetch_array($getResults0, SQLSRV_FETCH_ASSOC);
        if ($row0['role2_confirm'] == "0") {
            $sql1 = "EXEC [dbo].[SP_Update_Production_Data] " . $trans_id . ",2";
            $getResults1 = sqlsrv_query($conn, $sql1);
            $row1 = sqlsrv_fetch_array($getResults1, SQLSRV_FETCH_ASSOC);
            $replymsg = "แจ้ง Owner เรียบร้อย";
            $sql2 = "EXEC [dbo].[SP_GET_Production_Data_Line] '" . $userId . "','" . $trans_id . "'";
            $getResults2 = sqlsrv_query($conn, $sql2);
            $row2 = sqlsrv_fetch_array($getResults2, SQLSRV_FETCH_ASSOC);
            $Cycle_B = $row2['Cycle_B'];
            $Cycle_S = $row2['Cycle_S'];
            $B = $row2['B'];
            $PB = $row2['PB'];
            $P2 = $row2['P2'];
            $PC_B = $row2['PC_B'];
            $R = $row2['R'];
            $S = $row2['S'];
            $PS = $row2['PS'];
            $PC_S = $row2['PC_S'];
            $LineToken_User3 = $row2['LineToken_User3'];

            include("./FlexMassage-IC/PMS_Owner_Step1.php"); //แปะ $trans_id ทีี่ปุ่ม link
            $sql3 = "EXEC [dbo].[SP_GET_Production_Data_Line] '" . $userId . "','" . $trans_id . "'";
            $getResults3 = sqlsrv_query($conn, $sql3);
            while ($row3 = sqlsrv_fetch_array($getResults3, SQLSRV_FETCH_ASSOC)) {
                $arrayBoxNew = [];
                $main_machine_ID = $row3['main_machine_ID'];
                $Size = $row3['Size'];
                $Cycle = $row3['Cycle'];
                $arrayBoxNew['type'] = "box";
                $arrayBoxNew['layout'] = "baseline";
                $arrayBoxNew['contents'][0]['type'] = "text";
                $arrayBoxNew['contents'][0]['text'] = $main_machine_ID;
                $arrayBoxNew['contents'][0]['flex'] = 0;
                $arrayBoxNew['contents'][0]['margin'] = "sm";
                $arrayBoxNew['contents'][0]['contents'] = [];
                $arrayBoxNew['contents'][1]['type'] = "text";
                $arrayBoxNew['contents'][1]['text'] = $Cycle . "รอบ";
                $arrayBoxNew['contents'][1]['size'] = "md";
                $arrayBoxNew['contents'][1]['color'] = "#000000FF";
                $arrayBoxNew['contents'][1]['align'] = "end";
                $arrayBoxNew['contents'][1]['contents'] = [];
                if ($Size == "B") {
                    array_push($jsonflex['contents']['body']['contents'][2]['contents'], $arrayBoxNew);
                } else if ($Size == "S") {
                    array_push($jsonflex['contents']['body']['contents'][4]['contents'], $arrayBoxNew);
                }
            }
            $pushID = array();
            array_push($pushID, $LineToken_User3);
            // array_push($pushID, 'U58f9aa06ab1292a9f548b48f0eea62d7'); //พี่มาย
            // array_push($pushID, 'U0cfb6e104a4950d326e9b5354ec6f8dd');//อ๋อง
            $arrayPush['messages'][0] = $jsonflex;
            API_Push($pushID, $arrayPush, $arrayHeader);
        } else if ($row0['role1_confirm'] == "1") {
            $replymsg = "Timekeeper เคยแจ้งไปแล้ว";
        }
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = $replymsg;
        replyMsg($arrayHeader, $arrayPostData);
    }
} else if ($queryText == "token") {
    $arrayPostData['messages'][0]['type'] = "text";
    $arrayPostData['messages'][0]['text'] = $userId;
    replyMsg($arrayHeader, $arrayPostData);
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
function PushMsg($url, $arrayHeader, $arrayPush)
{
    $strUrl = $url;
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $strUrl);
    curl_setopt($ch, CURLOPT_HEADER, false);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrayPush));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $result = curl_exec($ch);
    curl_close($ch);
}

function GetTitle($main_machine_ID)
{
    include './db_connect.php';
    $sql = "SELECT [main_machine_ID],[main_machine_desc],[customer_no] ,[site_code],[factory_no],[factory_name],[site_name]  FROM [dbo].[VW_API_Machine_Factory] where [main_machine_ID] = '" . $main_machine_ID . "' ";
    $getResults = sqlsrv_query($conn, $sql);
    if (sqlsrv_has_rows($getResults) === TRUE) {
        while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
            $text = $row['site_name'] . "\n" . $row['main_machine_desc'];
            return $text;
        }
    }
}
function API_Push($pushID, $arrayPush, $arrayHeader)
{
    print_r($pushID);
    if (count($pushID) > 1) {
        $arrayPush['to'] = $pushID;
        PushMsg("https://api.line.me/v2/bot/message/multicast", $arrayHeader, $arrayPush);
    } else {
        $arrayPush['to'] = $pushID[0];
        PushMsg("https://api.line.me/v2/bot/message/push", $arrayHeader, $arrayPush);
    }
}




exit;
