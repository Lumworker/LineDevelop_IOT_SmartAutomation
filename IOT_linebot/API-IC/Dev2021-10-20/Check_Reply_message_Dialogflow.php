<?php
// require "../vendor/autoload.php";
include './db_connect.php';

$sql = "EXEC [SP_API_ListMachine]  'U0cfb6e104a4950d326e9b5354ec6f8dd' ";
// $sql = "EXEC [SP_API_ListMachine]  '$userId' ";
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
        $sql2 = "EXEC [dbo].[SP_Machine_Summary_HG] '" . $row['main_machine_ID'] . "'";
        $getResults2 = sqlsrv_query($conn, $sql2);
        while ($row2 = sqlsrv_fetch_array($getResults2, SQLSRV_FETCH_ASSOC)) {
            //เอา Reply line มาแปะต่อ ['main_machine_desc']
            $Msg .= $row['main_machine_desc'] . "\n" .
                "    - จำนวนรอบการผลิต " . $row2['Cycle'] . " รอบ\n" .
                "      (On Peak " . $row2['CycleOnPeaak']  . " รอบ, Off Peak " .  $row2['CycleOffPeaak']  . " รอบ)\n" .
                "    - ผลิตน้ำแข็งได้ " . (float)$row2['IceWieght'] . " ตัน\n" .
                "    - พลังงานที่ใช้ " . (float)$row2['PowerUsed']  . " หน่วย\n" .
                "      (On Peak " . (float)$row2['power_usedOnPeaak']   . " หน่วย, Off Peak " .  (float)$row2['power_usedOffPeaak']  . " หน่วย)\n" .
                "    - ปริมาณน้ำที่ใช้ " . (float)$row2['WaterUsed'] . " คิว\n" .
                "    - เวลาผลิตน้ำแข็งเฉลี่ย " . $row2['FreezingTime']  . " นาที\n" .
                "    - ปริมาณน้ำแข็งต่อหน่วยพลังงาน " . (float)$row2['IceWieghtPerPower']  . " กิโลกรัม\n";
        }

        if ($i == $row_count) {
            array_push($arrayDB, $Msg);
        }
        $i++;
    }

    if (count($arrayDB) >= 5) {
        echo ("one Message");
        $msgTotal = "";
        for ($x = 0; $x < count($arrayDB); $x++) {
            $msgTotal = $msgTotal . $arrayDB[$i] . " \n ";
        }
        echo ($msgTotal);
        // $arrayPostData['messages'][$i]['type'] = "text";
        // $arrayPostData['messages'][$i]['text'] = $msgTotal;

    } else {
        echo ("Multi Message");
        for ($x = 0; $x < count($arrayDB); $x++) {
            echo ($arrayDB[$x]);
            echo ("<br>");
            // $arrayPostData['messages'][$i]['type'] = "text";
            // $arrayPostData['messages'][$i]['text'] = $arrayDB[$i];
        }
    }

    //replyMsg($arrayHeader, $arrayPostData);
    sqlsrv_close($conn);
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

exit;
