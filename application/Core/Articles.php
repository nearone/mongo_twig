<?php

class Articles extends Core{
    
    public $name = "articles";
    
    public function __construct() {
        parent::__construct();
        $this->collection = $this->db->{$this->name};
    }
    
}

