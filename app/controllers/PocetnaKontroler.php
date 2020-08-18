<?php


namespace app\controllers;

use app\models\DB;
use app\models\Slajder;
use app\models\DetaljiPorudzbine;
use app\models\Proizvod;
class PocetnaKontroler extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ucitajPocetnu(){

        $this->ucitajKorisnickiMeni();

        $slajder=new Slajder($this->baza);
        $detaljiPorudzbine=new DetaljiPorudzbine($this->baza);
        $proizvod=new Proizvod($this->baza);

        try{

            $slajderPodaci=$slajder->getAll();
            $this->data["slajder"]=$slajderPodaci;

            $idsProizvoda=$detaljiPorudzbine->getNajprodavanijeProizvode();

            $ids=[];

            foreach ($idsProizvoda as $i){
                $ids[]=$i->idProizvod;
            }

            $najprodavanijiProizvodi=$proizvod->getViseProizvoda($ids);
            $this->data['najprodavaniji']=$najprodavanijiProizvodi;

        }
        catch(\PDOException $e){
            upisGresaka($e->getMessage());
        }

        $this->loadPage("pocetna",$this->data);

    }
}