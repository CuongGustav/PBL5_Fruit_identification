<?php
    include_once("E_StoreFuit.php");
    class Model_StoreFruit{
        public function __construct()
        {
            
        }

        public function getAllAccount_Staff(){
            $link = mysqli_connect("localhost", "root", "") or die("No connection Mysql!!");
            mysqli_select_db($link, "pbl5");
            $sql = "SELECT * FROM account WHERE Role = 1";
            $rs = mysqli_query($link, $sql);
            $count = mysqli_num_rows($rs);
            if($count > 0){
                $i = 0;
                while($row = mysqli_fetch_array($rs)){
                    $id = $row['ID'];
                    $email = $row['Email'];
                    $password = $row['PassWord'];
                    $fullname = $row['Name'];
                    $role = $row['Role'];
                    $Admin_Staff[++$i] = new Entity_Account($id, $email, $password, $fullname, $role);
                }
                return $Admin_Staff;
            }
            else{
                return  null;
            }
       }

       public function account_Login($_Email, $_PassWord){
            $link = mysqli_connect("localhost", "root", "") or die("No connection Mysql!!");
            mysqli_select_db($link, "pbl5");
            $sql = "SELECT * FROM account WHERE Email = '".$_Email."' AND PassWord = '".$_PassWord."' ";
            $rs = mysqli_query($link, $sql);
            $count = mysqli_num_rows($rs);
            if($count > 0){
                while($row = mysqli_fetch_array($rs)){
                    $role = $row['Role'];
                }
                return $role;
            }
       }

       public function insertAccount($_Email, $_Password, $_fullName){
            $link = mysqli_connect("localhost", "root", "") or die("No Connection");
            mysqli_select_db($link,"pbl5");
            $sql = " INSERT INTO account (Email, PassWord, Name, Role) VALUES ('$_Email', '$_Password', '$_fullName', 1)";
            mysqli_query($link, $sql);
        }

        public function check_Account($_Email){
            $link = mysqli_connect("localhost", "root", "") or die("No connection Mysql!!");
            mysqli_select_db($link, "pbl5");
            $sql = "SELECT * FROM account WHERE Email = '".$_Email."'";
            $rs = mysqli_query($link, $sql);
            $count = mysqli_num_rows($rs);
            return $count;
        }

        public function getAllProduct(){
            $link = mysqli_connect("localhost", "root", "") or die("No connection Mysql!!");
            mysqli_select_db($link, "pbl5");
            $sql = "SELECT * FROM product";
            $rs = mysqli_query($link, $sql);
            $count = mysqli_num_rows($rs);
            if($count > 0){
                $i = 0;
                while($row = mysqli_fetch_array($rs)){
                    $id = $row['ID_Product'];
                    $name = $row['Name_Product'];
                    $price = $row['Price'];
                    $picture = $row['Picture'];
                    $product[++$i] = new Entity_Product($id, $name, $price, $picture);
                }
                return $product;
            }
        }
        public function DeleteProduct($_id){
            $link = mysqli_connect("localhost", "root", "") or die("No connection!!!");
            mysqli_select_db($link,"pbl5");
            $sql = "DELETE FROM product WHERE ID_Product = '".$_id."'";
            mysqli_query($link, $sql);    
        }
        public function DeleteStaff($_id){
            $link = mysqli_connect("localhost", "root", "") or die("No connection!!!");
            mysqli_select_db($link,"pbl5");
            $sql = "DELETE FROM account WHERE ID = '".$_id."'";
            mysqli_query($link, $sql);    
        }

        public function DetaiProduct($_id){
            $link = mysqli_connect("localhost", "root", "") or die("No connection!!!");
            mysqli_select_db($link,"pbl5");
            $sql = "SELECT * FROM product WHERE ID_Product = '".$_id."'";
            $rs = mysqli_query($link, $sql);   
            while($row = mysqli_fetch_array($rs)){
                $id = $row['ID_Product'];
                $name = $row['Name_Product'];
                $price = $row['Price'];
                $picture = $row['Picture'];
                $product[0] = new Entity_Product($id, $name, $price, $picture);
            }
            return $product; 
        }

        public function updateFullProduct($_ID, $_Price, $new_picture) {
            $link = mysqli_connect("localhost", "root", "") or die("No Connection");
            mysqli_select_db($link, "pbl5");
            $sql = "UPDATE product SET Price=?, Picture = ? WHERE ID_Product=?";
            $stmt = mysqli_prepare($link, $sql);
            if ($stmt) { 
                mysqli_stmt_bind_param($stmt, "dsi", $_Price, $new_picture, $_ID);
                if (mysqli_stmt_execute($stmt)) {
                    echo "Product updated successfully.";
                } else {
                    echo "ERROR: Could not execute $sql. " . mysqli_error($link);
                }
            } else {
                echo "ERROR: Could not prepare statement. " . mysqli_error($link);
            }
            // Đóng câu lệnh SQL
            mysqli_stmt_close($stmt);
        }
        public function updateProduct($_ID, $_Price) {
            $link = mysqli_connect("localhost", "root", "") or die("No Connection");
            mysqli_select_db($link, "pbl5");
            $price = mysqli_real_escape_string($link, $_Price);
            $id = mysqli_real_escape_string($link, $_ID);
            $sql = "UPDATE product SET Price='$price' WHERE ID_Product='$id'";
            if(mysqli_query($link, $sql)) {
                echo "Product updated successfully.";
            } else {
                echo "Error updating product: " . mysqli_error($link);
            }
            mysqli_close($link);
        }
        public function detail_account_Login_id($id){
            $link = mysqli_connect("localhost", "root", "") or die("No connection Mysql!!");
            mysqli_select_db($link, "pbl5");
            $sql = "SELECT * FROM account WHERE ID = '".$id."'";
            $rs = mysqli_query($link, $sql);
            $count = mysqli_num_rows($rs);
            if($count > 0){
                while($row = mysqli_fetch_array($rs)){
                    $id = $row['ID'];
                    $email = $row['Email'];
                    $passWord = $row['PassWord'];
                    $name = $row['Name'];
                    $role = $row['Role'];
                    $Admin_Staff[0] = new Entity_Account($id, $email, $passWord, $name, $role);
                }
                return $Admin_Staff;
            }
       }
    
        public function updateAccount($_ID, $Name, $passWord) {
            $link = mysqli_connect("localhost", "root", "") or die("No Connection");
            mysqli_select_db($link, "pbl5");
            $name = mysqli_real_escape_string($link, $Name);
            $id = mysqli_real_escape_string($link, $_ID);
            $password = mysqli_real_escape_string($link, $passWord);
            $sql = "UPDATE account SET Name='$name', PassWord = '$password' WHERE ID='$id'";
            mysqli_query($link, $sql);
            mysqli_close($link);
        }

        public function detail_account_Login($_Email, $_PassWord){
            $link = mysqli_connect("localhost", "root", "") or die("No connection Mysql!!");
            mysqli_select_db($link, "pbl5");
            $sql = "SELECT * FROM account WHERE Email = '".$_Email."' AND PassWord = '".$_PassWord."' ";
            $rs = mysqli_query($link, $sql);
            $count = mysqli_num_rows($rs);
            if($count > 0){
                while($row = mysqli_fetch_array($rs)){
                    $id = $row['ID'];
                    $email = $row['Email'];
                    $passWord = $row['PassWord'];
                    $name = $row['Name'];
                    $role = $row['Role'];
                    $Admin_Staff[0] = new Entity_Account($id, $email, $passWord, $name, $role);
                }
                return $Admin_Staff;
            }
        }

        public function getMaxIDBill(){
            $link = mysqli_connect("localhost", "root", "") or die("No connection Mysql!!");
            mysqli_select_db($link, "pbl5");
            $sql = "SELECT MAX(ID_Bill) AS maxID FROM bill";
            $rs = mysqli_query($link, $sql);
            if ($rs && mysqli_num_rows($rs) > 0) {
                $row = mysqli_fetch_assoc($rs);
                $maxID = $row['maxID'];
            } else {
                $maxID = null; // hoặc một giá trị mặc định khác phù hợp với ứng dụng của bạn
            }
            mysqli_close($link);
        
            return $maxID;
        }

        public function getAllBill(){
            $link = mysqli_connect("localhost", "root", "") or die("No connection Mysql!!");
            mysqli_select_db($link, "pbl5");
            $sql = "SELECT * FROM bill, account WHERE ID = ID_Staff";
            $rs = mysqli_query($link, $sql);
            $count = mysqli_num_rows($rs);
            if($count > 0){
                $i = 0;
                while($row = mysqli_fetch_array($rs)){
                    $id = $row['ID_Bill'];
                    $nameStaff = $row['Name'];
                    $total = $row['Total'];
                    $date = $row['Date'];
                    $List_Bill[++$i] = new Entity_Bill($id, $nameStaff, $date, $total);
                }
                return $List_Bill;
            }
            else{
                return  null;
            }
        }

        public function detail_bill($id){
            $link = mysqli_connect("localhost", "root", "") or die("No connection Mysql!!");
            mysqli_select_db($link, "pbl5");
            $sql = "SELECT * FROM bill, account WHERE ID = ID_Staff AND ID_Bill = '".$id."'";
            $rs = mysqli_query($link, $sql);
            $detail_Bill = array(); // Khởi tạo mảng để chứa thông tin hóa đơn
            if($rs && mysqli_num_rows($rs) > 0){
                while($row = mysqli_fetch_array($rs)){
                    $id = $row['ID_Bill'];
                    $nameStaff = $row['Name'];
                    $total = $row['Total'];
                    $date = $row['Date'];
                    $detail_Bill[] = new Entity_Bill($id, $nameStaff, $date, $total);
                }
            }
            return $detail_Bill;
        }

        public function getAllProduct_Shopping_Cart($id){
            $link = mysqli_connect("localhost", "root", "") or die("No connection Mysql!!");
            mysqli_select_db($link, "pbl5");
            $sql = "SELECT * FROM shopping_cart WHERE ID_Bill = '".$id."'";
            $rs = mysqli_query($link, $sql);
            $count = mysqli_num_rows($rs);
            if($count > 0){
                $i = 0;
                while($row = mysqli_fetch_array($rs)){
                    $nameproduct = $row['Name_product'];
                    $price = $row['price'];
                    $weighed = $row['Weigh'];
                    $listProduct[++$i] = new Entity_Shopping_Cart($nameproduct, $weighed, $price);
                }
                return $listProduct;
            }
            else{
                return  null;
            }
        }

        public function getPrice($_nameProduct){
            $link = mysqli_connect("localhost", "root", "") or die("No connection Mysql!!");
            mysqli_select_db($link, "pbl5");
            $sql = "SELECT * FROM product WHERE Name_Product = '".$_nameProduct."'";
            $rs = mysqli_query($link, $sql);
            $count = mysqli_num_rows($rs);
            if($count > 0){
                while($row = mysqli_fetch_array($rs)){
                    $role = $row['Price'];
                }
                return $role;
            }
        }

        public function insertShop_Cart($_IDBill, $_Name, $_Weigh, $_Price){
            $link = mysqli_connect("localhost", "root", "") or die("No Connection");
            mysqli_select_db($link,"pbl5");
            $sql = "INSERT INTO shopping_cart (ID_Bill, Name_product, Weigh, price) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, "ssdd", $_IDBill, $_Name, $_Weigh, $_Price);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            mysqli_close($link);
        }
        
        public function insertBill($_IDBill, $_IDStaff, $_Date, $_Total){
            $link = mysqli_connect("localhost", "root", "") or die("No Connection");
            mysqli_select_db($link,"pbl5");
            $_Date = date('Y-m-d H:i:s', strtotime($_Date));
            $sql = "INSERT INTO bill (ID_Bill, ID_Staff, Date, Total) VALUES (?, ?, ?, ?)";
            $stmt = mysqli_prepare($link, $sql);
            mysqli_stmt_bind_param($stmt, "sssd", $_IDBill, $_IDStaff, $_Date, $_Total);
            mysqli_stmt_execute($stmt);
            mysqli_stmt_close($stmt);
            mysqli_close($link);
        }

        public function getAllTotalToday($_Date){
            $link = mysqli_connect("localhost", "root", "", "pbl5");
            if (!$link) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $_Date = date('Y-m-d', strtotime($_Date));
            $sql = "SELECT Total FROM bill WHERE DATE(date) = ?";
            $total = 0;
            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $_Date);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $rowTotal);
                while (mysqli_stmt_fetch($stmt)) {
                    $total += $rowTotal;
                }
                mysqli_stmt_close($stmt);
            }
            mysqli_close($link);
            return $total;
        }
        public function getTotalBillToday($date) {
            $link = mysqli_connect("localhost", "root", "", "pbl5");
            if (!$link) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $date = date('Y-m-d', strtotime($date));
            $sql = "SELECT * FROM bill WHERE DATE(date) = ?";
            $stmt = mysqli_prepare($link, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 's', $date);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                $count = mysqli_num_rows($result);
                mysqli_stmt_close($stmt);
            } else {
                $count = 0;
            }
            mysqli_close($link);
            return $count;
        }

        public function getIDBillToday($date) {
            $link = mysqli_connect("localhost", "root", "", "pbl5");
            if (!$link) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $idBills = array();
            $date = date('Y-m-d', strtotime($date));
            $sql = "SELECT ID_Bill FROM bill WHERE DATE(date) = ?";
            $stmt = mysqli_prepare($link, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 's', $date);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)) {
                    $idBills[] = $row['ID_Bill'];
                }
                mysqli_stmt_close($stmt);
            }
            mysqli_close($link);
            
            return $idBills;
        }

        public function getALlWeighToday($_IDBill){
            $link = mysqli_connect("localhost", "root", "") or die("No connection Mysql!!");
            mysqli_select_db($link, "pbl5");
            $sql = "SELECT * FROM shopping_cart WHERE ID_Bill = '".$_IDBill."'";
            $rs = mysqli_query($link, $sql);
            $total = 0;
            if($rs && mysqli_num_rows($rs) > 0){
                while($row = mysqli_fetch_array($rs)){
                    $total += $row['Weigh'];
                }
            }
            return $total;
        }

        public function getIDBillMonth($month) {
            $link = mysqli_connect("localhost", "root", "", "pbl5");
            if (!$link) {
                die("Connection failed: " . mysqli_connect_error());
            }  
            $idBills = array();
            $month = date('Y-m', strtotime($month));
            $sql = "SELECT ID_Bill FROM bill WHERE DATE_FORMAT(date, '%Y-%m') = ?";
            $stmt = mysqli_prepare($link, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 's', $month);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                while ($row = mysqli_fetch_assoc($result)) {
                    $idBills[] = $row['ID_Bill'];
                }
                mysqli_stmt_close($stmt);
            }
            mysqli_close($link);
            return $idBills;
        }
        
        public function getProductMonth($date) {
            $link = mysqli_connect("localhost", "root", "", "pbl5");
            if (!$link) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $products = array();
            $sql = "SELECT shopping_cart.Name_product
                    FROM bill
                    JOIN shopping_cart ON bill.ID_Bill = shopping_cart.ID_Bill
                    WHERE DATE_FORMAT(bill.Date, '%Y-%m') = ?";
            
            $stmt = mysqli_prepare($link, $sql);
            if ($stmt) {
                mysqli_stmt_bind_param($stmt, 's', $date);
                mysqli_stmt_execute($stmt);
                $result = mysqli_stmt_get_result($stmt);
                if ($result) {
                    while ($row = mysqli_fetch_assoc($result)) {
                        $products[] = $row['Name_product'];
                    }
                } else {
                    echo "Error: " . mysqli_error($link);
                }
                mysqli_stmt_close($stmt);
            } else {
                echo "Error: " . mysqli_error($link);
            }
        
            mysqli_close($link);
            
            return $products;
        }
        
        
        public function getPriceProduct($date, $name) {
            $link = mysqli_connect("localhost", "root", "", "pbl5");
            if (!$link) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $formattedDate = date('Y-m', strtotime($date)) . '%';
            $totalPrice = 0.0;
            $sql = "SELECT SUM(shopping_cart.price) as total_price
                    FROM bill 
                    JOIN shopping_cart ON bill.ID_Bill = shopping_cart.ID_Bill 
                    WHERE bill.Date LIKE ? AND shopping_cart.Name_product = ?";
            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, 'ss', $formattedDate, $name);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $totalPrice);
                mysqli_stmt_fetch($stmt);
                mysqli_stmt_close($stmt);
            } else {
                echo "Error: " . mysqli_error($link);
            }
            mysqli_close($link);
            return $totalPrice;
        }
        
        public function getAllTotalMonth($_Date){
            $link = mysqli_connect("localhost", "root", "", "pbl5");
            if (!$link) {
                die("Connection failed: " . mysqli_connect_error());
            }
            $formattedDate = date('Y-m', strtotime($_Date)) . '%';
            $sql = "SELECT Total FROM bill WHERE bill.Date LIKE ?";
            $total = 0;
            if ($stmt = mysqli_prepare($link, $sql)) {
                mysqli_stmt_bind_param($stmt, "s", $formattedDate);
                mysqli_stmt_execute($stmt);
                mysqli_stmt_bind_result($stmt, $rowTotal);
                while (mysqli_stmt_fetch($stmt)) {
                    $total += $rowTotal;
                }
                mysqli_stmt_close($stmt);
            }
            mysqli_close($link);
            return $total;
        }
        


    } 
    
?>