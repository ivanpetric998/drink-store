<?php


namespace app\controllers;

use app\models\DB;
use app\models\Uloga;
use app\models\Korisnik;
class KontrolerAdminPocetna extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ucitajStranu(){

        if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->nazivUloga==="admin"){

            $this->getAdminMeni();
            $this->loadPage("admin/admin-pocetna",$this->data);
        }
        else{
            $this->loadPage("greske/403");
        }

    }

    public function getStraniceStatistika(){
        $stranice=pristupStranicamaProcenat();
        $dataPoints = array(
            array("label"=> "Početna", "y"=> $stranice['pocetna']),
            array("label"=> "Autor", "y"=> $stranice['autor']),
            array("label"=> "Proizvodi", "y"=> $stranice['proizvodi']),
            array("label"=> "Proizvod", "y"=> $stranice['proizvod']),
            array("label"=> "Kontakt", "y"=> $stranice['kontakt']),
            array("label"=> "Registracija", "y"=> $stranice['registracija']),
            array("label"=> "Korpa", "y"=> $stranice['korpa']),
            array("label"=> "Pretraga", "y"=> $stranice['pretraga']),
            array("label"=> "Najnovije", "y"=> $stranice['najnovije']),
            array("label"=> "Preporučeno", "y"=> $stranice['preporuceno']),
            array("label"=> "Akcija", "y"=> $stranice['akcija']),
            array("label"=> "Profil", "y"=> $stranice['profil']),
            array("label"=> "Želje", "y"=> $stranice['zelje'])
        );
        $this->json($dataPoints);
    }

}