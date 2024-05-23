<?php
header('Content-Type: application/json');
session_start();
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    // Xử lý yêu cầu GET nếu cần
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method for GET']);
} elseif ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Nhận dữ liệu JSON từ yêu cầu POST
    $data = json_decode(file_get_contents('php://input'), true);

    // Kiểm tra xem dữ liệu có tồn tại và là một mảng không
    if ($data && isset($data['products']) && is_array($data['products'])) {
        $products =  $data['products'];
        $_SESSION['savedProducts'] = $products;
        // Kiểm tra xem mảng sản phẩm có phần tử hay không
        if (!empty($_SESSION['savedProducts'])) {
            // Hiển thị danh sách sản phẩm
            // echo $products;
            echo json_encode(['status' => 'success', 'message' => 'Products received successfully', 'products' => $products]);
            header('Location: ../../BackEnd/Controller/thu.php');
            exit;
        } else {
            // Nếu mảng sản phẩm trống
            echo json_encode(['status' => 'error', 'message' => 'No products received']);
        }
    } else {
        // Nếu dữ liệu không hợp lệ
        echo json_encode(['status' => 'error', 'message' => 'Invalid data received']);
    }
} else {
    // Nếu không phải là yêu cầu POST hoặc GET
    echo json_encode(['status' => 'error', 'message' => 'Invalid request method']);
}
?>
