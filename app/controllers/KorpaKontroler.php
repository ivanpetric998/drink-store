<?php


namespace app\controllers;

use app\models\DB;
use app\models\Proizvod;
use app\models\Porudzbina;
use app\models\DetaljiPorudzbine;
class KorpaKontroler extends  Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ucitajStranu(){

        $this->ucitajKorisnickiMeni();

        $this->loadPage("korpa",$this->data);
    }

    public function dohvatiProizvode(){

        $proizvod=new Proizvod($this->baza);

        try{
            $proizvodi=$proizvod->getAll();
            $this->json($proizvodi);
        }
        catch(\PDOException $e){
            upisGresaka($e->getMessage());
            $this->json(["greska"=>$e->getMessage()]);
        }

    }

    public function izvrsiPorudzbinu($request){

        if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->nazivUloga==='korisnik'){

            $idKorisnik=$_SESSION['korisnik']->idKorisnik;
            $obj=$request['obj'];

            $porudzbina=new Porudzbina($this->baza);
            $detaljiPorudzbine=new DetaljiPorudzbine($this->baza);

            try{

                $this->baza->startTransaction();

                $idPorudzbine=$porudzbina->insert($idKorisnik);

                $izvrsi=$detaljiPorudzbine->insertMoreRows($obj,$idPorudzbine);

                $this->baza->executeTransaction();

                $this->json(["poruka"=>"Uspešno ste izvršili porudžbinu"],201);

            }
            catch(\PDOException $e){
                $this->baza->rollBackTransaction();
                $this->json(["greska"=>$e->getMessage()],500);
            }

        }
        else{
            $this->json(["greska"=>"Morate da se registrujete da biste izvršili porudžbinu"],403);
        }
    }

}