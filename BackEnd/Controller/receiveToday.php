<?php
    include_once('../../BackEnd/Model/M_StoreFruit.php');
    date_default_timezone_set('Asia/Ho_Chi_Minh');
    $Date = date("Y-m-d");
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
    header('Content-Type: application/json');
    echo json_encode($data);
?>
