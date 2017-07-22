<?php

namespace app\controllers\admin;

use vendor\core\base\View;

/**
 * Description of UserController
 */
class UserController extends AppController{
    //public $layout = 'default';
            
    public function indexAction(){
        View::setMeta('Адмінка :: Головна сторінка','Опис адмінки','Ключеві слова адмінки');
        $test='Тестова змінна';
        $data=['test','22'];
/*        $this->set([
            'test' => $test,
            'data' => $data,
        ]);*/
        $this->set(compact('test','data'));
    }
    
    public function testAction(){
        //$this->layout='admin';
    }
}
