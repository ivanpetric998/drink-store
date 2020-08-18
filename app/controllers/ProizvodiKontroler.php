<?php


namespace app\controllers;

use app\models\DB;
use app\models\Marka;
use app\models\Proizvod;
use app\models\ListaZelja;

class ProizvodiKontroler extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ucitajStranuProizvodi($request){

        $this->ucitajKorisnickiMeni();

        if(isset($request['i']) && $request['i']!="")
        {
            $marka=new Marka($this->baza);

            try{
                $marke=$marka->getMarkeZaKategoriju($request['i']);
                $this->data['marke']=$marke;
            }
            catch(\PDOException $e){
                upisGresaka($e->getMessage());
            }

            $this->loadPage("proizvodi",$this->data);

        }
        else
        {
            $this->loadPage("greske/bez-parametara",$this->data);
        }

    }

    public function dohvatiBrojProizvoda($request){

        $naziv=$request['naziv'];
        $cena=$request['cena'];
        $marka=$request['marka'];
        $cenaOd=$request['cenaOd'];
        $cenaDo=$request['cenaDo'];
        $kategorija=$request['kategorija'];

        if(!($cenaOd>1 && $cenaDo>1 && $cenaOd<$cenaDo)){
            $cenaOd=null;
            $cenaDo=null;
        }

        $proizvod=new Proizvod($this->baza);

        try{
            $broj=$proizvod->getBrojProizvodaZaPaginaciju($naziv,$cena,$marka,$cenaOd,$cenaDo,$kategorija);
            $this->json($broj);
        }
        catch(\PDOException $e){
            upisGresaka($e->getMessage());
            $this->json(["greska"=>$e->getMessage()],500);
        }

    }

    public function dohvatiProizvode($request){
        $naziv=$request['naziv'];
        $cena=$request['cena'];
        $marka=$request['marka'];
        $cenaOd=$request['cenaOd'];
        $cenaDo=$request['cenaDo'];
        $kategorija=$request['kategorija'];
        $id=$request['id'];

        if(!($cenaOd>1 && $cenaDo>1 && $cenaOd<$cenaDo)){
            $cenaOd=null;
            $cenaDo=null;
        }

        $broj=($id-1)*6;

        $proizvod=new Proizvod($this->baza);

        try{
            $proizvodi=$proizvod->getProizvodePaginacija($naziv,$cena,$marka,$cenaOd,$cenaDo,$kategorija,$broj);
            $this->json($proizvodi);
        }
        catch(\PDOException $e){
            upisGresaka($e->getMessage());
            $this->json(["greska"=>$e->getMessage()],500);
        }

    }

    public function dodajUListuZelja($request){

        if(isset($_SESSION['korisnik'])){

            $idKorisnik=$_SESSION['korisnik']->idKorisnik;
            $idProizvod=$request['idProizvod'];

            $zelja=new ListaZelja($this->baza);

            try{

                $daLiPostoji=$zelja->daLiPostojiZelja($idProizvod,$idKorisnik);

                if(!$daLiPostoji){

                    $rezultat=$zelja->insert($idProizvod,$idKorisnik);
                    $this->json(["poruka"=>"Uspešno ste uneli proizvod u listu želja"],201);

                }
                else{
                    $this->json(["greska"=>"Već ste uneli proizvod u listu želja!"],409);
                }
            }
            catch(\PDOException $e){
                upisGresaka($e->getMessage());
                $this->json(["greska"=>$e->getMessage()],500);
            }

        }
        else{
            $this->json(["greska"=>"Morate se prvo prijaviti da biste dodali proizvod u listu želja!"],403);
        }

    }

    public function ucitajStranuProizvod($request){

        $this->ucitajKorisnickiMeni();

        if(isset($request['i']) && $request['i']!="")
        {
            $proizvod = new Proizvod($this->baza);

            try{
                $jedanProizvod=$proizvod->getProizvod($request['i']);

                if($jedanProizvod){
                    $this->data['proizvod']=$jedanProizvod;
                    $this->loadPage("proizvod",$this->data);
                }
                else{
                    $this->loadPage("greske/nepostojeci-proizvod",$this->data);
                }

            }
            catch(\PDOException $e){
                upisGresaka($e->getMessage());
            }

        }
        else{
            $this->loadPage("greske/bez-parametara",$this->data);
        }
    }

}