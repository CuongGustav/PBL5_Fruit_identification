<?php

    require_once('../../BackEnd/PDF/dompdf/autoload.inc.php');
    use Dompdf\Dompdf;
    use Dompdf\Options;

    // Khởi tạo Dompdf với các tùy chọn
    $options = new Options();
    $options->set('isHtml5ParserEnabled', true);
    $options->set('isPhpEnabled', true);
    $options->set('isRemoteEnabled', true);
    $options->set('defaultFont', 'DejaVu Sans'); // Sử dụng font DejaVu Sans hoặc Liberation Sans

    $dompdf = new Dompdf($options);
    $html_header = '<h1 style="text-align: center;">HÓA ĐƠN</h1>
    </br> 
    <div class="bill__item-content">
    
        <h2 class="bill__item-id">Mã Hóa Đơn: '.$see_detailbill[0]->ID_Bill.'</h2>
        <h2 class="bill__item-name">Nhân Viên: '.$see_detailbill[0]->Name_Staff.'</h2>
        <h2 class="bill__item-date">Ngày: '.$see_detailbill[0]->Date.'</h2>
    </div>

    <table border="1" width="100%">
    <caption style="font-size: 40px;"> Danh Sách Sản Phẩm </caption>
    <TR>
        <TH style="text-align: center;">Tên</TH>
        <TH style="text-align: center;">Cân Nặng</TH>
        <TH style="text-align: center;">Giá</TH>
    </TR>';

    // Khai báo phần động của chuỗi HTML
    $table_rows_html = '';
    for ($i = 1; $i <= count($listProduct_Shopping_Cart); $i++) {
        $table_rows_html .= '
        <tr>
            <td style="text-align: center;">' . $listProduct_Shopping_Cart[$i]->Name_Product . '</td>
            <td style="text-align: center;">' . $listProduct_Shopping_Cart[$i]->Weighed . ' Kg</td>
            <td style="text-align: center;">' . number_format($listProduct_Shopping_Cart[$i]->Total, 0, ',', '.') . ' VND</td>
        </tr>';
    }

    // Kết hợp các phần lại với nhau để tạo chuỗi HTML hoàn chỉnh
    $html = $html_header . $table_rows_html . '</TABLE>
    <h2 class="bill__item-total">Tổng: ' . number_format($see_detailbill[0]->Total, 0, ',', '.') . ' VND</h2>
    <h3 style="text-align: center;">Chúc quý khách vui vẻ, hẹn gặp lại!!!!</h3>
    ';


    $dompdf->loadHtml($html);

    $dompdf->setPaper('A4', 'landscape');

    $dompdf->render();

    // Lấy dữ liệu PDF dưới dạng chuỗi
    $pdf_content = $dompdf->output();

    // Hiển thị tài liệu PDF trong trình duyệt
    header('Content-Type: application/pdf');
    header('Content-Length: ' . strlen($pdf_content));
    header('Content-Disposition: inline; filename="bill.pdf"');
    echo $pdf_content;
?>
