<?php
include "app/views/fixed/divLevo.php";
?>

<div class="punaDuzina">


    <div id="blokFiltriranje" class="punaDuzina">

        <p class="punaDuzina">Izvršite detaljniju pretragu proizvoda</p>

        <form action="#" method="">

            <select class="ddLists" id="sortirajNaziv">
                <option value="0">Sortiraj po nazivu</option>
                <option value="1">Opadajuće</option>
                <option value="2">Rastuće</option>
            </select>

            <select class="ddLists" id="sortirajCena">
                <option value="0">Sortiraj po ceni</option>
                <option value="1">Opadajuće</option>
                <option value="2">Rastuće</option>
            </select>


            <select class="ddLists" id="filterMarka">
                <option value="0">Izaberite marku</option>

                <?php foreach ($data["marke"] as $i):?>

                    <option value="<?=$i->idMarka?>"><?=$i->nazivMarka?></option>

                <?php endforeach; ?>

            </select><br>


            <input type="text" class="cenaInput"  placeholder="Unesite cenu od" id="cenaOd">
            <input type="text" class="cenaInput"  placeholder="Unesite cenu do" id="cenaDo">


            <input type="button" class="btn btn-primary"  value="Pretrazi" id="cenaPretraga">

            <input type="hidden" value="<?= $_GET['i'];?>" id="kategorijaHidden">


            <?php if(!(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->nazivUloga==="admin")):?>

                <input type="hidden" value="1" id="poljeZaIdentifikacijuAktivnosti">

            <?php endif;?>

        </form>

        <div id="obavestenjeFiltriranje">

        </div>

    </div>

</div>


<div id="sredina">


</div>


<div id="blokPaginacija" class="punaDuzina">

    <ul class="pagination">

    </ul>

</div>
