<?php
    class Entity_Account{
        public $ID;
        public $Email;
        public $FullName;
        public $PassWord;
        public $Role;

        public function __construct($ID, $Email, $PassWord, $FullName, $Role){
            $this->ID = $ID;
            $this->Email = $Email;
            $this->PassWord = $PassWord;
            $this->FullName = $FullName;
            $this->Role = $Role;
        }

        public function getRole(){
            return $this->Role;
        }
        
    }

    class Entity_Product{
        public $ID;
        public $NameProduct;
        public $Price;
        public $Picture;

        public function __construct($_ID, $_NameProduct, $_Price, $_Picture)
        {
            $this->ID = $_ID;
            $this->NameProduct = $_NameProduct;
            $this->Price = $_Price;
            $this->Picture = $_Picture;
        }
    }

    class Entity_Bill{
        public $ID_Bill;
        public $Name_Staff;
        public $Date;
        public $Total;

        public function __construct($_ID, $_Name_Staff, $_Date, $_Total)
        {
            $this->ID_Bill = $_ID;
            $this->Name_Staff = $_Name_Staff;
            $this->Date = $_Date;
            $this->Total = $_Total;
        }
    }

    class Entity_Shopping_Cart{
        public $Name_Product;
        public $Weighed;
        public $Total;

        public function __construct( $_Name_Product, $_Weighed, $_Total)
        {
            $this->Name_Product = $_Name_Product;
            $this->Weighed = $_Weighed;
            $this->Total = $_Total;
        }
    }
?>