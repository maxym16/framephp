<?php

namespace vendor\core\base;

/**
 * Description of View
 * Базовий клас View
 * @author Maxym
 */
class View {
    /**
     * поточний маршрут і параметри(controller,action,params)
     * @var array 
     */
    public $route=[];
    /**
     * поточний вид
     * @var string
     */
    public $view;
    /**
     * поточний шаблон
     * @var string
     */
    public $layout;
    
    /**
     * при створені об'єкта(Router.php->>$contObj=new $controller(self::$route))
     * в $route записується поточний маршрут
     * і визначаємо шаблон(layout) і вид(view)
     */
    public function __construct($route, $layout='', $view='') {
        $this-> route = $route;
        if($layout===false){
            $this->layout=false;
        } else {
            $this-> layout = $layout ?: LAYOUT;//if layout був переданий,то =йому,if ні=>LAYOUT 
        }
        $this-> view = $view;
    }
    /**
     * шлях до файлу виду(view)
     */
    public function render($varia){
        if(is_array($varia)) {extract($varia);}
        $file_view=APP."/views/{$this->route['controller']}/{$this->view}.php";
        ob_start();//кладемо виведення $file_view в буфер обміну
        if(is_file($file_view)){
            require $file_view;
        } else {
            echo "<p>Не знайдено вид <b>{$file_view}</b></p>";
        }
        //очищаємо буфер обміну і кладемо вид в $contents,щоби потім вставити в шаблоні
        $contents = ob_get_clean();
        if(false!==$this->layout){
            //підключаємо шаблон
            $file_layout=APP."/views/layouts/{$this->layout}.php";
            if(is_file($file_layout)){
                require $file_layout;
            } else {
                echo "<p>Не знайдено шаблон <b>{$file_layout}</b></p>";
            }
        }
    }

}
