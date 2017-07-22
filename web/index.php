<?php
//error_reporting(-1);//виводити всі помилки
use vendor\core\Router;

//echo __FILE__.'<br />';//шлях до файла
define("DEBUG", 1);//development mode
define('WWW', __DIR__);//костанта, вказує на поточну теку /web
define('ROOT', dirname(__DIR__));//костанта, вказує на теку корня /fwphp
define('CORE', dirname(__DIR__).'/vendor/core');//костанта, вказує на теку /vendor/core
define('LIBS', dirname(__DIR__).'/vendor/libs');//костанта, вказує на теку /vendor/libs
define('APP', dirname(__DIR__).'/app');//костанта, вказує на теку /app
define('CACHE', dirname(__DIR__).'/tmp/cache');//костанта, вказує на теку /tmp/cache
define('LAYOUT','default');//шаблон по замовчанню

//echo $query=' параметри запиту = '.$_SERVER['QUERY_STRING'];//зчитуємо параметри запиту і виводимо на екран
//$query=rtrim($_SERVER['QUERY_STRING'],'/');//rtrim - обрізання '/' в кінці
$query=$_SERVER['QUERY_STRING'];//зчитуємо параметри запиту в $query
//require '../vendor/core/Router.php';//вмикає ф-л Router.php, підключає до PHP сценарію
require '../vendor/libs/functions.php';//function роздруківки дебага
//debug($_GET);//друкуємо GET-масив
//require '../app/controllers/Main.php';//підключаємо контролер
//require '../app/controllers/Posts.php';//підключаємо контролер
//require '../app/controllers/PostsNew.php';//підключаємо контролер

//робимо ф-ю автозавантаження класів, підключаємо Router.php
//Функція автозавантаження працює так. Коли в коді використовується клас,
//який не був раніше підключений, тоді викликається функція автозавантаження,
//яка спробує підключити даний клас, ім'я якого буде передано параметром.
//т.т. користувач вводить ім'я контролера ,яке є класом контролера
//завдяки namespace знайде будь-який клас
spl_autoload_register(function($class){
    $file=ROOT.'/'.str_replace('\\', '/', $class).'.php';//міняємо \ на /
    //$file=APP."/controllers/$class.php";
    if(is_file($file)){
        require_once $file;
    }
});
//для доступу до об'єктів реєстра(Registry)
new \vendor\core\App;
//$router=new Router();
//приклад статичних маршрутів :
//Router::add('posts/add',['controller'=>'Posts','action'=>'add']);//1-ше правило
//Router::add('posts',['controller'=>'Posts','action'=>'index']);//2-е правило
//Router::add('',['controller'=>'Main','action'=>'index']);//3 правило,дефолтне правило

//правило переходу на сторінку по параметру<alias>(<controller>=Page,<action>=view)
Router::add('^page/(?P<action>[a-z-]+)/(?P<alias>[a-z-]+)$',['controller'=>'Page']);
Router::add('^page/(?P<alias>[a-z-]+)$',['controller'=>'Page','action'=>'view']);

//доступ до адмінки
Router::add('^admin$',['controller'=>'User','action'=>'index','prefix'=>'admin']);
Router::add('^admin/?(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$',['prefix'=>'admin']);

//^-початок рядка, $-кінець рядка,дефолтне правило
Router::add('^$',['controller'=>'Main','action'=>'index']);
//2-ге дефолтне правило верифікації з ключами-аліасами ?P<controller>
//?( ?P<action> )?- необов'язковий
Router::add('^(?P<controller>[a-z-]+)/?(?P<action>[a-z-]+)?$');
//Router::add('<controller:[a-z-]+>/<action:[a-z-]+>');//Yii,2-ге дефолтне правило венифікації з ключами-аліасами

//print_r(Router::getRoutes());
//debug(Router::getRoutes());//виводимо правилa на екран
Router::dispatch($query);
//if (Router::matchRoute($query)){
//    echo 'matchRoute=';
//    debug(Router::getRoute());//якщо запит співпадає з шаблонами(правилами) заданими в index.php
//} else {
//    echo 'Error 404. Сторінки немає';
//}
