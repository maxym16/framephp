<?php

namespace app\controllers;

use app\models\Main;
use R;//RedBeanPHP для роботи з БД
use \vendor\core\App;
use vendor\core\base\View;

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
        //App::$app->getList();
        //echo '<b>Main::index</b> ';
        $model = new Main;//достатньо одного об'єкта моделі, щоби підключитись до БД
        //данні або з кеша або з БД
        $posts=R::findAll('posts');
/*        $posts=App::$app->cache->get('posts');
        if(!$posts){
            $posts=R::findAll('posts');
            App::$app->cache->set('posts',$posts);
        }
*/        
        $post=R::findOne('posts','id = 2');
//        App::$app->cache->set('posts',$posts,3600*24);//закешувати на 24 години
        $menu=$this->menu;
        //$posts = $model ->findAll();
        //$post=$model->findOne(2);
        //$data=$model->findBySql("SELECT * FROM posts ORDER BY id DESC LIMIT 2");
        //$data=$model->findBySql("SELECT * FROM {$model->table} WHERE title LIKE ? LIMIT 2",['%tl%']);
        //$data=$model->findLike('7','article');
        
        //$title='FWPHP';//можна поміняти title в шаблоні
///        $this->setMeta('Home', 'description page', 'keywords');
//        $this->setMeta($post->title,$post->description,$post->keywords);
///        $meta= $this->meta;
        View::setMeta('Home', 'description page', 'keywords');
        $this->set(compact('posts','menu','meta'));
    }
    
    public function testAction(){
        if($this->isAjax()){
        $model=new Main();
        $post=R::findOne('posts',"id={$_POST['id']}");
        $this->loadView('_test', compact('post'));
        die(); 
//        exit();
        }
        echo 'no Ajax';
//        $this->layout=false; 
//        $this->layout='test'; 
        
    }
}
