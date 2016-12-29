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
    protected $pk='id';//назва первинного ключа,для можливості розробнику перевизначити
    
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

    /**
     * отримати один запис
     * шукає id в полі field
     * а якщо field не задано шукає $field=$pk
     * $field=''-пошук по полю,необов'язковий критерій для запиту
     * підготуємо вирази placeholders(неіменований параметр) ? <- [$id] замість $id
     */
    public function findOne($id,$field=''){
        $field=$field ?: $this->pk ;
        $sql = "SELECT * FROM {$this->table} WHERE $field = ? LIMIT 1";
        return $this->pdo->query($sql,[$id]);
    }

    /**
     * звичайний SQL запит з параметрами
     */
    public function findBySql($sql, $params=[]){
        return $this->pdo->query($sql, $params);
    }
    
    /**
     * SQL запит,шукає в полі field в таблиці(по замовчанню береться з моделі)
     * запис подібний до $str 
     */
    public function findLike($str, $field, $table=''){
        $table=$table ?: $this->table;
        $sql="SELECT * FROM $table WHERE $field LIKE ?";
        return $this->pdo->query($sql, ['%' . $str . '%']);
    }
}
