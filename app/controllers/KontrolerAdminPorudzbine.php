<?php


namespace app\controllers;


use app\models\Porudzbina;

class KontrolerAdminPorudzbine extends Controller
{
    public function ucitajStranuZaPorudzbine(){

        if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->nazivUloga==="admin"){

            $porudzbina=new Porudzbina($this->baza);

            try {
                $porudzbine=$porudzbina->getAllWithUsers();
                $this->data['porudzbine']=$porudzbine;

            }
            catch(\PDOException $e){
                upisGresaka($e->getMessage());
            }

            $this->getAdminMeni();

            $this->loadPage("admin/admin-porudzbine",$this->data);

        }else{
            $this->loadPage("greske/403");
        }

    }
}