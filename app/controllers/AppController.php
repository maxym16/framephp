<?php

namespace app\controllers;

use vendor\core\base\Controller as Controller;
use R;//RedBeanPHP для роботи з БД
use app\models\Main;

/**
 * Description of App extends base Controller
 * @author Maxym
 */
class AppController extends Controller{
    
    public $menu;
    public $meta=[];

    public function __construct($route) {
        parent::__construct($route);
        new Main;//достатньо одного будь-якого об'єкта моделі, щоби підключитись до БД
        $this->menu=R::findAll('category');
    }

    protected function setMeta($title='',$desc='',$keywords=''){
        $this->meta['title']=$title;
        $this->meta['desc']=$desc;
        $this->meta['keywords']=$keywords;
    }
}
