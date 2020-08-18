<?php


namespace app\models;

use app\models\DB;

class Meni
{
    private $db;

    public function __construct(DB $db)
    {
        $this->db=$db;
    }

    public function getMeniDodatno(){
        return $this->db->executeGet("SELECT m.* FROM meni m JOIN tip t ON m.idTip=t.idTip WHERE t.nazivTip='dodatno' ORDER BY pozicija");
    }

    public function getmeniAdmin(){
        return $this->db->executeGet("SELECT m.* FROM meni m JOIN tip t ON m.idTip=t.idTip WHERE t.nazivTip='admin' ORDER BY pozicija");
    }
}