<?php


namespace app\controllers;

use app\models\DB;
use app\models\Korisnik;
use app\models\Uloga;
class RegistracijaKontroler extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ucitajStranuRegistracija(){

        $this->ucitajKorisnickiMeni();

        $this->loadPage("registracija",$this->data);
    }

}