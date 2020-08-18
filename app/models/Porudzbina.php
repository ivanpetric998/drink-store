<?php


namespace app\models;

use app\models\DB;

class Porudzbina
{
    private $db;

    public function __construct(DB $db)
    {
        $this->db=$db;
    }

    public function insert(int $id){
        return $this->db->executeNonGetWithLastInsertId("INSERT INTO porudzbina(idPorudzbina, idKorisnik, datum) VALUES (NULL,?,CURRENT_TIMESTAMP)",[$id]);
    }

    public function getPorudzbineZaKorisnika(int $id){
        return $this->db->executeGetWithParams("SELECT * FROM porudzbina WHERE idKorisnik=? ORDER BY datum DESC",[$id]);
    }

    public function getAllWithUsers(){
        return $this->db->executeGet("SELECT p.*,k.ime,k.prezime FROM porudzbina p JOIN korisnik k ON p.idKorisnik=k.idKorisnik ORDER BY p.datum DESC");
    }
}