<?php

namespace vendor\widgets\menu;

use vendor\libs\Cache;

class Menu {
    protected $data;
    protected $tree;
    protected $menuHtml;
    protected $tpl;//шлях до шаблону
    protected $container = 'ul';//в який тег буде загорнуте меню
    protected $class = 'menu';
    protected $table = 'categories';//таблиця БД з якої беруться дані(мають бути поля id.title,parent)
    protected $cache = 3600;
    protected $cacheKey = 'fw_menu';


    public function __construct($options=[]) {
        $this->tpl = __DIR__ .'/menu_tpl/menu.php';
        $this->getOptions($options);
        $this->run();
        //echo 'Widget Menu';
    }
    
    protected function getOptions($options){
        foreach ($options as $k => $v){
            if(property_exists($this,$k)){
                $this->$k = $v;
            }
        }
    }
    
    protected function output(){
        echo "<{$this->container} class='{$this->class}'>";
            echo $this->menuHtml;
        echo "</{$this->container}>";
    }

    protected function run(){
        $cache = new Cache();
        $this->menuHtml = $cache->get($this->cacheKey);
        if (!$this->menuHtml){
            $this->data = \R::getAssoc("SELECT * FROM {$this->table}");
            $this->tree = $this->getTree();
            $this->menuHtml = $this->getMenuHtml($this->tree);
            $cache->set($this->cacheKey, $this->menuHtml, $this->cache);
        }
        $this->output();
        //debug($this->tree);
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
        $str = '';
        foreach ($tree as $id => $category){
            $str .= $this->catToTemplate($category, $tab, $id);
        }
        return $str;
    }
    
    protected function catToTemplate($category,$tab,$id){
        ob_start();
        require $this->tpl;
        return ob_get_clean();
    }
    
}
