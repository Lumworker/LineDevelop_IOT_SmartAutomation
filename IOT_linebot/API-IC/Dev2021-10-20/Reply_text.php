<?php
include './db_connect.php';
$datas = file_get_contents('php://input');
$arrayJson = json_decode($datas, true);
file_put_contents('log.txt', file_get_contents('php://input') . PHP_EOL, FILE_APPEND);
$accessToken = "RsI8C8uFpwlPqN+f/+nfrzfWCwwjHZuyWohijNRUYpQO9/UVWVRz6M1XvGAeyjEZ/NYYt7HSYWIdnSf1UQ4/UippM+mCGGS8UZhh90uPQ6WOeAQK4FgoyIyC9nGtRG/LY12BbDP3rL+Z4XRmY3RuvQdB04t89/1O/w1cDnyilFU=";
$replyToken = $arrayJson['events'][0]['replyToken'];
$messageType = $arrayJson['events'][0]['message']['type'];
$messageID = $arrayJson['events'][0]['message']['id'];
$getMassage = $arrayJson['events'][0]['message']['text'];
$userId = $arrayJson['events'][0]['source']['userId'];
$UserName = profile($userId, $accessToken);
$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$accessToken}";
$arrayPostData['replyToken'] = $replyToken;
$massage =  explode(" : ",  $getMassage);


if ($massage[0] == "ข้อมูลของโรงน้ำแข็ง") {
    $sql = "SELECT [site_name],[customer_no], [site_code] ,[factory_no] ,[factory_name],[username] FROM [dbo].[VW_API_LINE_Site] WHERE [lineToken] = '$userId'";
    $getResults = sqlsrv_query($conn, $sql);

    if (sqlsrv_has_rows($getResults) === TRUE) {
        include("../FlexMassage-IC/Machine_Carousel.php");
        while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
            $arrayBoxNew = [];
            $arrayBoxNew['type'] = "bubble";
            $arrayBoxNew['direction'] = "ltr";
            $arrayBoxNew['hero']['type'] = "image";
            $arrayBoxNew['hero']['url'] = "https://patkolpae.com/IOT_linebot/images/Patkol_314.jpg";
            $arrayBoxNew['hero']['align'] = "center";
            $arrayBoxNew['hero']['size'] = "full";
            $arrayBoxNew['hero']['aspectRatio'] = "20:13";
            $arrayBoxNew['hero']['aspectMode'] = "cover";
            $arrayBoxNew['body']['type'] = "box";
            $arrayBoxNew['body']['layout'] = "vertical";
            $arrayBoxNew['body']['contents'][0]['type'] = "text";
            $arrayBoxNew['body']['contents'][0]['text'] = "" . $row['site_name'] . "";
            $arrayBoxNew['body']['contents'][0]['size'] = "xl";
            $arrayBoxNew['body']['contents'][0]['align'] = "center";
            $arrayBoxNew['body']['contents'][0]['weight'] = "bold";
            $arrayBoxNew['body']['contents'][0]['color'] = "#000000";

            $arrayBoxNew['body']['contents'][1]['type'] = "text";
            $arrayBoxNew['body']['contents'][1]['margin'] = "sm";
            $arrayBoxNew['body']['contents'][1]['text'] = "เลือกเครื่องทำน้ำแข็งที่ต้องการ";
            $arrayBoxNew['body']['contents'][1]['size'] = "lg";
            $arrayBoxNew['body']['contents'][1]['align'] = "center";
            $arrayBoxNew['body']['contents'][1]['color'] = "#000000";

            $arrayBoxNew['body']['contents'][2]['type'] = "box";
            $arrayBoxNew['body']['contents'][2]['margin'] = "lg";
            $arrayBoxNew['body']['contents'][2]['layout'] = "vertical";
            $arrayBoxNew['body']['contents'][2]['contents'] = [];


            $sql_machine = "EXEC [SP_API_Machine_Factory] '" . $row['customer_no'] . "' ,'" . $row['site_code'] . "' ,'" . $row['factory_no'] . "' , '' ,'" . $row['username'] . "'";
            //$sql_machine = "SELECT [main_machine_ID],[main_machine_desc],[customer_no] ,[site_code],[factory_no],[factory_name],[main_machine_size]  FROM [dbo].[VW_API_Machine_Factory] WHERE [customer_no] = '" . $row['customer_no'] . "' AND [site_code] = '" . $row['site_code'] . "' AND [factory_no] = '" . $row['factory_no'] . "' ORDER BY [main_machine_ID] , [main_machine_size]";
            $get_machine = sqlsrv_query($conn, $sql_machine);
            $i = 0;
            while ($row_machine = sqlsrv_fetch_array($get_machine, SQLSRV_FETCH_ASSOC)) {

                if ($row_machine["Send"] == "PAE" || $row_machine["Send"] == "PTIPS") {
                    if ($row_machine['main_machine_size'] == 41) {
                        $color = "#000D7F";
                    } elseif ($row_machine['main_machine_size'] == 19) {
                        $color = "#2290FB";
                    }
                    $arrayBoxNew['body']['contents'][2]['contents'][$i]['type'] = "button";
                    $arrayBoxNew['body']['contents'][2]['contents'][$i]['action']['type'] = "message";
                    $arrayBoxNew['body']['contents'][2]['contents'][$i]['action']['label'] = "" . $row_machine['main_machine_desc'] . "";
                    $arrayBoxNew['body']['contents'][2]['contents'][$i]['action']['text'] = "รายละเอียดเครื่องจักร : " . $row_machine['customer_no'] . " : " . $row_machine['site_code'] . " : " . $row_machine['factory_no'] . " : " . $row_machine['main_machine_ID'] . " : " . $row['username'];
                    $arrayBoxNew['body']['contents'][2]['contents'][$i]['color'] = $color;
                    $arrayBoxNew['body']['contents'][2]['contents'][$i]['margin'] = "sm";
                    $arrayBoxNew['body']['contents'][2]['contents'][$i]['height'] = "sm";
                    $arrayBoxNew['body']['contents'][2]['contents'][$i]['style'] = "primary";
                    $arrayBoxNew['body']['contents'][2]['contents'][$i]['gravity'] = "top";
                    $i++;
                }
            }
            array_push($jsonflex['contents']['contents'], $arrayBoxNew);

            $arrayPostData['messages'][0] = $jsonflex;
        }
    }
    replyMsg($arrayHeader, $arrayPostData);
} else if ($massage[0] == "รายละเอียดเครื่องจักร") {
    $sql = "EXEC [SP_API_Machine_Factory] '" . $massage[1] . "' ,'" . $massage[2] . "' ,'" . $massage[3] . "' ,'" . $massage[4] . "' ,'" . $massage[5] . "'";
    $getResults = sqlsrv_query($conn, $sql);
    if (sqlsrv_has_rows($getResults) === TRUE) {
        while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
            $site_name = $row['site_name'];
            $machine_desc = $row['main_machine_desc'];
            $linkImage = "https://patkolpae.com/IOT_linebot/images/Patkol_315.jpg";
            if ($row['SmartTubeIce'] == '1') {
                $linkImage = "https://patkolpae.com/IOT_linebot/images/Patkol_315_V2.jpg";
            }
            include("../FlexMassage-IC/Machine_Detail_Bubble_3.php");

            $arrayBoxNew['type'] = "button";
            $arrayBoxNew['action']['type'] = "message";
            $arrayBoxNew['action']['label'] = "กำลังการผลิต";
            $arrayBoxNew['action']['text'] = "กำลังการผลิต : " . $row["main_machine_ID"];
            $arrayBoxNew['color'] = "#000D7F";
            $arrayBoxNew['margin'] = "sm";
            $arrayBoxNew['height'] = "sm";
            $arrayBoxNew['style'] = "primary";
            array_push($jsonflex['contents']['body']['contents'][2]['contents'], $arrayBoxNew);

            $arrayBoxNew['type'] = "button";
            $arrayBoxNew['action']['type'] = "message";
            $arrayBoxNew['action']['label'] = "เวลาที่น้ำแข็งรอบต่อไปจะตก";
            $arrayBoxNew['action']['text'] = "เวลาที่น้ำแข็งรอบต่อไปจะตก : " . $row["main_machine_ID"];
            $arrayBoxNew['color'] = "#000D7F";
            $arrayBoxNew['margin'] = "sm";
            $arrayBoxNew['height'] = "sm";
            $arrayBoxNew['style'] = "primary";
            array_push($jsonflex['contents']['body']['contents'][2]['contents'], $arrayBoxNew);

            $arrayBoxNew['type'] = "button";
            $arrayBoxNew['action']['type'] = "message";
            $arrayBoxNew['action']['label'] = "สถานะการทำงาน";
            $arrayBoxNew['action']['text'] = "สถานะการทำงาน : " . $row["main_machine_ID"];
            $arrayBoxNew['color'] = "#000D7F";
            $arrayBoxNew['margin'] = "sm";
            $arrayBoxNew['height'] = "sm";
            $arrayBoxNew['style'] = "primary";
            array_push($jsonflex['contents']['body']['contents'][2]['contents'], $arrayBoxNew);

            $arrayBoxNew['type'] = "button";
            $arrayBoxNew['action']['type'] = "message";
            $arrayBoxNew['action']['label'] = "สรุปการแจ้งเตือนประจำวัน";
            $arrayBoxNew['action']['text'] = "สรุปการแจ้งเตือนประจำวัน : " . $row["main_machine_ID"];
            $arrayBoxNew['color'] = "#000D7F";
            $arrayBoxNew['margin'] = "sm";
            $arrayBoxNew['height'] = "sm";
            $arrayBoxNew['style'] = "primary";
            array_push($jsonflex['contents']['body']['contents'][2]['contents'], $arrayBoxNew);

            $arrayPostData['messages'][0] = $jsonflex;
        }
    }
    replyMsg($arrayHeader, $arrayPostData);
} else if ($massage[0] == "กำลังการผลิต") {
    $Title = GetTitle($massage[1]);
    $sql = "EXEC SP_API_Line_Status_Machine_20211120 '$massage[1]','Cycle'";
    $getResults = sqlsrv_query($conn, $sql);
    if (sqlsrv_has_rows($getResults) === TRUE) {
        $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
        $row['ReplyLine'] = str_replace("(n)", "\n", $row['ReplyLine']);
        $text = $Title . "\n\n" . $row['ReplyLine'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = $text;
        replyMsg($arrayHeader, $arrayPostData);
    }
} else if ($massage[0] == "เวลาที่น้ำแข็งรอบต่อไปจะตก") {
    $Title = GetTitle($massage[1]);
    $sql = "EXEC SP_API_Line_Status_Machine_20211120 '$massage[1]','FreezingTime'"; //ERROR FreezingTime
    $getResults = sqlsrv_query($conn, $sql);
    if (sqlsrv_has_rows($getResults) === TRUE) {
        $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
        $text = $Title . "\n\n" . $row['ReplyLine'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = $text;
        replyMsg($arrayHeader, $arrayPostData);
    }
} else if ($massage[0] == "สถานะการทำงาน") {
    $Title = GetTitle($massage[1]);
    $sql = "EXEC SP_API_Line_Status_Machine_20211120 '$massage[1]','Normal'";
    $getResults = sqlsrv_query($conn, $sql);
    if (sqlsrv_has_rows($getResults) === TRUE) {
        $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
        $row['ReplyLine'] = str_replace("(n)", "\n", $row['ReplyLine']); //replace(n)ขึ้นบรรทัดใหม่
        $text = $Title . "\n\n" . $row['ReplyLine'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = $text;
        replyMsg($arrayHeader, $arrayPostData);
    }
} else if ($massage[0] == "สรุปการแจ้งเตือนประจำวัน") {
    $Title = GetTitle($massage[1]);
    $sql = "EXEC SP_API_Line_Status_Machine_20211120 '$massage[1]','TodayProblems'";
    $getResults = sqlsrv_query($conn, $sql);

    if (sqlsrv_has_rows($getResults) === TRUE) {
        $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
        $emoji = [];
        $message =  explode("(E)", $row['ReplyLine']);
        for ($j = 1; $j < count($message); $j++) { //ดึงค่าตัวเลข จาก(E)ไปใส่ Array
            array_push($emoji, substr($message[$j], 0, 6));
        }

        for ($j = 0; $j < count($emoji); $j++) { //เอาค่า ในArray มาreplace แทน ตัวเลขหลัง E
            $row['ReplyLine'] = str_replace($emoji[$j], EncodeEmoji($emoji[$j]), $row['ReplyLine']);
        }

        $row['ReplyLine'] = str_replace("(n)", "\n", $row['ReplyLine']); //replace(n)ขึ้นบรรทัดใหม่
        $row['ReplyLine'] = str_replace("(E)", "", $row['ReplyLine']); //ลบ(E)ทิ้ง
        $text = $Title . "\n\n" . $row['ReplyLine'];
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = $text;
        replyMsg($arrayHeader, $arrayPostData);
    }
} else if ($massage[0] == "รายงานการผลิต") {
    $sql = "EXEC [SP_API_ListMachine]  'U0cfb6e104a4950d326e9b5354ec6f8dd' ";
    // $sql = "EXEC [SP_API_ListMachine]  '$userId' ";
    $getResults = sqlsrv_query($conn, $sql, array(), array("Scrollable" => 'static'));
    if (sqlsrv_has_rows($getResults) === TRUE) {
        $arrayDB = ['วันนี้'];
        $i = 1;
        $i2 = 1;
        $row_count = sqlsrv_num_rows($getResults);
        $namefic = "";
        $Msg = "";
        while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
            if ($namefic == "") {
                // 1 ครั้งแรกจะทำการเก็บ site_name 
                $namefic = $row['site_name'];
                $Msg = "" . $row['site_name'] . "\n";
            } else if ($namefic != $row['site_name']) {
                array_push($arrayDB, $Msg);
                $Msg = "" . $row['site_name'] . "\n";
                $namefic = $row['site_name'];
                $i2 = 1;
            } else if ($namefic == $row['site_name']) {
                // 2 ถ้าเป็น site_name เดิม จะทำการต่อข้อความ Machine เข้าไปและขึ้นบรรนทัดใหม่
                $Msg = $Msg . " \n ";
                $i2++;
            }
            $sql2 = "EXEC [dbo].[SP_Machine_Summary_HG_V2] '" . $row['main_machine_ID'] . "'";
            $getResults2 = sqlsrv_query($conn, $sql2);
                while ($row2 = sqlsrv_fetch_array($getResults2, SQLSRV_FETCH_ASSOC)) {
                    //เอา Reply line มาแปะต่อ ['main_machine_desc']
                    if ($row2['create_date'] == "") {
                        date_default_timezone_set('Asia/Bangkok');
                        $Year = date('d-m-Y');
                        $Time = date('H:i:s');
                        $row2['create_date'] = $Year .", ".$Time;
                    }
                    if ($i2 == 1) {
                        // $Msg .= "รายงานการผลิตประจำวัน ณ ปัจจุบัน " . $row2['create_date'] . " น.\n\n";
                    }
                    $Msg .= $row['main_machine_desc'] . "\n\n" .
                     "รายงานการผลิตประจำวัน ณ ปัจจุบัน " . $row2['create_date'] . " น.\n" .
                        "    - จำนวนรอบการผลิต " . $row2['Cycle'] . " รอบ\n" .
                        "      (On Peak " . $row2['CycleOnPeaak']  . " รอบ, Off Peak " .  $row2['CycleOffPeaak']  . " รอบ)\n" .
                        "    - ผลิตน้ำแข็งได้ " . (float)$row2['IceWieght'] . " ตัน\n" .
                        "    - พลังงานที่ใช้ " . (float)$row2['PowerUsed']  . " หน่วย\n" .
                        "      (On Peak " . (float)$row2['power_usedOnPeaak']   . " หน่วย, Off Peak " .  (float)$row2['power_usedOffPeaak']  . " หน่วย)\n" .
                        "    - ปริมาณน้ำที่ใช้ " . (float)$row2['WaterUsed'] . " คิว\n" .
                        "    - เวลาผลิตน้ำแข็งเฉลี่ย " . $row2['FreezingTime']  . " นาที\n" .
                        "    - พลังงานที่ใช้ " . (float)$row2['PowerPerIceWieght']  . " หน่วยต่อน้ำแข็ง 1 กิโลกรัม\n" ;
                    
                }
            if ($i == $row_count) {
                array_push($arrayDB, $Msg);
            }
            $i++;
        }

        for ($x = 0; $x < count($arrayDB); $x++) {
            $arrayPostData['messages'][$x]['type'] = "text";
            $arrayPostData['messages'][$x]['text'] = $arrayDB[$x];
        }
    }
    replyMsg($arrayHeader, $arrayPostData);
} else {
    $Title = GetTitle('TH99003WCRPIP01TI01');
    $arrayPostData['messages'][0]['type'] = "text";
    $arrayPostData['messages'][0]['text'] = $Title;
    replyMsg($arrayHeader, $arrayPostData);
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

exit;
