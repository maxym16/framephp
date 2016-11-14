<?php

namespace vendor\core\base;

/**
 * Description of Base Controller
 * @author Maxym
 */
abstract class Controller {
    /**
     * поточний маршрут і параметри(controller,action,params)
     * @var array 
     */
    public $route=[];
    
    /**
     * вид
     * @var string
     */
    public $view;

    /**
     * поточний шаблон
     * @var string
     */
    public $layout;
    
    /**
     * змінна, дані користувача
     * @var array
     */
    public $varia=[];

    /**
     * при створені об'єкта(Router.php->>$contObj=new $controller(self::$route))
     * в $route записується поточний маршрут
     * @param type $route
     */
    public function __construct($route) {
        $this-> route = $route;
        $this-> view = $route['action'];
    }
    
    /**
     * створення об'єкту виду
     * виклик його методу render()
     */
    public function getView(){
        $vydObj=new View($this->route, $this->layout, $this->view);
        $vydObj->render($this->varia);//передамо змінні(масив)$varia прийнятий із Action-а контролера
    }
    
    /**
     * передача змінних з контролера в вид
     * @param array $varia
     */
    public function set($varia){
        $this->varia=$varia;
    }
}
