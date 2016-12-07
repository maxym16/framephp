<?php

namespace vendor\core\base;
use vendor\core\Db;

/**
 * Description of Model
 *
 * @author Maxym
 */
abstract class Model {
    protected $pdo;//об'єкт,вказівник на відкрите підключення до БД
    protected $table;//ім'я таблиці з якою працює конкретна модель
    
    public function __construct() {
        $this->pdo = Db::instance();//повертаємо підключення до БД
    }
    
    /**
     * для відповідей типа true/false(fe: create,delete)
     * без обміна даними з БД
     */
    public function query($sql){
        return $this->pdo->execute($sql);
    }
    
    /**
     * повертає всі дані з таблиці БД
     */
    public function findAll(){
        $sql = "SELECT * FROM {$this->table}";
        return $this->pdo->query($sql);
    }
}
