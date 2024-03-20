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
        <form action="/PBL5_Fruit_identification/BackEnd/Controller/C_StoreFruit.php" method="get" enctype="multipart/form-data">
            <input type="hidden" name="ID" value="<?php echo $id; ?>">
            <div class="product__item col-four">
            <img src="data:image/jpeg;base64,<?php echo base64_encode($picture); ?>" alt="Image" class="product__item-img">
                    <div class="product__item-content">
                        <h1 class="">
                            Tên sản phẩm: 
                            <span class="product__item-name"><?php echo $name; ?></span>
                        </h1>
                        <h2>
                            Giá:
                            <span class="product__item-price"> <?php echo $price.'/kg'; ?></span>
                        </h2>
                        <div class="product__item-button">
                            <button type="submit" class="product__item-update" name="upProduct">Cập nhật</button>
                            <button type="submit" class="product__item-delete" name="delProduct">Xóa</button>
                        </div>
                    </div>
            </div>
        </form>
        <?php        
        }
        ?>
</body>
</html>