<?php
 
class Core {
 
   public $db;
   public $collection;
   
   public function __construct() {
       $oData = Data::getInstance();
       $this->db = $oData->db;
   }
    
}

