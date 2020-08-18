<?php
include "app/views/fixed/divLevo.php";
?>
<div class="registracija">

    <p>Forma za Kontakt</p>

    <form action="#" method="">

        <div class="form-group">
            <label for="kontEmail">Email</label>
            <input type="text" class="form-control" placeholder="Unesite email adresu" id="kontEmail">
        </div>

        <div class="form-group">
            <label for="kontSvrha">Svrha poruke</label>
            <input type="text" class="form-control" placeholder="Unesite svrhu poruke" id="kontSvrha">
        </div>

        <div class="form-group">
            <label for="kontTekst">Tekst poruke</label>
            <textarea rows="14" class="form-control" placeholder="Unesite tekst poruke" id="kontTekst"></textarea>
        </div>


        <input class="btn btn-primary" type="button" id="posaljimail" value="Pošalji">


        <div id="obavestenjeKont">

        </div>

    </form>

</div>
