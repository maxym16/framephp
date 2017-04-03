<?php
/*
 * Trait PHP
 */

namespace vendor\core;

/**
 * TSingletone
 * @author Maxym
 */
trait TSingletone {
    protected static $instance;
    
    public static function instance(){
        //сінглтон,якщо підключення до БД нема,то створимо його
        if(self::$instance===null){
            self::$instance=new self;
        }
        return self::$instance;
    }
    
}
