<?php


namespace app\models;

use app\models\DB;
class DetaljiPorudzbine
{
    private $db;

    public function __construct(DB $db)
    {
        $this->db=$db;
    }

    public function insertOneRow(int $idPorudzbina, int $idProizvod, int $kolicina){
        return $this->db->executeNonGet("INSERT INTO detaljiporudzbine(idDP, idPorudzbina, idProizvod, kolicina) VALUES (NULL,?,?,?)",[$idPorudzbina,$idProizvod,$kolicina]);
    }

    public function insertMoreRows($obj,$idPorudzbina){

        $parametri=[];
        $vrednosti=[];

        foreach ($obj as $i){
            $parametri[]="(NULL,?,?,?)";
            $vrednosti[]=$idPorudzbina;
            $vrednosti[]=$i['id'];
            $vrednosti[]=$i['kolicina'];
        }

        $upit=implode(",",$parametri);

        return $this->db->executeNonGet("INSERT INTO detaljiporudzbine(idDP, idPorudzbina, idProizvod, kolicina) VALUES {$upit}",$vrednosti);

    }

    public function getDetaljeZaPorudzbinu(int $id){
        return $this->db->executeGetWithParams("SELECT * FROM detaljiporudzbine dp JOIN proizvod p ON dp.idProizvod=p.idProizvod WHERE dp.idPorudzbina=?",[$id]);
    }

    public function getNajprodavanijeProizvode(){
        return $this->db->executeGet("SELECT idProizvod FROM detaljiporudzbine GROUP BY idProizvod ORDER BY COUNT(*) DESC LIMIT 9");
    }
}