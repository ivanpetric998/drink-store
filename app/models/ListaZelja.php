<?php


namespace app\models;

use app\models\DB;

class ListaZelja
{
    private $db;

    public function __construct(DB $db)
    {
        $this->db=$db;
    }

    public function insert(int $zelja,int $korisnik){
        return $this->db->executeNonGet("INSERT INTO listazelja(idZelja, idKorisnik, idProizvod) VALUES (NULL,?,?)",[$korisnik,$zelja]);
    }

    public function daLiPostojiZelja(int $zelja, int $korisnik){
        return $this->db->executeGetOneRowWithParams("SELECT * FROM listazelja WHERE idKorisnik=? AND idProizvod=?",[$korisnik,$zelja]);
    }

    public function getListuZaKorisnika(int $id){
        return $this->db->executeGetWithParams("SELECT * FROM listazelja l JOIN proizvod p ON l.idProizvod=p.idProizvod WHERE l.idKorisnik=?",[$id]);
    }

    public function obrisiProizvod(int $id){
        return $this->db->executeNonGet("DELETE FROM `listazelja` WHERE idProizvod=?",[$id]);
    }
}