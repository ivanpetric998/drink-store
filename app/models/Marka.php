<?php


namespace app\models;

use app\models\DB;

class Marka
{
    private $db;

    public function __construct(DB $db)
    {
        $this->db=$db;
    }

    public function getMarkeZaKategoriju(int $id){

        $upit="SELECT m.idMarka,m.nazivMarka FROM marka m JOIN proizvod p ON m.idMarka=p.idMarka JOIN kategorija k 
                ON p.idKategorija=k.idKategorija WHERE k.idKategorija=? GROUP BY m.idMarka,m.nazivMarka";
        return $this->db->executeGetWithParams($upit,[$id]);

    }

    public function getAll(){
        return $this->db->executeGet("SELECT * FROM marka ORDER BY nazivMarka");
    }

}