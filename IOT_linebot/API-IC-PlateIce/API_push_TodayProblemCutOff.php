<?php
include './db_connect.php';
$access_token = 'wzsqEYxW4I9M5l7Mu6rGdNnnB3QC9gVx/vsq0LA1twR26pHvv5fooXEwAScQmr/IIjf74l/ARy04qGt9hcSGtkXd6DGQZZJlvTznnoq+EZgkrdzh2Dxc342GZnFApsFslj9bEsGK7dMKIIPaOaUaogdB04t89/1O/w1cDnyilFU=';

$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$access_token}";

$numberLoop = 0;
$lineToken = "";
$Msg = "";
$sitename = "";
$checkCustomer = "";
$arrayDB = array();

$sql = "SELECT distinct [main_machine_ID],[lineToken],[customer_no],[site_code],[site_name],[factory_no],[site_name], [main_machine_desc] FROM [dbo].[VW_API_ListMachine] ORDER BY [lineToken],[main_machine_ID]";
$getResults = sqlsrv_query($conn, $sql, array(), array("Scrollable" => 'static'));
if (sqlsrv_has_rows($getResults) === TRUE) {
    $row_count = sqlsrv_num_rows($getResults);
    
    while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {

        if($numberLoop == 0){
            $lineToken = $row['lineToken'];
            $sitename = $row['site_name'];
            $checkCustomer = $row['customer_no']."".$row['site_code']."".$row['factory_no'];
            $Msg = $sitename."\n";
        }else if($lineToken != $row['lineToken']){

            array_push($arrayDB , $Msg);
            $arrayPostData['messages'][0]['type'] = "text";
            $arrayPostData['messages'][0]['text'] = "เมื่อวานนี้";
            for ($i=0; $i < count($arrayDB); $i++) { 
                $arrayPostData['messages'][($i+1)]['type'] = "text";
                $arrayPostData['messages'][($i+1)]['text'] = $arrayDB[$i];
            }
            $arrayPostData['to'] = $lineToken;
            replyMsg("https://api.line.me/v2/bot/message/push", $arrayHeader, $arrayPostData);

            print_r($arrayPostData);

            unset($arrayDB);
            unset($arrayPostData);
            $arrayDB = array();
            $arrayPostData = array();
            $lineToken = $row['lineToken'];
            $sitename = $row['site_name'];
            $checkCustomer = $row['customer_no']."".$row['site_code']."".$row['factory_no'];
            $Msg = $sitename."\n";
        }else if ($lineToken == $row['lineToken']) {
            if ($checkCustomer != ($row['customer_no']."".$row['site_code']."".$row['factory_no'])) {
                array_push($arrayDB , $Msg);
                $sitename = $row['site_name'];
                $checkCustomer = $row['customer_no']."".$row['site_code']."".$row['factory_no'];
                $Msg = $sitename."\n";
                // echo $sitename;
            }
             
        }


        $sql2 = "EXEC SP_API_Line_Status_Machine_20200506 '" . $row['main_machine_ID'] . "','TodayProblemCutOff'";
        $getResults2 = sqlsrv_query($conn, $sql2);
        if (sqlsrv_has_rows($getResults2) === TRUE) {
            while ($row2 = sqlsrv_fetch_array($getResults2, SQLSRV_FETCH_ASSOC)) 
            {
                $emoji = [];
                $message =  explode("(E)", $row2['ReplyLine']);
                for ($j = 1; $j < count($message); $j++) { //ดึงค่าตัวเลข จาก(E)ไปใส่ Array
                    array_push($emoji, substr($message[$j], 0, 6));
                }
                
                for ($j = 0; $j < count($emoji); $j++) { //เอาค่า ในArray มาreplace แทน ตัวเลขหลัง E
                    $row2['ReplyLine'] = str_replace($emoji[$j], EncodeEmoji($emoji[$j]), $row2['ReplyLine']);
                }

                $row2['ReplyLine'] = str_replace("(n)", "\n", $row2['ReplyLine']); //replace(n)ขึ้นบรรทัดใหม่
                $row2['ReplyLine'] = str_replace("(E)", "", $row2['ReplyLine']); //ลบ(E)ทิ้ง
                $Msg .= $row['main_machine_desc']. "\n" . $row2['ReplyLine'] . "\n\n";
            }
        }

        $numberLoop++;

        // echo "<br/>$numberLoop : $row_count";

        if ($numberLoop == $row_count) {
            array_push($arrayDB , $Msg);
            $arrayPostData['messages'][0]['type'] = "text";
            $arrayPostData['messages'][0]['text'] = "เมื่อวานนี้";
            for ($i=0; $i < count($arrayDB); $i++) { 
                $arrayPostData['messages'][($i+1)]['type'] = "text";
                $arrayPostData['messages'][($i+1)]['text'] = $arrayDB[$i];
            }
            $arrayPostData['to'] = $lineToken;

            print_r($arrayPostData);
            replyMsg("https://api.line.me/v2/bot/message/push", $arrayHeader, $arrayPostData);
        }
    }
}


    function replyMsg($url, $arrayHeader, $arrayPostData)
    {
      $strUrl = $url;
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
    
    function EncodeEmoji($inputemoji)
    {
      $bin = hex2bin(str_repeat('0', 8 - strlen($inputemoji)) . $inputemoji);
      $emojiOutput = mb_convert_encoding($bin, 'UTF-8', 'UTF-32BE');
      return $emojiOutput;
    }
    


?>