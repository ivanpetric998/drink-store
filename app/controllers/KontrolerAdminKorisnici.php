<?php


namespace app\controllers;


use app\models\Korisnik;
use app\models\Uloga;

class KontrolerAdminKorisnici extends Controller
{

    public function ucitajStranuZaKorisnike(){

        if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->nazivUloga==="admin"){

            $this->getAdminMeni();

            $uloga=new Uloga($this->baza);

            try{
                $uloge=$uloga->getAll();
                $this->data['uloge']=$uloge;
            }
            catch(\PDOException $e){
                upisGresaka($e->getMessage());
            }

            $this->loadPage("admin/admin-korisnici",$this->data);
        }
        else{
            $this->loadPage("greske/403");
        }

    }

    public function getBrojKorisnika(){

        $korisnik = new Korisnik($this->baza);

        try{
            $broj=$korisnik->getBrojKorisnika();
            $this->json($broj);
        }
        catch(\PDOException $e){
            upisGresaka($e->getMessage());
            $this->json(["greska"=>$e->getMessage()],500);
        }

    }

    public function getKorisnikePaginacija($request){

        if(isset($request['id'])){
            $id=$request['id'];

            $broj=($id-1)*10;

            $korisnik = new Korisnik($this->baza);

            try{
                $korisnici=$korisnik->getKorisnikePaginacija($broj);
                $this->json($korisnici);
            }
            catch(\PDOException $e){
                upisGresaka($e->getMessage());
                $this->json(["greska"=>$e->getMessage()],500);
            }
        }
        else{
            $this->json(["greska"=>"Bad request"],400);
        }

    }

    public function getJednogKorisnika($request){

        if(isset($request['id'])){
            $id=$request['id'];

            $korisnik = new Korisnik($this->baza);

            try{
                $jedanKorisnik=$korisnik->getJednogKorisnika($id);
                $this->json($jedanKorisnik);
            }
            catch(\PDOException $e){
                upisGresaka($e->getMessage());
                $this->json(["greska"=>$e->getMessage()],500);
            }

        }
        else{
            $this->json(["greska"=>"Bad request"],400);
        }

    }

    public function obrisiKorisnika($request){

        if(isset($request['id'])){
            $id=$request['id'];

            $korisnik = new Korisnik($this->baza);

            try{
                $rezultat=$korisnik->obrisKorisnika($id);
                $this->json(["poruka"=>"Uspesno brisanje"],204);
            }
            catch (\PDOException $e){
                $this->json(["greska"=>"Ne mozete izbrisati korisnika, jer je obavljao kupovine"],409);
            }

        }
        else{
            $this->json(["greska"=>"Bad request"],400);
        }

    }

    public function azurirajKorisnika($request){

        if(isset($request['send'])){

            $ime=$request['ime'];
            $prezime=$request['prezime'];
            $grad=$request['grad'];
            $adresa=$request['adresa'];
            $email=$request['email'];
            $lozinka=$request['lozinka'];
            $uloga=isset($request['uloga'])?$request['uloga']:null;
            $id=$request['id'];

            if($lozinka=="")
                $lozinka=null;

            $greske=$this->proveraZaUnosKOrisnika($ime,$prezime,$grad,$adresa,$email,$lozinka,$uloga);

            if(count($greske)){
                $this->json($greske,422);
            }
            else{

                $korisnik=new Korisnik($this->baza);

                try{
                    $rezultat=$korisnik->azurirajKorisnika($id,$ime,$prezime,$grad,$adresa,$email,$lozinka,$uloga);
                    $this->json(["poruka"=>"UspesnoAzuriranje"],204);
                }
                catch(\PDOException $e){
                    upisGresaka($e->getMessage());
                    $this->json([$e->getMessage()],500);
                }

            }

        }
        else{
            $this->json([],400);
        }

    }

    public function unosKorisnika($request){

        if(isset($request['send'])){

            $ime=$request['ime'];
            $prezime=$request['prezime'];
            $grad=$request['grad'];
            $adresa=$request['adresa'];
            $email=$request['email'];
            $lozinka=$request['lozinka'];
            $idUloga=isset($request['uloga'])?$request['uloga']:null;

            $greske=$this->proveraZaUnosKorisnika($ime,$prezime,$grad,$adresa,$email,$lozinka,$idUloga);

            if(count($greske)){
                $this->json($greske,422);
            }
            else{

                try{

                    if($idUloga==null){
                        $uloga=new Uloga($this->baza);
                        $korisnik=$uloga->getKorisnika();
                        $idUloga=$korisnik->idUloga;
                    }

                    $korisnik=new Korisnik($this->baza);
                    $korisnik->unosKorisnika($ime,$prezime,$grad,$adresa,$email,$lozinka,$idUloga);
                    $this->json(["poruka"=>"Uspesan unos"],201);

                }
                catch(\PDOException $e){
                    upisGresaka($e->getMessage());
                    $this->json(["greska"=>"Vec postoji korisnik sa upisanom email adresom"],409);
                }
            }

        }
        else{
            $this->json([],400);
        }


    }

    private function proveraZaUnosKorisnika($ime,$prezime,$grad,$adresa,$email,$lozinka,$uloga=null){

        $reImePrezime="/^[A-Z][a-z]{2,14}(\s[A-Z][a-z]{2,14})*$/";
        $reGrad="/^[A-Z][a-z]{1,14}(\s[A-Z][a-z]{1,14})*$/";
        $reAdresa="/^[A-Z][a-z]{2,14}(\s([A-z]{3,14}|\d{1,}))*$/";
        $reLozinka="/^\S{6,30}$/";

        $greske=[];

        if(!preg_match($reImePrezime,$ime)){
            $greske[]="Ime nije u dobrom formatu";
        }
        if(!preg_match($reImePrezime,$prezime)){
            $greske[]="Prezime nije u dobrom formatu";
        }
        if(!preg_match($reGrad,$grad)){
            $greske[]="Grad nije u dobrom formatu";
        }
        if(!preg_match($reAdresa,$adresa)){
            $greske[]="Adresa nije u dobrom formatu";
        }
        if(!preg_match($reLozinka,$lozinka) && $lozinka!=null){
            $greske[]="Lozinka nije u dobrom formatu";
        }
        if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $greske[]="Email nije u dobrom formatu";
        }
        if($uloga!=null && $uloga=="0"){
            $greske[]="Morate izabrati ulogu";
        }

        return $greske;

    }

}