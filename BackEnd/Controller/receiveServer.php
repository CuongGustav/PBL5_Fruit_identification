<?php

    include_once("../Model/M_StoreFruit.php");
    function extractFruitData($url) {
        $response = file_get_contents($url);
        $data = json_decode($response, true);
        if (isset($data['fruits'])) {
            $fruitData = array();
            foreach ($data['fruits'] as $fruit) {
                $fruitInfo = array(
                    'name' => $fruit['name'],
                    'weight' => $fruit['weight']
                );
                $fruitData[] = $fruitInfo;
            }
            return $fruitData;
        } else {
            return array();
        }
    }

    $fruitsData = extractFruitData('https://server-1-c9nx.onrender.com/fruits/list_fruits');
    $fruitArray = array(
        'bo' => 'Bơ',
        'man' => 'Mận',
        'mang cut' => 'Măng Cụt',
        'cachua' => 'Cà Chua',
        'cam' => 'Cam',
        'chuoi' => 'Chuối',
        'duahau' => 'Dưa Hấu',
        'le' => 'Lê',
        'nho' => 'Nho',
        'quyt' => 'Quýt',
        'tao' => 'Táo',
        'thom' => 'Thơm',
        'xoai' => 'Xoài'
    );
    $getprice = new Model_StoreFruit();
    $products = [];
    $totalPrice = 0;
    if (!empty($fruitsData)) {
        foreach ($fruitsData as $fruit) {
            foreach ($fruitArray as $key => $value) {
                if ($key === $fruit['name']) {
                    $product = array(
                        'Name_Product' => $fruitArray[$key],
                        'Weighed' => $fruit['weight'] / 1000,
                        'Price' =>  $getprice->getPrice($fruitArray[$key]) * ($fruit['weight'] / 1000)
                    );
                    $products[] = $product;
                    $totalPrice = $totalPrice + $getprice->getPrice($fruitArray[$key]) * ($fruit['weight'] / 1000);
                    break; 
                }
            }
        }
    } else {
        echo json_encode(array('message' => 'No fruit data found'));
        exit;
    }

    $data = array(
        'products' => $products,
        'totalPrice' => $totalPrice
    );
    echo json_encode($data);
?>
