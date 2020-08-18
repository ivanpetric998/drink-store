<?php


namespace app\controllers;

use app\models\DB;
use app\models\Proizvod;
class AkcijaKontroler extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ucitajStranuNaAkciji(){

        $this->ucitajKorisnickiMeni();

        $proizvod=new Proizvod($this->baza);

        try{
            $proizvodi=$proizvod->getProizvodeNaAkciji();
            $this->data['proizvodiZaPrikaz']=$proizvodi;
        }
        catch(\PDOException $e){
            upisGresaka($e->getMessage());
        }

        $this->loadPage("proizvodi-dodatno",$this->data);
    }

}