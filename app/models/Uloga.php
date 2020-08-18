<?php


namespace app\models;

use app\models\DB;
class Uloga
{
    private $db;

    public function __construct(DB $db)
    {
        $this->db=$db;
    }

    public function getAdmina(){
        return $this->db->executeGetOneRowWithoutParams("SELECT * FROM uloga WHERE nazivUloga='admin'");
    }

    public function getKorisnika(){
        return $this->db->executeGetOneRowWithoutParams("SELECT * FROM uloga WHERE nazivUloga='korisnik'");
    }

    public function getAll(){
        return $this->db->executeGet("SELECT * FROM uloga");
    }
}