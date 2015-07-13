<?php

class Homepage extends Controllers {

    public function index() {

        $mArticles = new Articles();

        //get articles
        $this->vars['aArticles'] = $mArticles->collection->find()->limit(2);
        
        //get all categories
        $this->vars['aCategories'] = $mArticles->collection->distinct('category');
        
        /*foreach ($this->vars['aCategories'] as $aCategory)
        var_dump($aCategory);*/

        echo parent::render();
    }

}
