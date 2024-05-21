<?php 
    include_once('../Model/M_StoreFruit.php');
    class Ctrl_StoreFruit{
        
        public function invoke(){
            session_start();
            if(isset($_GET['login'])){
                if(isset($_GET['text_Email']) && isset($_GET['text_Password'])){
                    $_SESSION['Email'] = $_GET['text_Email'];
                    $_SESSION['passWord'] = $_GET['text_Password'];
                    $modelAccount = new Model_StoreFruit();
                    $account = $modelAccount->account_Login($_GET['text_Email'], $_GET['text_Password']);
                    $DetailAccount = $modelAccount->detail_account_Login($_SESSION['Email'],  $_SESSION['passWord']);
                    $_SESSION['nameStaff'] = $DetailAccount[0]->FullName; 
                    $_SESSION['id'] = $DetailAccount[0]->ID;
                    if ($account != null) {
                        if($account == 0) {
                            header('Location: /PBL5_Fruit_identification/FrontEnd/forms/adminForm.html'); 
                        }
                        else{
                            header('Location: /PBL5_Fruit_identification/FrontEnd/forms/staffForm.html');
                        }
                    } else {
                        header('Location: /PBL5_Fruit_identification/FrontEnd/forms/login.html');
                    }
                    
                }
                
            }
            elseif(isset($_GET['signUp'])){
                if(isset($_GET['text_sign_up_email']) && isset($_GET['text_sign_up_password']) && isset($_GET['text_fullName'])){
                    $modelAccount = new Model_StoreFruit();
                    $count = $modelAccount->check_Account($_GET['text_sign_up_email']);
                    if($count == 0){
                        $insertAccount = $modelAccount->insertAccount($_GET['text_sign_up_email'], $_GET['text_sign_up_password'], $_GET['text_fullName']);
                        header('Location: /PBL5_Fruit_identification/FrontEnd/forms/login.html');
                    }
                    else{
                        header('Location: /PBL5_Fruit_identification/FrontEnd/forms/login.html');
                    }
                  
                }  
            }
            elseif(isset($_GET['delProduct'])) {
                $modelProduct =  new Model_StoreFruit();
                $deleProduct = $modelProduct->DeleteProduct($_GET['delProduct']);
                header('Location: /PBL5_Fruit_identification/FrontEnd/forms/ProductForm.php');
            }
            elseif(isset($_GET['updateProduct'])) {
                $modelProduct =  new Model_StoreFruit();
                $updateProduct = $modelProduct->DetaiProduct($_GET['updateProduct']);
                include_once("../../FrontEnd/forms/UpdateProductForm.html");
                // include_once('../../FrontEnd/forms/UpdateProductForm')
                echo "<script>window.location.hash = 'view';</script>";
            }
            elseif(isset($_POST['Cancel'])){
                header('Location: /PBL5_Fruit_identification/FrontEnd/forms/ProductForm.php');
            }
            elseif(isset($_POST['OK'])){  
                if (isset($_FILES['new_picture']) && !empty($_FILES['new_picture']['tmp_name'])) {
                    $imagee = $_FILES['new_picture']['tmp_name'];
                    $image = file_get_contents($imagee);
                    $modelProduct =  new Model_StoreFruit();
                    $updatefullProduct = $modelProduct->updateFullProduct($_POST['ID'], $_POST['new_price'], $image);
                    header('Location: /PBL5_Fruit_identification/FrontEnd/forms/ProductForm.php');
                } else {
                    $modelProduct =  new Model_StoreFruit();
                    $updateProduct = $modelProduct->updateProduct($_POST['ID'], (int)str_replace(".", "", $_POST['new_price']));
                    header('Location: /PBL5_Fruit_identification/FrontEnd/forms/ProductForm.php');
                }
            }
            elseif(isset($_GET['detailAccount'])){
                $modelAccount =  new Model_StoreFruit();
                $DetailAccount = $modelAccount->detail_account_Login_id($_SESSION['id']);
                include_once("../../FrontEnd/forms/detailAccount.html");
            }
            elseif(isset($_GET['ok_Account'])){
                $modelAccount =  new Model_StoreFruit();
                $updateAccount = $modelAccount->updateAccount($_SESSION['id'], $_GET['new_Name'], $_GET['new_Password']);
                $DetailAccount = $modelAccount->detail_account_Login_id($_SESSION['id']);
                include_once("../../FrontEnd/forms/detailAccount.html");
                echo "<script>window.location.hash = 'view';</script>";
            }
            elseif(isset($_GET['liststaff'])){
                $modelAccount = new Model_StoreFruit();
                $allStaff = $modelAccount->getAllAccount_Staff();
                include_once("../../FrontEnd/forms/ListStaff.html");
            }
            elseif(isset($_GET['deldelStaff'])) {
                $modelAccount =  new Model_StoreFruit();
                $deleStaff =$modelAccount->DeleteStaff($_GET['deldelStaff']);
                $allStaff = $modelAccount->getAllAccount_Staff();
                include_once("../../FrontEnd/forms/ListStaff.html");
            }
            elseif(isset($_GET['detailBill'])){
                $modelmodelBill =  new Model_StoreFruit();
                $maxIDBill = $modelmodelBill->getMaxIDBill();
                if (empty($maxIDBill)){
                    $ID_Bill =  102000;
                }
                else{
                    $ID_Bill =  $maxIDBill + 1;
                }
                $Name_Staff = $_SESSION['nameStaff'];
                date_default_timezone_set('Asia/Ho_Chi_Minh'); // Đặt múi giờ cho Hồ Chí Minh
                $time = strtotime('now');
                $DateTime = date("d-m-Y H:i:s", $time);
                include_once("../../FrontEnd/forms/detailBill.html");
            }
            elseif(isset($_GET['paymentBill'])){
                $modelBill = new Model_StoreFruit();
                $total = 0;
                if (isset($_SESSION['savedProducts'])) {
                    $products = $_SESSION['savedProducts'];
                    foreach ($products as $product) {
                        $total = $total + $modelBill->getPrice($product['Name_Product']) * $product['Weighed'];
                    }
                    $modelBill->insertBill($_GET['idBill'], $_SESSION['id'], $_GET['dateTime'],  $total);
                    $weigh_total = 0 ;
                    foreach ($products as $product) {
                        $weigh_total = $modelBill->getPrice($product['Name_Product']) * $product['Weighed'];
                        $modelBill->insertShop_Cart($_GET['idBill'], $product['Name_Product'], $product['Weighed'],  $weigh_total);
                    }
                    
                }
                $modelmodelBill =  new Model_StoreFruit();
                $maxIDBill = $modelmodelBill->getMaxIDBill();
                $ID_Bill =  $maxIDBill + 1;
                $Name_Staff = $_SESSION['nameStaff'];
                date_default_timezone_set('Asia/Ho_Chi_Minh'); // Đặt múi giờ cho Hồ Chí Minh
                require('../Controller/requestServer.php');
                $time = strtotime('now');
                $DateTime = date("d-m-Y H:i:s", $time);
                include_once("../../FrontEnd/forms/detailBill.html");
            }
            elseif(isset($_GET['seeBill'])){
                $modelBill = new Model_StoreFruit();
                $see_detailbill = $modelBill->detail_bill($_GET['seeBill']);
                $listProduct_Shopping_Cart = $modelBill->getAllProduct_Shopping_Cart($_GET['seeBill']);
                include_once("../../FrontEnd/forms/seeDetailBill.html");
            }
            elseif(isset($_GET['listBill'])){
                $modelBill = new Model_StoreFruit();
                $list_bill = $modelBill->getAllBill();
                include_once("../../FrontEnd/forms/ListBill.html");
            }
            elseif(isset($_GET['cancelSeeBill'])){
                $modelBill = new Model_StoreFruit();
                $list_bill = $modelBill->getAllBill();
                include_once("../../FrontEnd/forms/ListBill.html");
            }
            elseif(isset($_GET['inBill'])){
                $modelBill = new Model_StoreFruit();
                $see_detailbill = $modelBill->detail_bill($_GET['inBill']);
                $listProduct_Shopping_Cart = $modelBill->getAllProduct_Shopping_Cart($_GET['inBill']);
                include_once("../../BackEnd/PDF/generatePDF.php");
            }
            elseif(isset($_GET['statistics'])){
                // date_default_timezone_set('Asia/Ho_Chi_Minh'); // Đặt múi giờ cho Hồ Chí Minh
                // $time = strtotime('now');
                // $Date= date("d-m-Y", $time);
                // $modelstatistics = new Model_StoreFruit();
                // $totalToday =  $modelstatistics->getAllTotalToday($Date);
                // include_once('../../FrontEnd/forms/Today_Statistics.html');
                // header('Location:  ../../FrontEnd/forms/Today_Statistics.html');
                // $modelstatistics->getAllTotalToday($Date);
                include_once('../../FrontEnd/forms/formStatistics.html');
            }
           
        }        
    }
    $C_StoreFruit = new Ctrl_StoreFruit();
    $C_StoreFruit -> invoke();
?>