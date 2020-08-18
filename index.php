<?php

    include "app/config/config.php";
    include "app/config/setup.php";

    use app\models\DB;
    use app\controllers\PocetnaKontroler;
    use app\controllers\ProizvodiKontroler;
    use app\controllers\RegistracijaKontroler;
    use app\controllers\LoginKontroler;
    use app\controllers\KontaktKontroler;
    use app\controllers\KontrolerAdminPocetna;
    use app\controllers\UnosProizvodaKontroler;
    use app\controllers\StraniceGreskeKontroler;
    use app\controllers\ProfilKontroler;
    use app\controllers\AkcijaKontroler;
    use app\controllers\PreporucenoKontroler;
    use app\controllers\NajnovijiProizvodiKontroler;
    use app\controllers\PretragaKontroler;
    use app\controllers\KorpaKontroler;
    use app\controllers\KorisnikPorudzbineZeljeKontroler;
    use app\controllers\AutorKontroler;
    use app\controllers\KontrolerAdminKorisnici;
    use app\controllers\KontrolerAdminPorudzbine;


    if(isset($_GET["page"])) {
        switch($_GET["page"]) {
            case "pocetna" :
                $pocetnaKontroler=new PocetnaKontroler();
                $pocetnaKontroler->ucitajPocetnu();
                break;
            case "proizvodi":
                $proizvodiKontroler=new ProizvodiKontroler();
                $proizvodiKontroler->ucitajStranuProizvodi($_GET);
                break;
            case "proizvod":
                $proizvodiKontroler=new ProizvodiKontroler();
                $proizvodiKontroler->ucitajStranuProizvod($_GET);
                break;
            case "registracija":
                $registracija=new RegistracijaKontroler();
                $registracija->ucitajStranuRegistracija();
                break;
            case "login":
                $login=new LoginKontroler();
                $login->login($_POST);
                break;
            case "logout":
                $login=new LoginKontroler();
                $login->logout();
                break;
            case "kontakt":
                $kontakt=new KontaktKontroler();
                $kontakt->ucitajKontaktStranu();
                break;
            case "profil":
                $profil=new ProfilKontroler();
                $profil->ucitajStranu();
                break;
            case "akcija":
                $akcija=new AkcijaKontroler();
                $akcija->ucitajStranuNaAkciji();
                break;
            case "preporuceno":
                $preporuceno=new PreporucenoKontroler();
                $preporuceno->ucitajStranuPreporuceno();
                break;
            case "najnovije":
                $najnovije=new NajnovijiProizvodiKontroler();
                $najnovije->ucitajStranuNajnovijiProizvodi();
                break;
            case "pretraga":
                $pretraga=new PretragaKontroler();
                $pretraga->ucitajStranuZaPretraguProizvoda($_POST);
                break;
            case "korpa":
                $korpa=new KorpaKontroler();
                $korpa->ucitajStranu();
                break;
            case "zelje-porudzbine":
                $korisnikPorudzbineZeljeKontroler=new KorisnikPorudzbineZeljeKontroler();
                $korisnikPorudzbineZeljeKontroler->ucitajStranu();
                break;
            case "autor":
                $autor=new AutorKontroler();
                $autor->ucitajStranu();
                break;
            case "403":
                $greska=new StraniceGreskeKontroler();
                $greska->strana403();
                break;
            case "404":
                $greska=new StraniceGreskeKontroler();
                $greska->strana404();
                break;
            case "400":
                $greska=new StraniceGreskeKontroler();
                $greska->strana400();
                break;
            default:
                $greska=new StraniceGreskeKontroler();
                $greska->strana404();
                break;
        }
    }
    elseif(isset($_GET['ajax']))
    {
        switch ($_GET['ajax']){
            case "registracija" :
                $registracija=new KontrolerAdminKorisnici();
                $registracija->unosKorisnika($_POST);
                break;
            case "obrisi-proizvod":
                $proizvod=new UnosProizvodaKontroler();
                $proizvod->obrisiProizvod($_POST);
                break;
            case "svi-proizvodi-admin":
                $proizvod=new UnosProizvodaKontroler();
                $proizvod->getProizvodeAdmin($_GET);
                break;
            case "jedan-proizvod":
                $proizvod=new UnosProizvodaKontroler();
                $proizvod->getJedanProizvod($_GET);
                break;
            case "broj-proizvoda-admin":
                $proizvod=new UnosProizvodaKontroler();
                $proizvod->dohvatiBrojProizvoda();
                break;
            case "broj-proizvoda":
                $proizvod=new ProizvodiKontroler();
                $proizvod->dohvatiBrojProizvoda($_GET);
                break;
            case "svi-proizvodi":
                $proizvod=new ProizvodiKontroler();
                $proizvod->dohvatiProizvode($_GET);
                break;
            case "azuriranje-profila":
                $profil=new KontrolerAdminKorisnici();
                $profil->azurirajKorisnika($_POST);
                break;
            case "dodaj-zelju":
                $proizvod=new ProizvodiKontroler();
                $proizvod->dodajUListuZelja($_POST);
                break;
            case "svi-proizvodi-korpa":
                $korpa=new KorpaKontroler();
                $korpa->dohvatiProizvode();
                break;
            case "izvrsi-porudzbinu":
                $korpa=new KorpaKontroler();
                $korpa->izvrsiPorudzbinu($_POST);
                break;
            case "dohvati-detalje-porudzbine":
                $korisnikPorudzbineZeljeKontroler=new KorisnikPorudzbineZeljeKontroler();
                $korisnikPorudzbineZeljeKontroler->prikaziDetaljePorudzbine($_GET);
                break;
            case "dohvati-listu-zelja":
                $korisnikPorudzbineZeljeKontroler=new KorisnikPorudzbineZeljeKontroler();
                $korisnikPorudzbineZeljeKontroler->prikaziListuZelja();
                break;
            case "obrisi-proizvod-iz-liste-zelja":
                $korisnikPorudzbineZeljeKontroler=new KorisnikPorudzbineZeljeKontroler();
                $korisnikPorudzbineZeljeKontroler->obrisiPorizvodIzListeZelja($_POST);
                break;
            case "broj-korisnika-admin":
                $admin=new KontrolerAdminKorisnici();
                $admin->getBrojKorisnika();
                break;
            case "svi-korisnici":
                $admin=new KontrolerAdminKorisnici();
                $admin->getKorisnikePaginacija($_GET);
                break;
            case "jedan-korisnik":
                $admin=new KontrolerAdminKorisnici();
                $admin->getJednogKorisnika($_GET);
                break;
            case "obrisi-korisnika":
                $admin=new KontrolerAdminKorisnici();
                $admin->obrisiKorisnika($_POST);
                break;
            case "statistika-stranice":
                $admin=new KontrolerAdminPocetna();
                $admin->getStraniceStatistika();
                break;
            case "poruka":
                $kontakt=new KontaktKontroler();
                $kontakt->posaljiMail($_POST);
                break;
        }

    }
    elseif(isset($_GET['admin'])){
        switch ($_GET['admin']){
            case "pocetna":
                $adminPocetnaKontroler=new KontrolerAdminPocetna();
                $adminPocetnaKontroler->ucitajStranu();
                break;
            case "korisnici":
                $adminPocetnaKontroler=new KontrolerAdminKorisnici();
                $adminPocetnaKontroler->ucitajStranuZaKorisnike();
                break;
            case "unos-proizvoda":
                $proizvod=new UnosProizvodaKontroler();
                $proizvod->ucitajStranu();
                break;
            case "insert-proizvoda":
                $proizvod=new UnosProizvodaKontroler();
                $proizvod->insertUpdateProizvoda($_FILES,$_POST);
                break;
            case "porudzbine":
                $admin=new KontrolerAdminPorudzbine();
                $admin->ucitajStranuZaPorudzbine();
                break;
            default:
            $greska=new StraniceGreskeKontroler();
            $greska->strana404();
            break;
        }
    }
    else {
        $pocetnaKontroler=new PocetnaKontroler();
        $pocetnaKontroler->ucitajPocetnu();
    }


