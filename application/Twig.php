<?php
 
class Twig {
 
  /**
   * @var Singleton
   * @access private
   * @static
   */
   private static $_instance = null;
   public $view;
 
   /**
    * Constructeur de la classe
    *
    * @param void
    * @return void
    */
   private function __construct() {  
       
       $oLoader = new Twig_Loader_Filesystem(APPLICATION_PATH . '/views/');
        $this->view = new Twig_Environment($oLoader, array(
            //'cache' => CACHE_PATH,
        ));
       
   }
 
   /**
    * Méthode qui crée l'unique instance de la classe
    * si elle n'existe pas encore puis la retourne.
    *
    * @param void
    * @return Singleton
    */
   public static function getInstance() {
 
     if(is_null(self::$_instance)) {
       self::$_instance = new Twig();  
     }
 
     return self::$_instance;
   }
}

