<?php


namespace app\controllers;

use app\models\DB;
use app\models\Korisnik;

class ProfilKontroler extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ucitajStranu(){

        if(isset($_SESSION['korisnik'])){

            $this->ucitajKorisnickiMeni();

            $id=$_SESSION['korisnik']->idKorisnik;

            $korisnik=new Korisnik($this->baza);

            try{
                $korisnickiPodaci=$korisnik->getJednogKorisnika($id);
                $this->data['korisnickiPodaci']=$korisnickiPodaci;
            }
            catch(\PDOException $e){
                upisGresaka($e->getMessage());
            }

            $this->loadPage("profil",$this->data);

        }
        else{
            $this->loadPage("greske/403");
        }
    }

}