<?php


namespace app\controllers;

use app\models\DB;
use app\models\Proizvod;
class PretragaKontroler extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ucitajStranuZaPretraguProizvoda($requst){

        if(isset($requst['pretragaButton'])){

            $tekst=strtoupper($requst['textPretraga']);

            $proizvod=new Proizvod($this->baza);

            try{
                $proizvodi=$proizvod->izvrsiPretragu($tekst);
                $this->data['proizvodiZaPrikaz']=$proizvodi;
            }
            catch(\PDOException $e){
                upisGresaka($e->getMessage());
            }

            $this->ucitajKorisnickiMeni();
            $this->loadPage("proizvodi-dodatno",$this->data);
        }
        else{
            $this->loadPage("greske/400");
        }

    }
}