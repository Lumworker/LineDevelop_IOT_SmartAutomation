<?php

require('./db_connect_Center_IOTPatkol.php');
$url = "https://data.tmd.go.th/api/Weather3Hours/V2/?uid=u64apiwat.mo&ukey=0b0cf164d18fd4bbecd8be7fad72313a";
$xmlfile = file_get_contents($url);
$new = simplexml_load_string($xmlfile); 
$convert = json_encode($new); 
$newArr = json_decode($convert, true); 

$Station = $newArr['Stations']['Station']; 
// $i = 0;
// $dupicate = array();
foreach ($Station as $value) {
  //Set paramiter
  $WmoStationNumber  = $value['WmoStationNumber'];
  $StationNameThai  = $value['StationNameThai'];
  $eventdate = $value['Observation']['DateTime'];
  $AirTemperature = $value['Observation']['AirTemperature'];
  $RelativeHumidity = $value['Observation']['RelativeHumidity'];


  echo ''. $value['WmoStationNumber'].' : '. $value['StationNameThai']."</br>";
  // echo "</br>".$value['StationNameThai'];
  // echo 'รหัส  :'. $value['WmoStationNumber']."</br>";
  // echo 'จังหวัด :'. $value['Province']."</br>";
  // echo 'สถานที่ :'. $value['StationNameThai']."</br>";
  // echo 'event date :'. $value['Observation']['DateTime']."</br>";
  // echo 'อุณหภูมิ :'. $value['Observation']['AirTemperature']."</br>";
  // echo 'ความชื้น :'. $value['Observation']['RelativeHumidity']."</br>";
  // echo "_________________________________________________________ </br>";
  //Check Dupicate
  // array_push($dupicate,$WmoStationNumber);
}


// print_r($dupicate);
// if (has_dupes($dupicate) == true){
//   echo 'true';
// } 
// else{
//   echo 'false';
// }
// function has_dupes($array) {
//   $dupe_array = array();
//   foreach ($array as $val) {
//       if (++$dupe_array[$val] > 1) {
//           return true;
//       }
//   }
//   return false;
// }
?>