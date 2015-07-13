<?php
 
class Data{
 
   private static $_instance = null;
   public $db;
 
   private function __construct() {  
       
       $oConnection = new Mongo();
       $this->db = $oConnection->selectDB('test'); 
       
   }
 
   public static function getInstance() {
 
     if(is_null(self::$_instance)) {
       self::$_instance = new Data();  
     }
 
     return self::$_instance;
   }
}

