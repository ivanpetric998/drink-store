<?php


namespace app\models;
use app\models\DB;
use app\models\Kategorija;
class Proizvod
{
    private $db;

    public function __construct(DB $db)
    {
        $this->db=$db;
    }

    public function getAll(){
        return $this->db->executeGet("SELECT * FROM proizvod p JOIN kategorija k ON p.idKategorija=k.idKategorija 
                                        JOIN marka m ON p.idMarka=m.idMarka ORDER BY p.datum DESC");
    }

    public function getProizvodeZaKorpu(Array $ids){

        $parametri=[];

        foreach ($ids as $i){
            $parametri[]="?";
        }

        $spojeniParametri=implode(",",$parametri);

        return $this->db->executeGetWithParams("SELECT * FROM `proizvod` WHERE idProizvod IN ({$spojeniParametri})",$ids);

    }

    public function getProizvodePaginacijaAdmin(int $broj){

        return $this->db->executeGet("SELECT * FROM proizvod p JOIN kategorija k ON p.idKategorija=k.idKategorija 
                                        JOIN marka m ON p.idMarka=m.idMarka ORDER BY p.datum DESC LIMIT 4 OFFSET {$broj}");

    }

    public function getBrojProizvodaZaPaginaciju($naziv,$cena,$marka,$cenaOd,$cenaDo,$kategorija){

        $upit="SELECT COUNT(*) AS broj ";

        $rezultat=$this->izvrsiProveruINadogradnjuUpitaZaPaginaciju($naziv,$cena,$marka,$cenaOd,$cenaDo,$kategorija,$upit);

        return $this->db->executeGetOneRowWithParams($rezultat[0],$rezultat[1]);

    }

    public function getProizvodePaginacija($naziv,$cena,$marka,$cenaOd,$cenaDo,$kategorija,$broj){

        $upit="SELECT * ";

        $rezultat=$this->izvrsiProveruINadogradnjuUpitaZaPaginaciju($naziv,$cena,$marka,$cenaOd,$cenaDo,$kategorija,$upit);

        $rezultat[0].=" LIMIT 6 OFFSET {$broj}";

        return $this->db->executeGetWithParams($rezultat[0],$rezultat[1]);
    }

    private function izvrsiProveruINadogradnjuUpitaZaPaginaciju($naziv,$cena,$marka,$cenaOd,$cenaDo,$kategorija,$upit){
        $parametri=[];

        $upit.="FROM proizvod p JOIN marka m ON p.idMarka=m.idMarka JOIN kategorija k 
                ON p.idKategorija=k.idKategorija WHERE k.idKategorija=? ";

        $parametri[]=$kategorija;

        if($marka!="0" && $cenaOd!=null && $cenaDo!=null){
            $upit.="AND m.idMarka=? AND p.cena BETWEEN ? AND ? ";
            $parametri[]=$marka;
            $parametri[]=$cenaOd;
            $parametri[]=$cenaDo;
        }

        if($marka!="0" && $cenaOd==null && $cenaDo==null){
            $upit.="AND m.idMarka=? ";
            $parametri[]=$marka;
        }

        if($marka=="0" && $cenaOd!=null && $cenaDo!=null){
            $upit.="AND p.cena BETWEEN ? AND ? ";
            $parametri[]=$cenaOd;
            $parametri[]=$cenaDo;
        }

        if($naziv!="0" || $cena!="0"){
            $upit.="ORDER BY ";
        }

        $privremeno=[];

        if($cena=="1"){
            $privremeno[]="p.cena DESC";
        }
        elseif($cena=="2"){
            $privremeno[]="p.cena";
        }

        if($naziv=="1"){
            $privremeno[]="p.proizvodNaziv DESC";
        }
        elseif($naziv=="2"){
            $privremeno[]="p.proizvodNaziv";
        }

        if($naziv!="0" && $cena!="0"){
            $upit.=implode(",",$privremeno);
        }
        elseif($naziv!="0" || $cena!="0"){
            $upit.=$privremeno[0];
        }

        return [$upit,$parametri];
    }

    public function dohvatiUkupanBrojProizvoda(){
        return $this->db->executeGetOneRowWithoutParams("SELECT COUNT(*) as broj FROM proizvod");
    }

    public function getProizvodeZaKategoriju(int $id){

        $upit="SELECT * FROM proizvod WHERE IdKategorija=?";
        return $this->db->executeGetWithParams($upit,[$id]);

    }

    public function getProizvod(int $id){
        return $this->db->executeGetOneRowWithParams("SELECT * FROM proizvod WHERE idProizvod=?",[$id]);
    }

    public function getProizvodeNaAkciji(){

        return $this->db->executeGet("SELECT * FROM proizvod WHERE akcija=1");

    }

    public function getPreporuceneProizvode(){

        return $this->db->executeGet("SELECT * FROM proizvod WHERE preporuceno=1");

    }

    public function getNajnovijeProizvode(){

        return $this->db->executeGet("SELECT * FROM proizvod ORDER BY datum DESC LIMIT 12");

    }

    public function izvrsiPretragu(string $string){
        $string="%{$string}%";
        return $this->db->executeGetWithParams("SELECT * FROM proizvod WHERE proizvodNaziv LIKE UPPER(?)",[$string]);
    }

    public function unos($naziv,$cena,$original,$stara,$opis,$preporuceno,$akcija,$popust,$idMarka,$idKategorija){
        $upit="INSERT INTO `proizvod`(`idProizvod`, `proizvodNaziv`, `cena`, `slikaOriginal`, `slikaNova`, `opis`, `datum`, 
`preporuceno`, `akcija`, `popust`, `idMarka`, `idKategorija`) VALUES (NULL,?,?,?,?,?,CURRENT_TIMESTAMP ,?,?,?,?,?)";
        return $this->db->executeNonGet($upit,[$naziv,$cena,$original,$stara,$opis,$preporuceno,$akcija,$popust,$idMarka,$idKategorija]);
    }

    public function obrisi(int $id){
        return $this->db->executeNonGet("DELETE FROM proizvod WHERE idProizvod=?",[$id]);
    }

    public function updateBezSlike($naziv,$cena,$opis,$preporuceno,$akcija,$popust,$idMarka,$idKategorija,$id){
        $upit="UPDATE `proizvod` SET `proizvodNaziv`=?,`cena`=?,`opis`=?,`preporuceno`=?,
`akcija`=?,`popust`=?,`idMarka`=?,`idKategorija`=? WHERE idProizvod=?";

        return $this->db->executeNonGet($upit,[$naziv,$cena,$opis,$preporuceno,$akcija,$popust,$idMarka,$idKategorija,$id]);
    }

    public function updateSaSlikom($naziv,$cena,$original,$stara,$opis,$preporuceno,$akcija,$popust,$idMarka,$idKategorija,$id){
        $upit="UPDATE `proizvod` SET `proizvodNaziv`=?,`cena`=?,`slikaOriginal`=?,`slikaNova`=?,`opis`=?,`preporuceno`=?,
`akcija`=?,`popust`=?,`idMarka`=?,`idKategorija`=? WHERE idProizvod=?";

        return $this->db->executeNonGet($upit,[$naziv,$cena,$original,$stara,$opis,$preporuceno,$akcija,$popust,$idMarka,$idKategorija,$id]);
    }

    public function getViseProizvoda(Array $ids){
        $parametri=[];
        foreach ($ids as $i){
            $parametri[]="?";
        }
        $spojeniParametri=implode(",",$parametri);

        return $this->db->executeGetWithParams("SELECT * FROM proizvod WHERE idProizvod IN ({$spojeniParametri})",$ids);
    }

}