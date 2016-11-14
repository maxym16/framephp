<?php
use vendor\core\Router;

define('WWW', __DIR__);
define('ROOT', dirname(__DIR__));
define('CORE', dirname(__DIR__).'/vendor/core');
define('APP', dirname(__DIR__).'/app');
define('LAYOUT','default');

$query=$_SERVER['QUERY_STRING'];
require '../vendor/libs/functions.php';//function роздруківки дебага

//робимо ф-ю автозавантаження класів, підключаємо Router.php
spl_autoload_register(function($class){
    $file=ROOT.'/'.str_replace('\\', '/', $class).'.php';
    //$file=APP."/controllers/$class.php";
    if(is_file($file)){
        require_once $file;
    }
});

//правило переходу на сторінку по параметру<alias>(<controller>=Page,<action>=view)
Router::add('^page/(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$',['controller'=>'Page']);
Router::add('^page/(?P<alias>[a-z-]+)$',['controller'=>'Page','action'=>'view']);

//^-початок рядка, $-кінець рядка,дефолтне правило
Router::add('^$',['controller'=>'Main','action'=>'index']);
//2-ге дефолтне правило венифікації з ключами-аліасами ?P<controller>,? ?P<action> ?- необов'язковий
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');

Router::dispatch($query);
