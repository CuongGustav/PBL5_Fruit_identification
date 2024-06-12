<?php
    include_once("../../BackEnd/Model/M_StoreFruit.php");
    $month = isset($_GET['month1']) ? intval($_GET['month1']) : 0; 
    $year = isset($_GET['year1']) ? intval($_GET['year1']) : 0; 
    $date = sprintf("%d-%02d", $year, $month);
    $model = new Model_StoreFruit();
    $array = array();
    $array = $model->getProductMonth($date);
    $data = array();
    foreach ($array as $a) {
        $data[$a] = $model->getPriceProduct($date, $a);
    }
    arsort($data);
    echo json_encode($data);
?>
