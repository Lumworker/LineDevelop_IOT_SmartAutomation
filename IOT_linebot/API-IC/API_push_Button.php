  <?php
  require('./db_connect.php');
  include('./access_token.php');
  // print_r($_POST);
  //$access_token = 'XIm3Vzpek93jMJQJcul7K1jLnD5Omr8jBzZJ4ME5XSWR01nBuomZPx6XDv4d3OIl/NYYt7HSYWIdnSf1UQ4/UippM+mCGGS8UZhh90uPQ6UFbrCvSW3/aBC9vSQc1x+robbEKL1DtXgDgqukF/+y+AdB04t89/1O/w1cDnyilFU=';

  $arrayHeader = array();
  $arrayHeader[] = "Content-Type: application/json";
  $arrayHeader[] = "Authorization: Bearer {$access_token}";
  //Set Linebot

  $trans_ID = $_POST['trans_ID'];
  echo "Step1 Get Data form trans _ID\n";
  echo $Datasql = "EXEC SP_IOT_Alarm_LineConfig_V2 '" . $trans_ID . "'";
  echo "\n";
  $getDataResults = sqlsrv_query($conn, $Datasql);
  //Get Data 

  $MSg_Line = array();
  if (sqlsrv_has_rows($getDataResults) === TRUE) {
    while ($row = sqlsrv_fetch_array($getDataResults, SQLSRV_FETCH_ASSOC)) {
      array_push($MSg_Line, $row["Msg_Line"]);
      $Msg_Line_Stop = $row["Msg_Line_Stop"];
      //Get Data Msg
      $factory_no =  $row["factory_no"];
      $site_code =  $row["site_code"];
      $customer_no =  $row["customer_no"];
      //GetData to Query User
      $alarm_type =  $row["alarm_type"];
      $machine_ID =  $row["machine_ID"];

      $main_machine_type =  $row["main_machine_type"];
      //new
      //Get check machine is frist time Alarm_Msg=0
      $Alarm_Msg =  $row["Alarm_Msg"];
    }
  }

  $arrayPostData['messages'][0]['type'] = "text";
  $arrayPostData['messages'][0]['text'] = ReadEmoji($MSg_Line[0]);

  if (count($MSg_Line) == 1) {
    if ($Msg_Line_Stop != "Not Msg") {
      $emoji = [];
      $message =  explode("(E)", $Msg_Line_Stop);
      for ($j = 1; $j < count($message); $j++) { //ดึงค่าตัวเลข จาก(E)ไปใส่ Array
        array_push($emoji, substr($message[$j], 0, 6));
      }

      for ($j = 0; $j < count($emoji); $j++) { //เอาค่า ในArray มาreplace แทน ตัวเลขหลัง E
        $Msg_Line_Stop = str_replace($emoji[$j], EncodeEmoji($emoji[$j]), $Msg_Line_Stop);
      }

      $Msg_Line_Stop = str_replace("(n)", "\n", $Msg_Line_Stop); //replace(n)ขึ้นบรรทัดใหม่
      $Msg_Line_Stop = str_replace("(E)", "", $Msg_Line_Stop); //ลบ(E)ทิ้ง
      $arrayPostData['messages'][1]['type'] = "text";
      $arrayPostData['messages'][1]['text'] = $Msg_Line_Stop;
    }
    //print_r($MSg_Line);
  }
  //Set Massage
  //===========================1 Get factory_no , site_code , customer_no / alarm_type , machine_ID  / Msg_Line , Msg_Line_Stop ================================

  echo "Step2 Get User Token\n";
  echo $SQL_Member = "EXEC [SP_IOT_Alarm_Member_v3] '$factory_no','$site_code','$customer_no','$main_machine_type'";
  echo "\n";
  $getUserResults = sqlsrv_query($conn, $SQL_Member);
  $pushID = array();

  if (sqlsrv_has_rows($getUserResults) === TRUE) {
    while ($row_Member = sqlsrv_fetch_array($getUserResults, SQLSRV_FETCH_ASSOC)) {

      echo $Send =  $row_Member["Send"];
      if ($Send == "PAE" || $Send == "PTIPS") {
        array_push($pushID, $row_Member["lineToken"]);
      }
      //Check Send only Send=PAE/PTIPS

    }
  }
  //Get User
  //===========================2 Get Use lineToken ================================
  echo "Step3 Check if it was sent?  \n";
  echo $SQL_Alarm_trans_Msg = "EXEC [SP_IOT_Alarm_trans_Msg] '$machine_ID' ";
  echo "\n";
  $getAlarm_trans_Msg = sqlsrv_query($conn, $SQL_Alarm_trans_Msg, array(), array("scrollable" => "static"));
  $Line_Count =  sqlsrv_num_rows($getAlarm_trans_Msg);
  // $Line = array();
  $Line = 1;
  if (sqlsrv_has_rows($getAlarm_trans_Msg) === TRUE) {
    while ($row_Line = sqlsrv_fetch_array($getAlarm_trans_Msg, SQLSRV_FETCH_ASSOC)) {
      $Line = $row_Line["Line"];
    }
  }

  echo "\n MSg_Line :";
  print_r($MSg_Line);
  echo "\n Msg_Line_Stop :" . $Msg_Line_Stop;
  echo "\n alarm_type :" . $alarm_type;
  echo "\n Line ";
  echo $Line;
  echo "\n Line_Count ";
  echo $Line_Count;
  //Get all Paramiter

  if ($Alarm_Msg == 0) {
    echo "\n*****เคสพิเศษ ส่งเปิด/ปิด การรทำงานเปิด/ปิด เครื่องจักรประจำวัน****";
    print_r($pushID);
    if (count($pushID) > 1) {
      $arrayPostData['to'] = $pushID;
      replyMsg("https://api.line.me/v2/bot/message/multicast", $arrayHeader, $arrayPostData);
    } else {
      $arrayPostData['to'] = $pushID[0];
      replyMsg("https://api.line.me/v2/bot/message/push", $arrayHeader, $arrayPostData);
    }
  } 
  else if (($alarm_type == 1 && $Line == 1 && $Line_Count > 0)
    || ($alarm_type == 1 && $Line_Count == 0)
    ||  ($alarm_type == 0 && $Line == 0 && $Line_Count > 0)
  ) {

    if ($Line == 1) {
      echo "value : " . $value = 0;
    } else if ($Line == 0 && $Line_Count > 0) {
      echo "value : " . $value = 1;
    }

    echo "\n*****Push Line****";
    //$pushID = ['U0cfb6e104a4950d326e9b5354ec6f8dd'];
    print_r($pushID);
    if (count($pushID) > 1) {
      $arrayPostData['to'] = $pushID;
      replyMsg("https://api.line.me/v2/bot/message/multicast", $arrayHeader, $arrayPostData);
    } else {
      $arrayPostData['to'] = $pushID[0];
      replyMsg("https://api.line.me/v2/bot/message/push", $arrayHeader, $arrayPostData);
    }
    //===========================3,4 Check Noti and Push Line ================================


    echo "Step4 Save/Update Send History  \n";
    echo "\n Update Line " . $value . "\n";
    echo $SQL_Insert_Update_Check = "EXEC [dbo].[SP_IOT_Alarm_CheckLine]  '" . $machine_ID . "' , 'Technician' , " . $value . " , " . $trans_ID . "";
    $getInsert_Update_Check = sqlsrv_query($conn, $SQL_Insert_Update_Check);
    if (sqlsrv_has_rows($getInsert_Update_Check) === TRUE) {
      echo "\nInsert Alarm CheckLine Complete";
    }

    //===========================5 Insert Update Check ================================

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


  function ReadEmoji($Msg_Line_Stop)
  {
    $emoji = [];
    $message =  explode("(E)", $Msg_Line_Stop);
    for ($j = 1; $j < count($message); $j++) { //ดึงค่าตัวเลข จาก(E)ไปใส่ Array
      array_push($emoji, substr($message[$j], 0, 6));
    }

    for ($j = 0; $j < count($emoji); $j++) { //เอาค่า ในArray มาreplace แทน ตัวเลขหลัง E
      $Msg_Line_Stop = str_replace($emoji[$j], EncodeEmoji($emoji[$j]), $Msg_Line_Stop);
    }

    $Msg_Line_Stop = str_replace("(n)", "\n", $Msg_Line_Stop); //replace(n)ขึ้นบรรทัดใหม่
    $Msg_Line_Stop = str_replace("(E)", "", $Msg_Line_Stop); //ลบ(E)ทิ้ง
    return $Msg_Line_Stop;
  }
