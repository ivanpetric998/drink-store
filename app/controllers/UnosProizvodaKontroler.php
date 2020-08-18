<?php


namespace app\controllers;

use app\models\DB;
use app\models\Marka;
use app\models\Kategorija;
use app\models\Proizvod;

class UnosProizvodaKontroler extends Controller
{
    public function __construct()
    {
        parent::__construct();
    }

    public function ucitajStranu(){

        if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->nazivUloga==="admin"){

            $marka=new Marka($this->baza);
            $kategorija=new Kategorija($this->baza);

            try{
                $sveMarke=$marka->getAll();
                $this->data['marke']=$sveMarke;

                $sveKategorije=$kategorija->getAll();
                $this->data['kategorije']=$sveKategorije;
            }
            catch(\PDOException $e){
                upisGresaka($e->getMessage());
            }

            $this->getAdminMeni();
            $this->loadPage("admin/unos-proizvoda",$this->data);

        }else{
            $this->loadPage("greske/403");
        }

    }

    public function insertUpdateProizvoda($files,$post){

        if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->nazivUloga==="admin") {

            if(isset($post['btnUnosProizvoda'])){

                if($post['skriveno']===""){
                    $this->unosProizvoda($files,$post);
                }
                else{
                    $this->azuriranjeProizvoda($files,$post);
                }

            }
            else{
                $this->redirect("index.php?page=400");
            }

        }
        else {
            $this->redirect("index.php?page=403");
        }

    }

    private function azuriranjeProizvoda($files,$post){

        if($files['slikaProizvoda']['name']===""){

            $id=$post['skriveno'];

            $greske=[];

            $naziv=$post['nazivProizvoda'];
            $cena=$post['cenaProizvoda'];
            $opis=$post['opisProizvoda'];
            $kategorija=$post['ddlKategorija'];
            $marka=$post['ddlMarka'];
            $preporuceno=isset($post['chbPreporuceno'])?$post['chbPreporuceno']:false;
            $akcija=isset($post['chbAkcija'])?$post['chbAkcija']:false;
            $popust=$post['popust'];

            if(!$akcija){
                $popust=null;
            }

            $greske=$this->proveriDaLiSuPodaciDobri($naziv,$cena,$opis,$kategorija,$marka,$preporuceno,$akcija,$popust);

            if(count($greske)){
                $_SESSION['greskeUnosProizvoda']=$greske;
                $this->redirect("index.php?admin=unos-proizvoda");
            }
            else{

                $proizvod=new Proizvod($this->baza);

                try{
                    $update=$proizvod->updateBezSlike($naziv,$cena,$opis,$preporuceno,$akcija,$popust,$marka,$kategorija,$id);
                    $_SESSION['uspeh']="Uspešno ažuriranje!";
                    $this->redirect("index.php?admin=unos-proizvoda");
                }
                catch(\PDOException $e){
                    upisGresaka($e->getMessage());
                    $_SESSION['greske']=[$e->getMessage()];
                    $this->redirect("index.php?admin=unos-proizvoda");
                }
            }

        }
        else{

            $id=$post['skriveno'];

            unlink("public/img/".$post['original']);
            unlink("public/img/".$post['nova']);

            $file=$files['slikaProizvoda'];

            $size=$file['size'];
            $type=$file['type'];
            $tmp=$file['tmp_name'];
            $fileName=$file['name'];

            $fajl=time()."-".$fileName;
            $path="public/img/".$fajl;
            $putanjaBazaNova=$fajl."-nova";
            $pathNova="public/img/".$putanjaBazaNova;


            $naziv=$post['nazivProizvoda'];
            $cena=$post['cenaProizvoda'];
            $opis=$post['opisProizvoda'];
            $kategorija=$post['ddlKategorija'];
            $marka=$post['ddlMarka'];
            $preporuceno=isset($post['chbPreporuceno'])?$post['chbPreporuceno']:false;
            $akcija=isset($post['chbAkcija'])?$post['chbAkcija']:false;
            $popust=$post['popust'];

            if(!$akcija){
                $popust=null;
            }

            $greske=$this->proveriDaLiSuPodaciDobri($naziv,$cena,$opis,$kategorija,$marka,$preporuceno,$akcija,$popust);

            foreach ($this->proveriDaLiJeSlikaDobra($type,$size) as $i){
                $greske[]=$i;
            }

            if(count($greske)){
                $_SESSION['greskeUnosProizvoda']=$greske;
                $this->redirect("index.php?admin=unos-proizvoda");
            }
            elseif(move_uploaded_file($tmp,$path)){

                $this->podesiSliku($path,$pathNova,$type);

                $proizvod=new Proizvod($this->baza);

                try{
                    $update=$proizvod->updateSaSlikom($naziv,$cena,$fajl,$putanjaBazaNova,$opis,$preporuceno,$akcija,$popust,$marka,$kategorija,$id);
                    $_SESSION['uspeh']="Uspešno ažuriranje!";
                    $this->redirect("index.php?admin=unos-proizvoda");
                }
                catch(\PDOException $e){
                    upisGresaka($e->getMessage());
                    $_SESSION['greske']=[$e->getMessage()];
                    $this->redirect("index.php?admin=unos-proizvoda");
                }

            }

        }

    }

    private function proveriDaLiSuPodaciDobri($naziv,$cena,$opis,$kategorija,$marka,$preporuceno,$akcija,$popust){

        $reNaziv="/^[\w\d\s\`\.\,\/\%\-]+$/";
        $reCena="/^\d+$/";

        $greske=[];

        if(!preg_match($reNaziv,$naziv)){
            array_push($greske,"Ime nije u dobrom formatu");
        }

        if(!preg_match($reCena,$cena)){
            array_push($greske,"Cena nije u dobrom formatu");
        }

        if($opis==''){
            array_push($greske,"Morate uneti opis");
        }

        if($kategorija=='0'){
            array_push($greske,"Morate izabrati kategoriju");
        }

        if($marka=='0'){
            array_push($greske,"Morate izabrati marku");
        }

        if(!($popust>1 && $popust < 100) && $akcija){
            array_push($greske,"Popust nije u dobrom formatu");
        }

        return $greske;
    }

    private function proveriDaLiJeSlikaDobra($type,$size){

        $greske=[];

        $dozvoljeniFormati=['image/jpeg','image/jpg','image/png','image/gif'];

        if(!in_array($type,$dozvoljeniFormati)){
            array_push($greske,"Tip fajla nije odgovarajici");
        }

        if($size>4000000){
            array_push($greske,"Velicina fajla nije odgovarajica");
        }

        return $greske;
    }

    private function podesiSliku($path,$pathNova,$type){

        $x=300;
        $y=300;

        list($sirina,$visina)=getimagesize($path);
        if($type=="image/jpeg"){
            $postojecaSlika=imagecreatefromjpeg($path);
        }
        elseif($type=="image/png"){
            $postojecaSlika=imagecreatefrompng($path);
        }
        elseif($type=="image/jpg"){
            $postojecaSlika=imagecreatefromjpeg($path);
        }


        $visina_nova=$y;
        $sirina_nova=$sirina*$y/$visina;

        $povecanaSlika=imagecreatetruecolor($sirina_nova,$visina_nova);
        imagecopyresampled($povecanaSlika,$postojecaSlika,0,0,0,0,$sirina_nova,$visina_nova,$sirina,$visina);

        if($sirina_nova>$x){
            $pomeraj_postojeca=($sirina_nova-$x)/2;
            $pomeraj_nova=0;
        }elseif($sirina_nova<$x){
            $pomeraj_postojeca=0;
            $pomeraj_nova=($x-$sirina_nova)/2;
        }else{
            $pomeraj_postojeca=0;
            $pomeraj_nova=0;
        }

        $nova=imagecreatetruecolor($x,$y);
        imagecopyresampled($nova,$povecanaSlika,$pomeraj_nova,0,$pomeraj_postojeca,0,$x,$y,$x,$y);

        if($type=="image/jpeg"){
            imagejpeg($nova,$pathNova);
        }elseif($type=="image/png"){
            imagepng($nova,$pathNova);
        }elseif($type=="image/jpg"){
            imagejpeg($nova,$pathNova);
        }
    }

    private function unosProizvoda($files,$post){

                $file=$files['slikaProizvoda'];

                $size=$file['size'];
                $type=$file['type'];
                $tmp=$file['tmp_name'];
                $fileName=$file['name'];

                $fajl=time()."-".$fileName;
                $path="public/img/".$fajl;
                $putanjaBazaNova=$fajl."-nova";
                $pathNova="public/img/".$putanjaBazaNova;

                $naziv=$post['nazivProizvoda'];
                $cena=$post['cenaProizvoda'];
                $opis=$post['opisProizvoda'];
                $kategorija=$post['ddlKategorija'];
                $marka=$post['ddlMarka'];
                $preporuceno=isset($post['chbPreporuceno'])?$post['chbPreporuceno']:false;
                $akcija=isset($post['chbAkcija'])?$post['chbAkcija']:false;
                $popust=$post['popust'];


                $greske=$this->proveriDaLiSuPodaciDobri($naziv,$cena,$opis,$kategorija,$marka,$preporuceno,$akcija,$popust);

                foreach ($this->proveriDaLiJeSlikaDobra($type,$size) as $i){
                    $greske[]=$i;
                }

                if(count($greske)){
                    $_SESSION['greskeUnosProizvoda']=$greske;
                    $this->redirect("index.php?admin=unos-proizvoda");
                }
                elseif(move_uploaded_file($tmp,$path)){

                    $this->podesiSliku($path,$pathNova,$type);

                    $proizvod=new Proizvod($this->baza);

                    try{
                        $unos=$proizvod->unos($naziv,$cena,$fajl,$putanjaBazaNova,$opis,$preporuceno,$akcija,$popust,$marka,$kategorija);
                        $_SESSION['uspeh']="Uspesan unos!";
                        $this->redirect("index.php?admin=unos-proizvoda");
                    }
                    catch(\PDOException $e){
                        upisGresaka($e->getMessage());
                        $_SESSION['greske']=[$e->getMessage()];
                        $this->redirect("index.php?admin=unos-proizvoda");
                    }

                }

    }

    public function obrisiProizvod($request){

        if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->nazivUloga==="admin") {

            if (isset($request['send'])) {

                $id = $request['id'];
                $nova = $request['nova'];
                $original = $request['original'];

                unlink("public/img/{$nova}");
                unlink("public/img/{$original}");

                $proizvod = new Proizvod($this->baza);

                try {
                    $obrisano = $proizvod->obrisi($id);
                    $this->json(["poruka"=>"Uspesno brisanje"], 204);

                }
                catch(\PDOException $e){
                    upisGresaka($e->getMessage());
                    $this->json(["greska"=>$e->getMessage()], 500);
                }

            }
            else {
                $this->json(["greska"=>"Bad request"], 400);
            }
        }
        else{
            $this->json(["greska"=>"Nemate pravo pristupa ovoj stranici"], 403);
        }

    }

    public function getProizvodeAdmin($request){

        if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->nazivUloga==="admin"){

            $id=$request['id'];
            $broj=($id-1)*4;

            $proizvod=new Proizvod($this->baza);

            try {
                $this->json($proizvod->getProizvodePaginacijaAdmin($broj));

            }
            catch(\PDOException $e){
                upisGresaka($e->getMessage());
                $this->json(["greska"=>$e->getMessage()], 500);
            }


        }else{
            $this->loadPage("greske/403");
        }

    }

    public function getJedanProizvod($request){

        if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->nazivUloga==="admin") {

            if (isset($_GET['send'])) {

                $id = $_GET['id'];

                $proizvod = new Proizvod($this->baza);

                try {
                    $data = $proizvod->getProizvod($id);
                    $this->json($data);
                }
                catch(\PDOException $e){
                    upisGresaka($e->getMessage());
                    $this->json(["greska"=>$e->getMessage()], 500);
                }

            }
            else{
                $this->json(["greska"=>"Bad request"],400);
            }
        }
        else{
            $this->json(["greska"=>"Nemate pravo pristupa ovoj stranici"],403);
        }
    }

    public function dohvatiBrojProizvoda(){

        $proizvod=new Proizvod($this->baza);

        try {
            $proizvodi=$proizvod->dohvatiUkupanBrojProizvoda();
            $this->json($proizvodi);

        }
        catch(\PDOException $e){
            upisGresaka($e->getMessage());
            $this->json(["greska"=>$e->getMessage()], 500);
        }

    }

}

