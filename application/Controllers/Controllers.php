<?php

class Controllers{
    
    protected $_view;
    public $vars;
    protected $_template;
    
    public function __construct($sTemplate) {
        
        $oTwig = Twig::getInstance();
        $this->_view = $oTwig->view;
        $this->_template = $sTemplate;
    }
    
    protected function render($sTemplate = null){
                        
        if(!is_null($sTemplate)){
            $this->_template = $sTemplate;
        }
        
        return $this->_view->render($this->_template, $this->vars); 
        
    }
    
}

