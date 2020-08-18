<?php


namespace app\models;

use app\models\DB;

class Korisnik
{
    private $db;

    public function __construct(\app\models\DB $db)
    {
        $this->db=$db;
    }

    public function unosKorisnika(string $ime, string $prezime, string $grad, string $adresa, string $email, string $lozinka,
                                  int $idUloga){

        return $this->db->executeNonGet("INSERT INTO `korisnik`(`idKorisnik`, `ime`, `prezime`, `grad`, `adresa`, `email`, `lozinka`, 
                                `idUloga`, `aktivan`, `datum`) VALUES (NULL,?,?,?,?,?,?,?,1,CURRENT_TIMESTAMP)",
                                [$ime,$prezime,$grad,$adresa,$email,md5($lozinka),$idUloga]);
    }

    public function getKorisnika(string $email, string $lozinka){
        return $this->db->executeGetOneRowWithParams("SELECT k.idKorisnik,k.ime,k.prezime,k.email,k.idUloga,u.nazivUloga,
        k.aktivan FROM korisnik k JOIN uloga u ON k.idUloga=u.idUloga WHERE k.email=? AND k.lozinka=MD5(?)",[$email,$lozinka]);
    }

    public function getJednogKorisnika(int $id){
        return $this->db->executeGetOneRowWithParams("SELECT k.idKorisnik,k.ime,k.prezime,k.email,k.idUloga,u.nazivUloga,
            k.grad,k.adresa,k.aktivan FROM korisnik k JOIN uloga u ON k.idUloga=u.idUloga WHERE k.idKorisnik=?",[$id]);
    }

    public function azurirajKorisnika($id,$ime,$prezime,$grad,$adresa,$email,$lozinka,$uloga=null){
        $parametri=[$ime,$prezime,$grad,$adresa,$email];
        $upit="UPDATE korisnik SET ime=?,prezime=?,grad=?,adresa=?,email=?";

        if($lozinka!=null){
            $upit.=",lozinka=?";
            $parametri[]=md5($lozinka);
        }

        if($uloga!=null){
            $upit.=",idUloga=?";
            $parametri[]=$uloga;
        }

        $upit.=" WHERE idKorisnik=?";
        $parametri[]=$id;

        return $this->db->executeNonGet($upit,$parametri);
    }

    public function getBrojKorisnika(){
        return $this->db->executeGetOneRowWithoutParams("SELECT COUNT(*) as broj FROM korisnik");
    }

    public function getKorisnikePaginacija(int $broj){
        return $this->db->executeGet("SELECT * FROM korisnik ORDER BY datum DESC LIMIT 10 OFFSET {$broj}");
    }

    public function obrisKorisnika(int $id){
        return $this->db->executeNonGet("DELETE FROM korisnik WHERE idKorisnik=?",[$id]);
    }

}