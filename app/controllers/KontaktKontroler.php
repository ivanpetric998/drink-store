<?php


namespace app\controllers;

use app\models\DB;
class KontaktKontroler extends Controller
{

    public function __construct()
    {
        parent::__construct();
    }

    public function ucitajKontaktStranu(){

        $this->ucitajKorisnickiMeni();
        $this->loadPage("kontakt",$this->data);

    }

    public function posaljiMail($request){

        if(isset($request['send'])){

            $mail=$request['mail'];
            $svrha=$request['svrha'];
            $tekst=$request['tekst'];

            $ceotekst="Pošiljalac: {$mail}</br>{$tekst}";

            mail('ivan.petric@gmail.com', $svrha, $ceotekst);

            $this->json(["poruka"=>"Uspešno ste poslali poruku"]);

        }
        else{
            $this->json(["greska"=>"request"],400);
        }

    }

}