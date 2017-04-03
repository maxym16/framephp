<?php

namespace vendor\core;
use R;//RedBeanPHP для роботи з БД

    //PHP Data Objects . Цей клас, скорочено іменований PDO
    //# MySQL через PDO_MYSQL  
    //$DBH = new PDO("mysql:host=$host;dbname=$dbname", $user, $pass);
    //# STH означає "Statement Handle"  
    //$STH = $DBH->prepare("INSERT INTO folks ( first_name ) values ( 'Cathy' )");  
    //# іменні placeholders 
    //$STH = $DBH->prepare("INSERT INTO folks (name, addr, city) values (:name, :addr, :city)");
    //$STH->execute();
    //# можна одразу використати метод query()  
    /*
    $STH = $DBH->query('SELECT name, addr, city from folks');  
    # встановлюємо режим вибірки
    $STH->setFetchMode(PDO::FETCH_ASSOC);  
    while($row = $STH->fetch()) {  
        echo $row['name'] . "\n";  
        echo $row['addr'] . "\n";  
        echo $row['city'] . "\n";  
    }
    */  

/**
 * Підключення до БД
 * Singlton, створює лише один об'єкт
 * @author Maxym
 */
class Db {
    use TSingletone;
    
    protected $pdo;//об'єкт,вказівник на відкрите підключення до БД
//    protected static $instance;
    public static $countSql=0;//підрахунок кількості запитів
    public static $queries=[];//зберігаємо всі наші запити

    /**
     * Підключаємось до БД(тільки 1 раз) і записуємо в $pdo
     */
    protected function __construct(){
        $db=require ROOT.'/config/db.php';//де лежать дані про БД,що підключаємо
        require LIBS.'/rb.php';//RedBeanPHP для роботи з БД
        R::setup($db['dsn'],$db['user'],$db['pass']);
//        R::fancyDebug(true);//показувати запити на екран
        R::freeze( TRUE );//заморозити структуру таблиць
/*        $options = [//константи
            \PDO::ATTR_ERRMODE => \PDO::ERRMODE_EXCEPTION,//відстежуємо помилки
            \PDO::ATTR_DEFAULT_FETCH_MODE => \PDO::FETCH_ASSOC,//дані даються у вигляді асоціативного масиву
        ];
        $this->pdo = new \PDO($db['dsn'],$db['user'],$db['pass'],$options);
*/        
    }
    
/*    public static function instance(){
        //якщо підключення до БД нема,то створимо його
        if(self::$instance===null){
            self::$instance=new self;
        }
        return self::$instance;
    }
*/    
    /**
     * підготовлюємо sql-запит
     * PDO::prepare-Готує запит до виконання і повертає асоційований з цим запитом об'єкт
     * параметри prepare -> statement,driver_options
     * для відповідей типа true/false(fe: create,delete)
     * без обміна даними з БД
     * $params - необов'язковий параметр з Model.php
     */
/*    public function execute($sql,$params=[]){
        self::$countSql++;//підрахунок кількості запитів
        self::$queries=$sql;//записуємо sql-запит
        $stmt=$this->pdo->prepare($sql);
        return $stmt->execute($params);
    }
*/    
    /**
     * підготовлюємо sql-запит
     * для обміна даними з БД(fe: select)
     * $params - необов'язковий параметр з Model.php
     */
/*    public function query($sql, $params=[]){
        self::$countSql++;//підрахунок кількості запитів
        self::$queries=$sql;//записуємо sql-запит
        $stmt = $this->pdo->prepare($sql);
        $res = $stmt->execute($params);
        if($res!==false){
            return $stmt->fetchAll();
            //return $stmt->fetchAll(\PDO::FETCH_ASSOC);//дані даються у вигляді асоціативного масиву
        }
        return [];
    }
*/    
}
