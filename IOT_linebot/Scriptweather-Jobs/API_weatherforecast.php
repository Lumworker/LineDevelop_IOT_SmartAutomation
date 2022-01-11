<?php
// set_time_limit(0);
// ignore_user_abort(1);

include('./db_connect_Center_IOTPatkol.php');


$url = "https://data.tmd.go.th/api/Weather3Hours/V2/?uid=u64apiwat.mo&ukey=0b0cf164d18fd4bbecd8be7fad72313a";
$xmlfile = file_get_contents($url);
$new = simplexml_load_string($xmlfile); 
$convert = json_encode($new); 
$newArr = json_decode($convert, true); 

$Station = $newArr['Stations']['Station']; 
$i = 0;

foreach ($Station as $value) {
  //Set paramiter
 
  $WmoStationNumber  = $value['WmoStationNumber'];
  // $StationNameThai  = $value['StationNameThai'];
  $eventdate = $value['Observation']['DateTime'];
  $AirTemperature = $value['Observation']['AirTemperature'];
  $RelativeHumidity = $value['Observation']['RelativeHumidity'];

  // //Check condition
  // if($AirTemperature == '' ){
  //   $AirTemperature = null ;
  // }
  // if($RelativeHumidity == '' ){
  //   $RelativeHumidity = null ;
  // }

  //Query
  $Datasql = "EXEC SP_Insert_Weather_API '$WmoStationNumber','$eventdate','$AirTemperature','$RelativeHumidity'";
  $getDataResults = sqlsrv_query($conn, $Datasql);

  //Test Output on google chome
  echo $i ++;
  echo "</br>".$value['StationNameThai'];
  echo 'รหัส  :'. $value['WmoStationNumber']."</br>";
  echo 'จังหวัด :'. $value['Province']."</br>";
  echo 'สถานที่ :'. $value['StationNameThai']."</br>";
  echo 'event date :'. $value['Observation']['DateTime']."</br>";
  echo 'อุณหภูมิ :'. $value['Observation']['AirTemperature']."</br>";
  echo 'ความชื้น :'. $value['Observation']['RelativeHumidity']."</br>";
  echo "_________________________________________________________ </br>";
  
}

sqlsrv_close($conn);
// echo "<script>window.close();</script>";
?>