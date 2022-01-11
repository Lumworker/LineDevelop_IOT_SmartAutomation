<?php
// require "../vendor/autoload.php";
include './db_connect.php';
// $sql2 = "EXEC [dbo].[SP_GET_Production_Data_Line] 'U0cfb6e104a4950d326e9b5354ec6f8dd','114'";
//         $getResults2 = sqlsrv_query($conn, $sql2);
//         $row2 = sqlsrv_fetch_array($getResults2, SQLSRV_FETCH_ASSOC);
//         $Cycle_B = $row2['Cycle_B'];
//         $Cycle_S = $row2['Cycle_S'];
//         $B = $row2['B'];
//         $PB = $row2['PB'];
//         $P2 = $row2['P2'];
//         $PC_B = $row2['PC_B'];
//         $R = $row2['R'];
//         $S = $row2['S'];
//         $PS = $row2['PS'];
//         $PC_S = $row2['PC_S'];
//         $LineToken_User3 = $row2['LineToken_User3'];

//         include("./FlexMassage-IC/PMS_Technician_Step2.php"); //แปะ $trans_id ทีี่ปุ่ม link
//         $sql3 = "EXEC [dbo].[SP_GET_Production_Data_Line] 'U0cfb6e104a4950d326e9b5354ec6f8dd','114'";
//         $getResults3 = sqlsrv_query($conn, $sql3);
//         while ($row3 = sqlsrv_fetch_array($getResults3, SQLSRV_FETCH_ASSOC)) {
//             $arrayBoxNew = [];
//             $main_machine_ID = $row3['main_machine_ID'];
//             $Size = $row3['Size'];
//             $Cycle = $row3['Cycle'];
//             $arrayBoxNew['type'] = "box";
//             $arrayBoxNew['layout'] = "baseline";
//             $arrayBoxNew['contents'][0]['type'] = "text";
//             $arrayBoxNew['contents'][0]['text'] = $main_machine_ID;
//             $arrayBoxNew['contents'][0]['flex'] = 0;
//             $arrayBoxNew['contents'][0]['margin'] = "sm";
//             $arrayBoxNew['contents'][0]['contents'] = [];
//             $arrayBoxNew['contents'][1]['type'] = "text";
//             $arrayBoxNew['contents'][1]['text'] = $Cycle . "ถุง";
//             $arrayBoxNew['contents'][1]['size'] = "md";
//             $arrayBoxNew['contents'][1]['color'] = "#000000FF";
//             $arrayBoxNew['contents'][1]['align'] = "end";
//             $arrayBoxNew['contents'][1]['contents'] = [];
//             if ($Size == "B") {
//                 array_push($jsonflex['contents']['body']['contents'][2]['contents'], $arrayBoxNew);
//             } else if ($Size == "S") {
//                 array_push($jsonflex['contents']['body']['contents'][4]['contents'], $arrayBoxNew);
//             }
//         }
// print_r($jsonflex);
$sql3 = "EXEC [dbo].[SP_GET_Production_Data_Line] 'U0cfb6e104a4950d326e9b5354ec6f8dd','134'";
$getResults3 = sqlsrv_query($conn, $sql3);
$row3 = sqlsrv_fetch_array($getResults3, SQLSRV_FETCH_ASSOC);
$pushID = array();
$LineToken_User2 = $row3['LineToken_User2'];
$LineToken_User3 = $row3['LineToken_User3'];
array_push($pushID, $LineToken_User2);
array_push($pushID, $LineToken_User3);

print_r($pushID);
echo count($pushID);
if (count($pushID) > 1) {
    echo "once";
} else {
    echo "multi";
}
?>