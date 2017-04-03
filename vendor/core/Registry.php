<?php

namespace vendor\core;

/**
 * Description of Registry
 *
 * @author Maxym
 */
class Registry {
    use TSingletone;
    
    public static $objects = [];
//    protected static $instance;
    
    protected function __construct() {
        require_once ROOT.'/config/config.php';
        foreach($config['components'] as $name=>$component){
            self::$objects[$name]=new $component;
        }
    }
    
/*    public static function instance(){
        //сінглтон,якщо підключення до БД нема,то створимо його
        if(self::$instance===null){
            self::$instance=new self;
        }
        return self::$instance;
    }
*/
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
