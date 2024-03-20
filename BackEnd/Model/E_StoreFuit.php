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
?>