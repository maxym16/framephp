<?php

$config = [
    'components' => [
        'cache' => 'classes\Cache',
        'test' => 'classes\Test',
    ],
];

spl_autoload_register(function($class){
    $file=str_replace('\\', '/', $class).'.php';//міняємо \ на /
    //$file=APP."/controllers/$class.php";
    if(is_file($file)){
        require_once $file;
    }
});

/**
 * Description of index
 *
 * @author Maxym
 */
class Registry {
    public static $objects = [];
    protected static $instance;
    
    protected function __construct() {
        global $config;
        foreach($config['components'] as $name=>$component){
            self::$objects[$name]=new $component;
        }
    }
    
    public static function instance(){
        //сінглтон,якщо підключення до БД нема,то створимо його
        if(self::$instance===null){
            self::$instance=new self;
        }
        return self::$instance;
    }

    /*
     * при звернені до властивості, якої немає у об'єкта
     */
    public function __get($name) {
    //якщо $name -об'єкт, то повертає його
        if(is_object(self::$objects[$name])){
            return self::$objects[$name];
        }
    }
    
    /*
     * для створення об'єкта
     */
    public function __set($name,$object) {
        if(!isset(self::$objects[$name])){
            self::$objects[$name]= new $object;
        }
    }
    
    public function getList() {
        echo '<pre>';
        var_dump(self::$objects);
        echo '</pre>';
    }
}
$app=Registry::instance();
//$app->getList();
$app->test->go();
$app->test2='classes\Test2';
$app->getList();
$app->test2->hello();

