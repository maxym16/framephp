<?php

namespace vendor\widgets\menu;

class Menu {
    protected $data;
    protected $tree;
    protected $menuHtml;
    protected $tpl;//шлях до шаблону
    protected $container;//в який тег буде загорнуте меню
    protected $table;//таблиця БД з якої беруться дані(мають бути поля id.title,parent)
    protected $cache;
    
    public function __construct() {
        $this->run();
        //echo 'Widget Menu';
    }
    
    protected function run(){
        $this->data = \R::getAssoc("SELECT * FROM categories");
        $this->tree = $this->getTree();
        debug($this->tree);
    }
    
    protected function getTree(){
	$tree = [];
        $data = $this->data;
	foreach ($data as $id=>&$node) {    
		if (!$node['parent']){
			$tree[$id] = &$node;
		}else{ 
            $data[$node['parent']]['childs'][$id] = &$node;
		}
	}
	return $tree;
    }
    
    protected function getMenuHtml($tree,$tab=''){
        
    }
    
    protected function catToTemplate($category,$tab,$id){
        
    }
    
}
