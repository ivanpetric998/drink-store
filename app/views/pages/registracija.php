<?php
include "app/views/fixed/divLevo.php";
?>
<div class="registracija">

    <p>Forma za registraciju</p>

    <form action="#" method="">

        <div class="form-group">
            <label for="imeReg">Ime</label>
            <input type="text" class="form-control" placeholder="Unesite ime" id="imeReg">
        </div>

        <div class="form-group">
            <label for="prezimeReg">Prezime</label>
            <input type="text" class="form-control" placeholder="Unesite prezime" id="prezimeReg">
        </div>

        <div class="form-group">
            <label for="gradReg">Grad</label>
            <input type="text" class="form-control" placeholder="Unesite grad" id="gradReg">
        </div>

        <div class="form-group">
            <label for="adresaReg">Adresa</label>
            <input type="text" class="form-control" placeholder="Unesite adresu" id="adresaReg">
        </div>

        <div class="form-group">
            <label for="emailReg">Email</label>
            <input type="text" class="form-control" placeholder="Unesite email" id="emailReg">
        </div>

        <div class="form-group">
            <label for="lozinkaReg">Lozinka</label>
            <input type="password" class="form-control" placeholder="Unesite lozinku" id="lozinkaReg">
        </div>

        <input class="btn btn-primary" type="button" id="regSave" value="Unesi">
        <input class="btn btn-primary" type="reset" id="reset" value="Obrisi">

        <div id="obavestenje">

        </div>

    </form>

</div>
