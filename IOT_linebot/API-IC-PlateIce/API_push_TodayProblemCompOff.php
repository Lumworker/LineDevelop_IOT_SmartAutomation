<?php
include './db_connect.php';
$access_token = 'wzsqEYxW4I9M5l7Mu6rGdNnnB3QC9gVx/vsq0LA1twR26pHvv5fooXEwAScQmr/IIjf74l/ARy04qGt9hcSGtkXd6DGQZZJlvTznnoq+EZgkrdzh2Dxc342GZnFApsFslj9bEsGK7dMKIIPaOaUaogdB04t89/1O/w1cDnyilFU=';

$arrayHeader = array();
$arrayHeader[] = "Content-Type: application/json";
$arrayHeader[] = "Authorization: Bearer {$access_token}";

$main_machine_ID = $_POST['main_machine_ID'];
// $main_machine_ID =   "PK99990PKKK201TI01PIN1001";

$slice_Main_id =  substr($main_machine_ID , 0 , strlen($main_machine_ID)-7 );

$i = 0;
$lineToken = "";
$checknotdata="";
$Msg = "";
$namefic = "";

$sql = " SELECT distinct [main_machine_ID],  [lineToken],[factory_name], [main_machine_desc] FROM [dbo].[VW_API_ListMachine] WHERE [main_machine_ID] = '$slice_Main_id' ORDER BY [lineToken],[factory_name] ";
$getResults = sqlsrv_query($conn, $sql, array(), array("Scrollable" => 'static'));
if (sqlsrv_has_rows($getResults) === TRUE) {
    $row_count = sqlsrv_num_rows($getResults);
    
    while ($row = sqlsrv_fetch_array($getResults, SQLSRV_FETCH_ASSOC)) {

        if($i == 0){
            $lineToken = $row['lineToken'];
            // $namefic = $row['factory_name'];
            // $Msg .= $namefic."\n";
            // echo"0";
        }else if($lineToken != $row['lineToken']){
            echo "<br/>".$Msg;
            $arrayPostData['messages'][0]['type'] = "text";
            $arrayPostData['messages'][0]['text'] = $Msg;
            $arrayPostData['to'] = $lineToken;
            replyMsg("https://api.line.me/v2/bot/message/push", $arrayHeader, $arrayPostData);
               
            $lineToken = $row['lineToken'];
            $namefic = $row['factory_name'];
             $Msg = "";
            // $Msg = $namefic."\n";
            // echo"1";
        }else if ($lineToken == $row['lineToken']) {
            if ($namefic != $row['factory_name']) {
                $namefic = $row['factory_name'];
                // $Msg .= "\n".$namefic."\n";
                // echo $namefic;
            }
            // echo"2";
        }

        
        $sql2 = "EXEC [SP_API_Line_Status_Machine_20200506] '$slice_Main_id','TodayProblemCompOff'";
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
                // $Msg .=  $row2['ReplyLine'] . "\n";
                $Msg .= $row['main_machine_desc']. "\n" . $row2['ReplyLine'] . "\n";

            }
        }

        $i++;

        if ($i == $row_count) {

            echo "<br/>".$Msg;

            $arrayPostData['to'] = $lineToken;
            $arrayPostData['messages'][0]['type'] = "text";
            $arrayPostData['messages'][0]['text'] = $Msg;
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