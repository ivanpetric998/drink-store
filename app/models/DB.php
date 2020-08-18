<?php
namespace app\models;

class DB
{
    private $pdo;

    public function __construct($server, $db, $user, $password) {

        try {
            $this->pdo = new \PDO("mysql:host=" . $server . ";dbname=" . $db .  ";charset=utf8", $user, $password);

            $this->pdo->setAttribute(\PDO::ATTR_DEFAULT_FETCH_MODE, \PDO::FETCH_OBJ);
            $this->pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
        }
        catch(PDOException $ex){
            echo $ex->getMessage();
        }
    }

    public function executeGet(string $query) {
        return $this->pdo->query($query)->fetchAll();
    }

    public function executeGetWithParams(string $query, Array $params) {

        $prepare = $this->pdo->prepare($query);
        $prepare->execute($params);
        return $prepare->fetchAll();
    }

    public function executeGetOneRowWithoutParams(string $query) {
        return $this->pdo->query($query)->fetch();
    }

    public function executeGetOneRowWithParams(string $query, Array $params){
        $prepare = $this->pdo->prepare($query);
        $prepare->execute($params);
        return $prepare->fetch();
    }

    public function executeNonGet(string $query, Array $params) {
        $prepared = $this->pdo->prepare($query);
        return $prepared->execute($params);
    }

    public function executeNonGetWithLastInsertId(string $query, Array $params){
        $prepared = $this->pdo->prepare($query);
        $prepared->execute($params);
        return $this->pdo->lastInsertId();
    }

    public function startTransaction(){
        $this->pdo->beginTransaction();
    }

    public function executeTransaction(){
        $this->pdo->commit();
    }

    public function rollBackTransaction(){
        $this->pdo->rollBack();
    }

}