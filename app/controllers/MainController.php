<?php

namespace app\controllers;

use app\models\Main;
use R;//RedBeanPHP для роботи з БД


/**
 * Main 
 */
class MainController extends AppController{
    /**
     * перевизначаємо шаблон для всіх action-iв класа Main
     * @var string 
     */
    //public $layout='main';
    
    public function indexAction() {
        //echo '<b>Main::index</b> ';
        //$model = new Main;//достатньо одного об'єкта моделі, щоби підключитись до БД
        $posts=R::findAll('posts');
        $menu=$this->menu;
        //$posts = $model ->findAll();
        //$post=$model->findOne(2);
        //$data=$model->findBySql("SELECT * FROM posts ORDER BY id DESC LIMIT 2");
        //$data=$model->findBySql("SELECT * FROM {$model->table} WHERE title LIKE ? LIMIT 2",['%tl%']);
        //$data=$model->findLike('7','article');
        
        $title='FWPHP';//можна поміняти title в шаблоні
        $this->set(compact('title','posts','menu'));
    }
    
    public function testAction(){
        
    }
}
