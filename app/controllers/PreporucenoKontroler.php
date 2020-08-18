<?php


namespace app\controllers;

use app\models\DB;
use app\models\Proizvod;
class PreporucenoKontroler extends  Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ucitajStranuPreporuceno(){

        $this->ucitajKorisnickiMeni();

        $proizvod=new Proizvod($this->baza);

        try{
            $proizvodi=$proizvod->getPreporuceneProizvode();
            $this->data['proizvodiZaPrikaz']=$proizvodi;
        }
        catch(\PDOException $e){
            upisGresaka($e->getMessage());
        }

        $this->loadPage("proizvodi-dodatno",$this->data);
    }

}