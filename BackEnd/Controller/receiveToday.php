<?php
include_once('../../BackEnd/Model/M_StoreFruit.php');
date_default_timezone_set('Asia/Ho_Chi_Minh'); // Set the timezone for Ho Chi Minh City

// Get today's date in 'Y-m-d' format to match the SQL query
$Date = date("Y-m-d");

// Instantiate the model and get the total for today
$modelstatistics = new Model_StoreFruit();
$totalToday = $modelstatistics->getAllTotalToday($Date);
$totalBill = $modelstatistics->getTotalBillToday($Date);
$listIDBill = $modelstatistics->getIDBillToday($Date);
$totalWeigh = 0;
foreach ($listIDBill as $idbill){
    $totalWeigh += $modelstatistics->getALlWeighToday($idbill);
}
$data = array(
    'totalToday' => $totalToday,
    'totalBill' => $totalBill,
    'totalWeigh' => $totalWeigh
);
// Return the result as a JSON object
header('Content-Type: application/json');
echo json_encode($data);
?>
