<?php
include "app/views/fixed/divLevo.php";
?>
<div class="registracija">

    <p>Profil korisnika</p>

    <form action="#" method="">

        <div class="form-group">
            <label for="imeAzu">Ime</label>
            <input type="text" class="form-control"id="imeAzu" value="<?=$data['korisnickiPodaci']->ime;?>">
        </div>

        <div class="form-group">
            <label for="prezimeAzu">Prezime</label>
            <input type="text" class="form-control"id="prezimeAzu" value="<?=$data['korisnickiPodaci']->prezime;?>">
        </div>

        <div class="form-group">
            <label for="gradAzu">Grad</label>
            <input type="text" class="form-control" id="gradAzu" value="<?=$data['korisnickiPodaci']->grad;?>">
        </div>

        <div class="form-group">
            <label for="adresaAzu">Adresa</label>
            <input type="text" class="form-control" id="adresaAzu" value="<?=$data['korisnickiPodaci']->adresa;?>">
        </div>

        <div class="form-group">
            <label for="emailAzu">Email</label>
            <input type="text" class="form-control" id="emailAzu" value="<?=$data['korisnickiPodaci']->email;?>">
        </div>

        <div class="form-group">
            <label for="lozinkaAzu">Lozinka</label>
            <input type="password" class="form-control" id="lozinkaAzu">
        </div>

        <input class="btn btn-primary" type="button" id="azuSave" value="Unesi">

                <input type="hidden" id="skrivenoProfil" value="<?=$data['korisnickiPodaci']->idKorisnik;?>"/>

        <div id="obavestenjeProfil">

        </div>


    </form>

</div>