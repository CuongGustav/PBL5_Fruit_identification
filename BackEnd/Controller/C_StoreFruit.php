<?php 
    include_once('../Model/M_StoreFruit.php');
    class Ctrl_StoreFruit{
        public function invoke(){
            if(isset($_GET['login'])){
                if(isset($_GET['text_Email']) && isset($_GET['text_Password'])){
                    $modelAccount = new Model_StoreFruit();
                    $account = $modelAccount->account_Login($_GET['text_Email'], $_GET['text_Password']);
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
                $deleProduct = $modelProduct->DeleteProduct($_GET['ID']);
                header('Location: /PBL5_Fruit_identification/FrontEnd/forms/ProductForm.php');
            }
            elseif(isset($_GET['upProduct'])) {
                $id = $_GET['ID'];
                $modelProduct =  new Model_StoreFruit();
                $updateProduct = $modelProduct->DetaiProduct($_GET['ID']);
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
        }        
    }
    $C_StoreFruit = new Ctrl_StoreFruit();
    $C_StoreFruit -> invoke();
?>