<?php
$url = 'https://patkolpae.com/IOT_linebot/API-IC-PlateICE/API_push_TodayProblemCompOff.php';
$data = array(
        'main_machine_ID' => "PK99990PKKK01PI01"
);

// $data[0]['trans_ID'] = '11'; 

// use key 'http' even if you send the request to https://...
$options = array(
    'http' => array(
        'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
        'method'  => 'POST',
        'content' => http_build_query($data)
    )
);
$context  = stream_context_create($options);
$result = file_get_contents($url, false, $context);
if ($result === FALSE) { /* Handle error */ }

var_dump($result);
