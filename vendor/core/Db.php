<?php

namespace vendor\core;

/**
 * Підключення до БД
 * Singlton, створює лише один об'єкт
 * @author Maxym
 */
class Db {
    protected $pdo;//об'єкт,вказівник на відкрите підключення до БД
    protected static $instance;
    public static $countSql=0;//підрахунок кількості запитів
    public static $queries=[];//зберігаємо всі наші запити


    protected function __construct(){
        $db=require ROOT.'/config/db.php';//де лежать дані про БД,що підключаємо
        $options = [//константи
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,//відстежуємо помилки
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,//дані даються у вигляді асоціативного масиву
        ];
        $this->pdo = new \PDO($db['dsn'],$db['user'],$db['pass'],$options);
    }
    
    public static function instance(){
        //якщо підключення до БД нема,то створимо його
        if(self::$instance===null){
            self::$instance=new self;
        }
        return self::$instance;
    }
    
    /**
     * підготовлюємо sql-запит
     * для відповідей типа true/false(fe: create,delete)
     * без обміна даними з БД
     */
    public function execute($sql){
        self::$countSql++;//підрахунок кількості запитів
        self::$queries=$sql;//записуємо sql-запит
        $stmt=  $this->pdo->prepare($sql);
        return $stmt->execute();
    }
    
    /**
     * підготовлюємо sql-запит
     * для обміна даними з БД(fe: select)
     */
    public function query($sql){
        self::$countSql++;//підрахунок кількості запитів
        self::$queries=$sql;//записуємо sql-запит
        $stmt =  $this->pdo->prepare($sql);
        $res = $stmt->execute();
        if($res!==false){
            return $stmt->fetchAll();
            //return $stmt->fetchAll(\PDO::FETCH_ASSOC);//дані даються у вигляді асоціативного масиву
        }
        return [];
    }
}
