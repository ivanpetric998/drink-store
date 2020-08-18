<?php


namespace app\models;

use app\models\DB;

class Slajder
{
    private $db;

    public function __construct(DB $db)
    {
        $this->db=$db;
    }

    public function getAll(){
        return $this->db->executeGet("SELECT * FROM slajder");
    }
}