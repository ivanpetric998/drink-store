<?php


namespace app\models;

use app\models\DB;

class Kategorija
{
    private $db;

    public function __construct(DB $db)
    {
        $this->db=$db;
    }

    public function getAll(){
        return $this->db->executeGet("SELECT * FROM kategorija ORDER BY nazivKategorija");
    }

    public function getJednuKategoriju(int $id){
        return $this->db->executeGetOneRowWithParams("SELECT * FROM `kategorija` WHERE idKategorija=?",[$id]);
    }

}