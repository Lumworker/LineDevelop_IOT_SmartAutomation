<?php
// require "../vendor/autoload.php";
include './db_connect.php';
header("Last-Modified: " . gmdate("D, d M Y H:i:s") . " GMT");
$accessToken = "k3dpCHPmnU8h2tcQNkBEseVOKQZZZAXcTqp57qQIzsMqnmoleJxna5AtFd/Q6/1AEDph9zvbcUVAIWw5dRpnD897s4WwRO1q/liTOhPUI+Qm9JgHf4YF7lLP25Bou7Jd2INDKnuPsuAeOEZcSK8+rlGUYhWQfeY8sLGRXgo3xvw="; //copy Channel access token ตอนที่ตั้งค่ามาใส่

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
} else if ($massage[0] == "ข้อมูลโดยละเอียด") {
    $sql = "SELECT [main_machine_ID],[main_machine_desc],[customer_no] ,[site_code],[factory_no],[factory_name]  FROM [IOTPatkol].[dbo].[VW_API_Machine_Factory] WHERE [customer_no] = '$massage[1]' AND [factory_no] = '$massage[2]' AND [site_code] = '$massage[3]' AND [main_machine_ID] = '$massage[4]'";
    $getResults = sqlsrv_query($conn, $sql);

    if (sqlsrv_has_rows($getResults) === TRUE) {
        $Button = ['กำลังการผลิต', 'เวลาที่น้ำแข็งรอบต่อไปจะตก', 'สถานะการทำงาน'];
        $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
        include("../FlexMassage-IC/Machine_Detail_data_Bubble.php");
        for ($i = 0; $i < count($Button); $i++) {
            $arrayBoxNew['type'] = "button";
            $arrayBoxNew['action']['type'] = "message";
            $arrayBoxNew['action']['label'] = "$Button[$i]";
            $arrayBoxNew['action']['text'] = "$Button[$i] : " . $row['main_machine_ID'];
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
} else if ($massage[0] == "สถานะของเครื่อง") {
    $sql = "EXEC SP_API_Line_Status_Machine_20203101 '$massage[1]','MachineStatus'"; //ERROR MachineStatus
    $getResults = sqlsrv_query($conn, $sql);
    if (sqlsrv_has_rows($getResults) === TRUE) {
        $row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC);
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] = $row['ReplyLine'];
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
} else if ($queryText == "รายงานการผลิต") {
    $sql = "EXEC [SP_API_ListMachine]  '$userId' ";
    $getResults = sqlsrv_query($conn, $sql, array(), array("Scrollable" => 'static'));
    if (sqlsrv_has_rows($getResults) === TRUE) {
        // $arrayDB = ['วันนี้'];
        $arrayDB = [];
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
                    // if ($row2['create_date'] == "") {
                    //     date_default_timezone_set('Asia/Bangkok');
                    //     $Year = date('d-m-Y');
                    //     $Time = date('H:i:s');
                    //     $row2['create_date'] = $Year .", ".$Time;
                    // }
                    //แบบดึงจาก DB ถ้าไม่มีข้อมูล จะ ใส่เวลาปัจจุบัน (ยกเลิกใช้งานเมื่อ 2021/10/26)
                    
                    date_default_timezone_set('Asia/Bangkok');
                    $Year = date('d/m/Y');
                    $Time = date('H:i:s');
                    $Date = $Year .", ".$Time;

                    if ($i2 == 1) {
                        $Msg .= "รายงานการผลิตประจำวัน ณ ปัจจุบัน " . $Date . " น.\n\n";
                    }
                    $Msg .= $row['main_machine_desc'] . "\n" .
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
} 
else if ($queryText == "รายงานการผลิต000") {
    $sql = "SELECT [customer_no],[site_code],[factory_no],[site_name],[factory_name],[main_machine_ID],[main_machine_desc] FROM [dbo].[VW_API_ListMachine] WHERE [lineToken] = '$userId' ";
    $getResults = sqlsrv_query($conn, $sql, array(), array("Scrollable" => 'static'));
    if (sqlsrv_has_rows($getResults) === TRUE) {
        $arrayDB = ['วันนี้'];
        $i = 1;
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
            } else if ($namefic == $row['site_name']) {
                // 2 ถ้าเป็น site_name เดิม จะทำการต่อข้อความ Machine เข้าไปและขึ้นบรรนทัดใหม่
                $Msg = $Msg . " \n ";
            }
            // $sql2 = " EXEC SP_API_Line_Status_Machine_20203101 'TH10104VPIP01TI01','TodayProductions'";
            $sql2 = "EXEC SP_API_Line_Status_Machine_20203101 '" . $row['main_machine_ID'] . "','TodayProductions' ";
            $getResults2 = sqlsrv_query($conn, $sql2);
            while ($row2 = sqlsrv_fetch_array($getResults2, SQLSRV_FETCH_ASSOC)) {
                //เอา Reply line มาแปะต่อ ['main_machine_desc']
                if ($row2['ReplyLine'] == "Not Data") {
                    $Msg .= $row['main_machine_desc'] . "\n   -ไม่มีข้อมูลครับ\n";
                } else {
                    $Msg .= $row['main_machine_desc'] . "\n" . $row2['ReplyLine'] . "\n";
                }
            }

            if ($i == $row_count) {
                array_push($arrayDB, $Msg);
            }
            $i++;
        }
        
        for ($i = 0; $i < count($arrayDB); $i++) {
            $arrayPostData['messages'][$i]['type'] = "text";
            $arrayPostData['messages'][$i]['text'] = $arrayDB[$i];
        }
    }
    replyMsg($arrayHeader, $arrayPostData);
} 
//---------PMS Step1----------
else if ($massage[0] == "แจ้งยอดการผลิต") {
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
            include("../FlexMassage-IC/PMS_Start.php");
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
            include("../FlexMassage-IC/PMS_Operator_Step2.php");
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
            include("../FlexMassage-IC/PMS_Operator_Step1.php");
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
else if ($massage[0] == "แก้ไขยอดการผลิต" || $massage[0] == "แก้ไขแผน") {
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
            include("../FlexMassage-IC/PMS_Operator_Rewrite.php");
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
            include("../FlexMassage-IC/PMS_Operator_Step1.php");
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
                include("../FlexMassage-IC/PMS_Technician_Step1.php"); //แปะ $trans_id ทีี่ปุ่ม link
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
        include("../FlexMassage-IC/PMS_Operator_Step1.php");
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

        include("../FlexMassage-IC/PMS_Technician_Step2.php"); //แปะ $trans_id ทีี่ปุ่ม link
        $sql3 = "EXEC [dbo].[SP_GET_Production_Data_Line] '" . $userId . "','" . $trans_id . "'";
        $getResults3 = sqlsrv_query($conn, $sql3);
        while ($row3 = sqlsrv_fetch_array($getResults3, SQLSRV_FETCH_ASSOC)) {
            $arrayBoxNew = [];
            $main_machine_ID = $row3['main_machine_ID'];
            $main_machine_number = $row3['main_machine_number'];
            $Size = $row3['Size'];
            $Cycle = $row3['Cycle'];
            $TOU = $row3['TOU'];
            $arrayBoxNew['type'] = "box";
            $arrayBoxNew['layout'] = "baseline";
            $arrayBoxNew['contents'][0]['type'] = "text";
            $arrayBoxNew['contents'][0]['text'] = $main_machine_number;
            $arrayBoxNew['contents'][0]['flex'] = 0;
            $arrayBoxNew['contents'][0]['margin'] = "sm";
            $arrayBoxNew['contents'][0]['contents'] = [];
            $arrayBoxNew['contents'][1]['type'] = "text";
            $arrayBoxNew['contents'][1]['text'] = $Cycle . " รอบ";
            $arrayBoxNew['contents'][1]['size'] = "md";
            $arrayBoxNew['contents'][1]['color'] = "#000000FF";
            $arrayBoxNew['contents'][1]['align'] = "end";
            $arrayBoxNew['contents'][1]['contents'] = [];
            if ($Size == "B") {
                array_push($jsonflex['contents']['body']['contents'][2]['contents'], $arrayBoxNew);
            } else if ($Size == "S") {
                array_push($jsonflex['contents']['body']['contents'][4]['contents'], $arrayBoxNew);
            }
            if ($TOU != 0) {
                $arrayBoxNew2['type'] = "text";
                $arrayBoxNew2['text'] = "จำนวนรอบการผลิต ".$main_machine_number." เกินเวลา TOU";
                $arrayBoxNew2['weight'] = "bold";
                $arrayBoxNew2['size'] = "sm";
                $arrayBoxNew2['color'] = "#FF3232FF";
                $arrayBoxNew2['contents'] = [];
                array_push($jsonflex['contents']['body']['contents'], $arrayBoxNew2);
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
            $LineToken_User1 = $row2['LineToken_User1'];
            $LineToken_User3 = $row2['LineToken_User3'];

            include("../FlexMassage-IC/PMS_Owner_Step1.php"); //แปะ $trans_id ทีี่ปุ่ม link
            $sql3 = "EXEC [dbo].[SP_GET_Production_Data_Line] '" . $userId . "','" . $trans_id . "'";
            $getResults3 = sqlsrv_query($conn, $sql3);
            while ($row3 = sqlsrv_fetch_array($getResults3, SQLSRV_FETCH_ASSOC)) {
                $arrayBoxNew = [];
                $main_machine_ID = $row3['main_machine_ID'];
                $main_machine_number = $row3['main_machine_number'];
                $Size = $row3['Size'];
                $Cycle = $row3['Cycle'];
                $TOU = $row3['TOU'];
                $arrayBoxNew['type'] = "box";
                $arrayBoxNew['layout'] = "baseline";
                $arrayBoxNew['contents'][0]['type'] = "text";
                $arrayBoxNew['contents'][0]['text'] = $main_machine_number;
                $arrayBoxNew['contents'][0]['flex'] = 0;
                $arrayBoxNew['contents'][0]['margin'] = "sm";
                $arrayBoxNew['contents'][0]['contents'] = [];
                $arrayBoxNew['contents'][1]['type'] = "text";
                $arrayBoxNew['contents'][1]['text'] = $Cycle . " รอบ";
                $arrayBoxNew['contents'][1]['size'] = "md";
                $arrayBoxNew['contents'][1]['color'] = "#000000FF";
                $arrayBoxNew['contents'][1]['align'] = "end";
                $arrayBoxNew['contents'][1]['contents'] = [];
                if ($Size == "B") {
                    array_push($jsonflex['contents']['body']['contents'][2]['contents'], $arrayBoxNew);
                } else if ($Size == "S") {
                    array_push($jsonflex['contents']['body']['contents'][4]['contents'], $arrayBoxNew);
                }
                if ($TOU != 0) {
                    $arrayBoxNew2['type'] = "text";
                    $arrayBoxNew2['text'] = "จำนวนรอบการผลิต ".$main_machine_number." เกินเวลา TOU";
                    $arrayBoxNew2['weight'] = "bold";
                    $arrayBoxNew2['size'] = "sm";
                    $arrayBoxNew2['color'] = "#FF3232FF";
                    $arrayBoxNew2['contents'] = [];
                    array_push($jsonflex['contents']['body']['contents'], $arrayBoxNew2);
                }
            }
            $pushID = array();
            $pushID2 = array();
            array_push($pushID2, $LineToken_User1);
            array_push($pushID, $LineToken_User3);
            // array_push($pushID, 'U58f9aa06ab1292a9f548b48f0eea62d7'); //พี่มาย
            // array_push($pushID, 'U0cfb6e104a4950d326e9b5354ec6f8dd');//อ๋อง
            //--ส่งหา Owner
            $arrayPush['messages'][0] = $jsonflex;
            API_Push($pushID, $arrayPush, $arrayHeader);
            //--ส่งหา Operater
            $arrayPush2['messages'][0]['type'] = "text";
            $arrayPush2['messages'][0]['text'] = "รายการแจ้งยอดการผลิต Technicain ได้ทำการยืนยันแล้ว ขณะนี้กำลังทำการตรวจสอบที่ Owner";
            API_Push($pushID2, $arrayPush2, $arrayHeader);
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

function GetTitle($main_machine_ID)
{
   include './db_connect.php';
   $sql = "SELECT [main_machine_ID],[main_machine_desc],[customer_no] ,[site_code],[factory_no],[factory_name],[site_name]  FROM [dbo].[VW_API_Machine_Factory] where [main_machine_ID] = '". $main_machine_ID ."' ";
   $getResults = sqlsrv_query($conn, $sql);
   if (sqlsrv_has_rows($getResults) === TRUE) {
       while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {
       $text = $row['site_name'] ."\n". $row['main_machine_desc'];
       return $text;
       }
   }
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
