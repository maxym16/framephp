<?php

namespace vendor\core;
use vendor\core\Registry;
use vendor\core\ErrorHandler;

/**
 * Description of App
 * @author Maxym
 */
class App {
    public static $app;
    
    public function __construct() {
        self::$app=Registry::instance() ;
        new ErrorHandler();
    }
}
