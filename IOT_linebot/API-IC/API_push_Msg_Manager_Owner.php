<?php
  require('./db_connect.php');
  include ('./access_token.php');
  // print_r($_POST);
  //$access_token = 'XIm3Vzpek93jMJQJcul7K1jLnD5Omr8jBzZJ4ME5XSWR01nBuomZPx6XDv4d3OIl/NYYt7HSYWIdnSf1UQ4/UippM+mCGGS8UZhh90uPQ6UFbrCvSW3/aBC9vSQc1x+robbEKL1DtXgDgqukF/+y+AdB04t89/1O/w1cDnyilFU=';

  $arrayHeader = array();
  $arrayHeader[] = "Content-Type: application/json";
  $arrayHeader[] = "Authorization: Bearer {$access_token}";
  //Set Linebot

  $Check_machine_ID = "";
  echo  $Datasql = "EXEC [dbo].[SP_IOT_Alarm_LineConfig_Manager_OWner]  ";
  $getDataResults = sqlsrv_query($conn, $Datasql);
  if (sqlsrv_has_rows($getDataResults) === TRUE) {
    while ($row = sqlsrv_fetch_array($getDataResults, SQLSRV_FETCH_ASSOC)) {
      echo $machine_ID = $row["machine_ID"];
      echo $trans_ID_Type0 = $row["trans_ID_Type0"];
      echo $trans_ID_Type1 = $row["trans_ID_Type1"];
      echo $stmsg = $row["stmsg"];
      echo $Customer_Role = $row["Customer_Role"];
      echo $main_machine_desc = $row["main_machine_desc"];
      echo $customer_no = $row["customer_no"];
      echo $site_code = $row["site_code"];
      echo $factory_no = $row["factory_no"];
      echo $username = $row["username"];
      echo "\n";
      echo $lineToken = $row["lineToken"];
      echo "\n";
      echo $username = $row["Seq"];
      echo $alarm_type = $row["alarm_type"];
      echo $msg_type = $row["msg_type"];
      echo $msg_main_type = $row["msg_main_type"];
      echo $Msg_Line = $row["Msg_Line"];
      echo $Send = $row["Send"];
      //Get check machine is frist time Alarm_Msg=0
      echo "\n";
      echo $Alarm_Msg = $row["Alarm_Msg"];
      echo "\n";
      //===========================1 Get Data  ================================

      if ($Send == "PAE" || $Send == "PTIPS") {
        $emoji = [];
        $message =  explode("(E)",  $Msg_Line);
        for ($j = 1; $j < count($message); $j++) { //ดึงค่าตัวเลข จาก(E)ไปใส่ Array
          array_push($emoji, substr($message[$j], 0, 6));
        }

        for ($j = 0; $j < count($emoji); $j++) { //เอาค่า ในArray มาreplace แทน ตัวเลขหลัง E
          $Msg_Line[0] = str_replace($emoji[$j], EncodeEmoji($emoji[$j]),  $Msg_Line);
        }

        $Msg_Line[0] = str_replace("(n)", "\n",  $Msg_Line); //replace(n)ขึ้นบรรทัดใหม่
        $Msg_Line[0] = str_replace("(E)", "",  $Msg_Line); //ลบ(E)ทิ้ง
        $arrayPostData['messages'][0]['type'] = "text";
        $arrayPostData['messages'][0]['text'] =  $Msg_Line;
        //===========================2 Set Massage  ================================



        //print_r($pushID);
        // $pushID = ['U0cfb6e104a4950d326e9b5354ec6f8dd'];
        $arrayPostData['to'] = $lineToken;
        replyMsg("https://api.line.me/v2/bot/message/push", $arrayHeader, $arrayPostData);
        //Push Noti

        if ($Alarm_Msg == '1') {
          echo "\n*****เคสธรรมดา ที่ไม่ใช่การทำงานเปิด/ปิด เครื่องจักรประจำวัน****";
          //if not 
          $Line = 1;
          if ($stmsg == "MsgNormal") {
            $Line =  1;
          } else if ($stmsg == "MsgError") {
            $Line = 0;
          }
          if ($Check_machine_ID != $machine_ID) {
            //บันทึกว่าMachine ไหนส่งแจ้งเตือนไปหา Manager Ownerแล้ว
            echo $Datasql2 = "EXEC [dbo].[SP_IOT_Alarm_CheckLine]  '" . $machine_ID . "' , '" . $Customer_Role . "' , $Line , " . $trans_ID_Type1 . "";
            echo "\n";
            $getDataResults2 = sqlsrv_query($conn, $Datasql2);
            if (sqlsrv_has_rows($getDataResults2) === TRUE) {
              echo "Insert Alarm CheckLine Complete";
            }
            $Check_machine_ID = $machine_ID;
          }
        }

      }
    }
  }
  //Get Data Msg and user target

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
