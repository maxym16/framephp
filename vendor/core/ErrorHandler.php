<?php

namespace vendor\core;

class ErrorHandler {
    
    public function __construct() {
        if(DEBUG){
            error_reporting(-1);//показувати всі помилки
        } else {
            error_reporting(0);//не показувати помилки
        }
        set_error_handler([$this,'errorHandler']);
        ob_start();
        register_shutdown_function([$this,'fatalErrorHandler']);
        set_exception_handler([$this,'exceptionHandler']);
    }
    
    public function errorHandler($errno, $errstr, $errfile, $errline){
        //var_dump($errno, $errstr, $errfile, $errline);
        $this->logErrors($errstr,$errfile,$errline);
//        error_log("[" . date('Y-m-d H:i:s') . "] Text error: {$errstr} | File: {$errfile} | String: {$errline} \n=========\n",3,__DIR__.'/errors.log');
        $this->displayError($errno, $errstr, $errfile, $errline);
        return true;
    }
    
    public function fatalErrorHandler(){
        $error = error_get_last();
        if( !empty($error) && $error['type'] & ( E_ERROR | E_PARSE | E_COMPILE_ERROR | E_CORE_ERROR)){
            $this->logErrors($error['message'],$error['file'],$error['line']);
//            error_log("[" . date('Y-m-d H:i:s') . "] Text error: {$error['message']} | File: {$error['file']} | String: {$error['line']} \n=========\n",3,__DIR__.'/errors.log');
            ob_end_clean();
            $this->displayError($error['type'], $error['message'], $error['file'], $error['line']);
        } else {
            ob_end_flush();
        }
        //var_dump($error);
    }

    public function exceptionHandler($e){
        $this->logErrors($e->getMessage(),$e->getFile(),$e->getLine());
//        error_log("[" . date('Y-m-d H:i:s') . "] Text error: {$e->getMessage()} | File: {$e->getFile()} | String: {$e->getLine()} \n=========\n",3,__DIR__.'/errors.log');
        $this->displayError('Вийняток',$e->getMessage(),$e->getFile(),$e->getLine(),$e->getCode());
        //var_dump($e);
    }

    protected function logErrors($message='',$file='',$line=''){
        error_log("[" . date('Y-m-d H:i:s') . "] Text error: {$message} | File: {$file} | String: {$line} \n=========\n",3,ROOT.'/tmp/errors.log');
    }

    protected function displayError($errno, $errstr, $errfile, $errline, $response=500){
        http_response_code($response);
        if($response==404 && !DEBUG){
            require WWW.'/errors/404.html';
            die;
        }
        if(DEBUG){
            require WWW.'/errors/dev.php';
        } else {
            require WWW.'/errors/prod.php';
        }
        die;
    }
}
