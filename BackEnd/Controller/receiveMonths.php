<?php
    include_once('../Model/M_StoreFruit.php');
    function getDaysInMonthArray($month, $year) {
        if (!is_numeric($month) || !is_numeric($year) || $month < 1 || $month > 12 || $year < 1) {
            return "Invalid input. Please enter a valid month (1-12) and year.";
        }
        $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);
        $daysArray = array();
        for ($day = 1; $day <= $daysInMonth; $day++) {
            $daysArray[] = sprintf("%04d-%02d-%02d", $year, $month, $day); // Định dạng ngày thành YYYY-MM-DD
        }
        return $daysArray;
    }
    $modelstatistics = new Model_StoreFruit();
    $month = isset($_GET['month']) ? intval($_GET['month']) : 0; // Lấy tháng từ query string
    $year = isset($_GET['year']) ? intval($_GET['year']) : 0; // Lấy năm từ query string
    if ($month < 1 || $month > 12 || $year < 1) {
        echo json_encode(["error" => "Invalid input. Please enter a valid month (1-12) and year."]);
        exit();
    }
    $daysArray = getDaysInMonthArray($month, $year);
    $totalPrices = array();
    foreach ($daysArray as $arrayday) {
        $totalPrice = $modelstatistics->getAllTotalToday($arrayday);
        $totalPrices[$arrayday] = $totalPrice;
    }

    echo json_encode($totalPrices);
?>
