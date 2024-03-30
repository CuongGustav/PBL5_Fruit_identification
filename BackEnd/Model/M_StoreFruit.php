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
        
    }

        
    
?>