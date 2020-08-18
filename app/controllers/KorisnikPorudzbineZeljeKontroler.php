<?php


namespace app\controllers;

use app\models\DB;
use app\models\Porudzbina;
use app\models\DetaljiPorudzbine;
use app\models\ListaZelja;


class KorisnikPorudzbineZeljeKontroler extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ucitajStranu(){

        if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->nazivUloga==='korisnik'){

            $id=$_SESSION['korisnik']->idKorisnik;
            $porudzbina=new Porudzbina($this->baza);

            try{
                $porudzbine=$porudzbina->getPorudzbineZaKorisnika($id);
                $this->data['porudzbine']=$porudzbine;
            }
            catch(\PDOException $e){
                upisGresaka($e->getMessage());
            }

            $this->ucitajKorisnickiMeni();
            $this->loadPage("korisnik/korisnik-porudzbine-zelje",$this->data);

        }
        else{
            $this->loadPage("greske/403");
        }
    }

    public function prikaziDetaljePorudzbine($request){

        $id=$request['id'];

        $detalji=new DetaljiPorudzbine($this->baza);

        try{
            $svidetalji=$detalji->getDetaljeZaPorudzbinu($id);
        }
        catch(\PDOException $e){
            upisGresaka($e->getMessage());
        }

        $this->json($svidetalji);
    }

    public function prikaziListuZelja(){

        if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->nazivUloga==='korisnik'){

            $id=$_SESSION['korisnik']->idKorisnik;
            $zelja=new ListaZelja($this->baza);

            try{
                $zelje=$zelja->getListuZaKorisnika($id);
                $this->json($zelje);
            }
            catch(\PDOException $e){
                upisGresaka($e->getMessage());
                $this->json(["greska"=>$e->getMessage()]);
            }

        }
        else{
            $this->json([],403);
        }

    }

    public function obrisiPorizvodIzListeZelja($request){

        if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->nazivUloga==='korisnik'){

            $id=$request['id'];

            $zelja=new ListaZelja($this->baza);

            try{
                $proslo=$zelja->obrisiProizvod($id);
                $this->json(["poruka"=>"Uspesno brisanje"],204);
            }
            catch(\PDOException $e){
                upisGresaka($e->getMessage());
                $this->json(["greska"=>$e->getMessage()]);
            }

        }
        else{
            $this->json([],403);
        }

    }

}