<?php
include_once("../../BackEnd/Model/M_StoreFruit.php");

$model = new Model_StoreFruit();
$year = isset($_GET['year']) ? intval($_GET['year']) : 2024;

$months = [];
$total = [];

for ($i = 1; $i <= 12; $i++) {
    $months[] = sprintf("%d-%02d", $year, $i);
}

foreach($months as $month){
    $total[] = $model->getAllTotalMonth($month);
}

header('Content-Type: application/json');
echo json_encode($total);
?>
