<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../assets/css/base.css">
    <link rel="stylesheet" href="../assets/css/productForm.css">
    <link rel="stylesheet" href="../assets/fonts/fontawesome-free-6.5.1-web/fontawesome-free-6.5.1-web/css/all.min.css">
</head>
<body>
<form action="/PBL5_Fruit_identification/BackEnd/Controller/C_StoreFruit.php" method="get" enctype="multipart/form-data">
        <?php
        $link = mysqli_connect("localhost", "root", "") or die("No connection Mysql!!");
        mysqli_select_db($link, "pbl5");
        $sql = "SELECT * FROM product";
        $rs = mysqli_query($link, $sql);
        while($row = mysqli_fetch_array($rs)){
            $id = $row['ID_Product'];
            $name = $row['Name_Product'];
            $price = number_format($row['Price'], 0, ',', '.') . ' VNĐ';
            $picture = $row['Picture'];  
        ?>
        <div class="product__item col-four">
                <img src="data:image/jpeg;base64,<?php echo base64_encode($picture); ?>" alt="Hình ảnh sản phẩm" class="product__item-img">
                <div class="product__item-content">
                    <h1 class="product__item-name">Tên sản phẩm: <?php echo $name; ?></h1>
                    <h2 class="product__item-price">Giá: <?php echo $price; ?></h2>
                </div>
            </div>
      
        <?php        
        }
        ?>
</form>
</body>
</html>