<?php

namespace app\controllers;

/**
 * Main 
 */
class Main extends App{
    /**
     * перевизначаємо шаблон для всіх action-iв класа Main
     * @var string 
     */
    //public $layout='main';
    public function indexAction() {
        echo '<b>Main::index</b> ';
    }
    
    public function testAction(){
        
    }
}
