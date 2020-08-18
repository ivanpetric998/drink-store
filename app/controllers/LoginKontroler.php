<?php


namespace app\controllers;

use app\models\DB;
use app\models\Korisnik;
class LoginKontroler extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function login($request){

        if(isset($_POST['logDugme'])){

            $email= $_POST['emailLog'];
            $lozinka= $_POST['lozLog'];

            $reLozinka="/^\S{6,30}$/";
            $greske=[];

            if(!preg_match($reLozinka,$lozinka)){
                $greske[]="Lozinka nije u dobrom formatu";
            }
            if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
                $greske[]="Email nije u dobrom formatu";
            }

            if(count($greske)){
                $_SESSION['greske']=$greske;
                $this->redirect("index.php");
            }
            else{
                $korisnik=new Korisnik($this->baza);

                try{
                    $kor=$korisnik->getKorisnika($email,$lozinka);
                }
                catch(\PDOException $e){
                    upisGresaka($e->getMessage());
                }

                if($kor){

                    $_SESSION['korisnik']=$kor;

                    if($kor->nazivUloga==="admin"){
                        $this->redirect("index.php?admin=pocetna");
                    }
                    else{
                        $this->redirect("index.php?page=profil");
                    }

                }
                else{
                    $_SESSION['greske']=["Greška! Pogrešan email ili lozinka"];
                    $this->redirect("index.php");
                }
            }

        }
        else{
            $this->redirect("index.php");
        }
    }

    public function logout(){
        unset($_SESSION['korisnik']);
        $this->redirect("index.php");
    }

}