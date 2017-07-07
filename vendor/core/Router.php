<?php

namespace vendor\core;

/**
 * Router
 * @author Maxym
 */
class Router{
    /**
     * масив маршрутів,таблиця маршрутів
     * @var array
     */
    protected static $routes =[];
    /**
     * поточний маршрут
     * @var array
     */
    protected static $route =[];
    public static function add($regexp,$route=[]){ 
        self::$routes[$regexp]=$route;//заповнюємо таблицю маршрутів
    }
    public static function getRoutes(){
        return self::$routes;//продивляємось таблицю маршрутів
    }
    public static function getRoute(){
        return self::$route;//продивляємось поточний маршрут
    }
    
    /**
     * обробляємо запит, перевіряємо
     * чи співпадає з шаблонами(правилами) заданими в index.php
     * шукає URL в таблиці маршрутів(true or false)
     * @param string $url вхідний URL
     * @return boolean
     */
    public static function matchRoute($url){
        $matches =[];
        foreach (self::$routes as $pattern => $route){
            if(preg_match("#$pattern#i",$url,$matches)){
                //заносимо в self::$route значення ключів controller і action
                foreach ($matches as $key => $val){
                    if (is_string($key)){
                        $route[$key]=$val;
                    }
                }
                //action=index - по замовчанню
                if(!isset($route['action'])){
                    $route['action']='index';
                }
                //обробляємо upperCamelCase(), приводимо до виду PostsNew з posts-new
                $route['controller']=self::upperCamelCase($route['controller']);
                self::$route=$route;
                return TRUE;
            }
        }
        return FALSE;
    }
    
    /**
     * переспрямовує URL по коректному маршруту
     * @param string $url вхідний URL
     * @return void
     */
    public static function dispatch($url){
        $url = self::removeQueryString($url);
        if(self::matchRoute($url)){
            $controller='app\controllers\\'.self::$route['controller'].'Controller';
            if(class_exists($controller)){
                $contObj=new $controller(self::$route);
                $action=self::lowerCamelCase(self::$route['action']).'Action';
                if(method_exists($contObj, $action)){
                    $contObj->$action();
                    //викликаємо getView()з базового Controller-a
                    //запускає render() з базового View.php,який підключає шаблон і вид
                    $contObj->getView();
                } else {
                    //echo "Метод <b>$controller::$action</b> не знайдено";
                    throw new \Exception("Метод <b>$controller::$action</b> не знайдено",404);
                }
            } else {
                //echo "Контролер <b>$controller</b> не існує";
                throw new \Exception("Контролер <b>$controller</b> не існує",404);
            }
        } else {
            //http_response_code(404);
            //include '404.html';//підключаємо шаблон для помилки
            throw new \Exception("Сторінку не знайдено",404);
        }
    }
    
    /**
     * перетворюємо fe: "posts-new" на "PostsNew"
     * @param type $param
     */
    protected static function upperCamelCase($name){
        return str_replace(' ','',ucwords(str_replace('-',' ',$name)));
    }
    
    /**
     * перетворюємо fe: "test-page" на "testPage"
     * @param string $name
     * @return string
     */
    protected static function lowerCamelCase($name){
        return lcfirst(str_replace(' ','',ucwords(str_replace('-',' ',$name))));
    }
    /**
     * відсікаємо явний GETмасив в $url і аналізуємо запит
     * @param type $url
     * @return type
     */
    protected static function removeQueryString($url){
        if($url){
            $params = explode('&', $url, 2);
            if(false===strpos($params[0],'=')){
                return rtrim($params[0],'/');
            } else {
                return '';
            }
        }
    }
}

