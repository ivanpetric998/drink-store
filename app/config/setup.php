<?php

session_start();

function autoload($className)
{
    $className = ltrim($className, '\\');
    $fileName  = '';
    $namespace = '';
    if ($lastNsPos = strrpos($className, '\\')) {
        $namespace = substr($className, 0, $lastNsPos);
        $className = substr($className, $lastNsPos + 1);
        $fileName  = str_replace('\\', DIRECTORY_SEPARATOR, $namespace) . DIRECTORY_SEPARATOR;
    }
    $fileName .= str_replace('_', DIRECTORY_SEPARATOR, $className) . '.php';

    require $fileName;
}

spl_autoload_register('autoload');

function upisGresaka($greska){
    @$open=fopen(GRESKE_FAJL,"a");
    $unos=$greska."\t".date('d-m-Y H:i:s')."\n";
    @fwrite($open,$unos);
    @fclose($open);
}

function ispisTitle(){
    $url=explode("&",$_SERVER['REQUEST_URI']);
    $base="/DrinkStore/";
    switch ($url[0]){
        case "{$base}":
            echo "<title>Diskont pića - Početna</title>";
            break;
        case "{$base}index.php":
            echo "<title>Diskont pića - Početna</title>";
            break;
        case "{$base}index.php?page=pocetna":
            echo "<title>Diskont pića - Početna</title>";
            break;
        case "{$base}index.php?page=proizvodi":
            echo "<title>Diskont pića - Proizvodi</title>";
            break;
        case "{$base}index.php?page=autor":
            echo "<title>Diskont pića - o autoru</title>";
            break;
        case "{$base}index.php?page=proizvod":
            echo "<title>Diskont pića - Proizvod</title>";
            break;
        case "{$base}index.php?page=korpa":
            echo "<title>Diskont pića - Korpa</title>";
            break;
        case "{$base}index.php?page=kontakt":
            echo "<title>Diskont pića - Kontakt</title>";
            break;
        case "{$base}index.php?page=registracija":
            echo "<title>Diskont pića - Registracija</title>";
            break;
        case "{$base}index.php?page=pretraga":
            echo "<title>Diskont pića - Pretraga</title>";
            break;
        case "{$base}index.php?page=najnovije":
            echo "<title>Diskont pića - Najnovije</title>";
            break;
        case "{$base}index.php?page=preporuceno":
            echo "<title>Diskont pića - Preporuceno</title>";
            break;
        case "{$base}index.php?page=akcija":
            echo "<title>Diskont pića - Akcija</title>";
            break;
        case "{$base}index.php?page=profil":
            echo "<title>Diskont pića - Profil</title>";
            break;
        case "{$base}index.php?page=zelje-porudzbine":
            echo "<title>Diskont pića - Želje | Porudžbine</title>";
            break;
        case "{$base}index.php?admin=pocetna":
            echo "<title>Diskont pića - Admin</title>";
            break;
        case "{$base}index.php?admin=korisnici":
            echo "<title>Diskont pića - Admin</title>";
            break;
        case "{$base}index.php?admin=unos-proizvoda":
            echo "<title>Diskont pića - Admin</title>";
            break;
        case "{$base}index.php?admin=porudzbine":
            echo "<title>Diskont pića - Admin</title>";
            break;
    }
}

function ispisDescription(){
    $url=explode("&",$_SERVER['REQUEST_URI']);
    $base="/DrinkStore/";
    $content="";
    switch ($url[0]){
        case "{$base}":
            $content="Naš diskont pića nudi najbolje proizvode po najpovoljnijim cenama u gradu. 
            Kupite naše proizvode od sada i preko naše online prodavnice";
            break;
        case "{$base}index.php":
            $content="Naš diskont pića nudi najbolje proizvode po najpovoljnijim cenama u gradu. 
            Kupite naše proizvode od sada i preko naše online prodavnice";
            break;
        case "{$base}index.php?page=pocetna":
            $content="Naš diskont pića nudi najbolje proizvode po najpovoljnijim cenama u gradu. 
            Kupite naše proizvode od sada i preko naše online prodavnice";
            break;
        case "{$base}index.php?page=proizvodi":
            $content="Nudimo najširi asortiman svih vrsta pića";
            break;
        case "{$base}index.php?page=proizvod":
            $content="Nudimo najširi asortiman svih vrsta pića";
            break;
        case "{$base}index.php?page=korpa":
            $content="Kupite naše proizvode od sada na našoj web stranici online";
            break;
        case "{$base}index.php?page=kontakt":
            $content="U slučaju bilo kakvih nedoumica kontaktirajte nas preko naše forme";
            break;
        case "{$base}index.php?page=autor":
            $content="Ovo je stranica o autoru, gde možete pročitati o autorovoj biografiji";
            break;
        case "{$base}index.php?page=registracija":
            $content="Da biste mogli da izvršite online kupovinu,a i zbog mnogih drugih mogućnosti, registrujte se na našem sajtu";
            break;
        case "{$base}index.php?page=pretraga":
            $content="Nudimo najširi asortiman svih vrsta pića";
            break;
        case "{$base}index.php?page=najnovije":
            $content="Pogledajte naše najnovije proizvode";
            break;
        case "{$base}index.php?page=preporuceno":
            $content="Pogledajte naše preopručene proizvode";
            break;
        case "{$base}index.php?page=akcija":
            $content="Pogledajte naše proizvode na akciji";
            break;
        case "{$base}index.php?page=profil":
            $content="Uredite Vaš profil na našem sajtu";
            break;
        case "{$base}index.php?page=zelje-porudzbine":
            $content="Pogledajte sve Vaše porudžbine i listu želja na našem sajtu";
            break;
        case "{$base}index.php?admin=pocetna":
            $content="Admin strana namenjena za pregled statistike o broju posećenosti stranica";
            break;
        case "{$base}index.php?admin=korisnici":
            $content="Admin strana namenjena za unos, brisanje i ažuriranje podataka o korisnicima";
            break;
        case "{$base}index.php?admin=unos-proizvoda":
            $content="Admin strana namenjena za unos, brisanje i ažuriranje podataka o proizvodima";
            break;
        case "{$base}index.php?admin=porudzbine":
            $content="Admin strana namenjena za pregled porudžbina";
            break;
    }

    echo " <meta name=\"description\" content=\"{$content}\">";
}

function zabeleziPristupStranici(){
    @ $open = fopen(LOG_FAJL, "a");
    if($open){
        $date = date('d-m-Y H:i:s');
        @ fwrite($open, "{$_SERVER['REQUEST_URI']}\t{$date}\t{$_SERVER['REMOTE_ADDR']}\t\n");
        @ fclose($open);
    }
}

function pristupStranicamaProcenat(){

    $niz=[];

    $ukupno=0;
    $pocetna=0;
    $autor=0;
    $kontakt=0;
    $registracija=0;
    $proizvodi=0;
    $proizvod=0;
    $korpa=0;
    $pretraga=0;
    $najnovije=0;
    $preporuceno=0;
    $akcija=0;
    $profil=0;
    $zelje=0;

    $oneDayAgo=strtotime("1 day ago");

    $base="/DrinkStore/";

    @$file=file(LOG_FAJL);
    if(count($file)){
        foreach($file as $i){

            $delovi=explode("\t",$i);
            $url=explode("&",$delovi[0]);

            if(strtotime($delovi[1])>=$oneDayAgo){
                switch($url[0]){
                    case "{$base}":$pocetna++;$ukupno++;;break;
                    case "{$base}index.php":$pocetna++;$ukupno++;;break;
                    case "{$base}index.php?page=pocetna":$pocetna++;$ukupno++;;break;
                    case "{$base}index.php?page=autor":$autor++;$ukupno++;;break;
                    case "{$base}index.php?page=kontakt":$kontakt++;$ukupno++;;break;
                    case "{$base}index.php?page=registracija":$registracija++;$ukupno++;;break;
                    case "{$base}index.php?page=proizvodi":$proizvodi++;$ukupno++;;break;
                    case "{$base}index.php?page=proizvod":$proizvod++;$ukupno++;;break;
                    case "{$base}index.php?page=korpa":$korpa++;$ukupno++;;break;
                    case "{$base}index.php?page=pretraga":$pretraga++;$ukupno++;;break;
                    case "{$base}index.php?page=najnovije":$najnovije++;$ukupno++;;break;
                    case "{$base}index.php?page=preporuceno":$preporuceno++;$ukupno++;;break;
                    case "{$base}index.php?page=akcija":$akcija++;$ukupno++;;break;
                    case "{$base}index.php?page=profil":$profil++;$ukupno++;;break;
                    case "{$base}index.php?page=zelje-porudzbine":$zelje++;$ukupno++;;break;

                }
            }
        }

    }

    $niz['pocetna']=$pocetna;
    $niz['autor']=$autor;
    $niz['kontakt']=$kontakt;
    $niz['registracija']=$registracija;
    $niz['proizvodi']=$proizvodi;
    $niz['proizvod']=$proizvod;
    $niz['korpa']=$korpa;
    $niz['pretraga']=$pretraga;
    $niz['najnovije']=$najnovije;
    $niz['preporuceno']=$preporuceno;
    $niz['akcija']=$akcija;
    $niz['profil']=$profil;
    $niz['zelje']=$zelje;

    return $niz;
}
