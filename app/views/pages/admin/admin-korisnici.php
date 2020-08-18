<?php
include "app/views/fixed/divLevoAdmin.php";
?>
<div class="row">
    <div class="col-md-5">

        <form method="POST" action="#" enctype='multipart/form-data'>

            <div class="form-group">
                <label for="imeUnos">Ime</label>
                <input type="text" class="form-control" placeholder="Unesite ime" id="imeUnos">
            </div>

            <div class="form-group">
                <label for="prezimeUnos">Prezime</label>
                <input type="text" class="form-control" placeholder="Unesite prezime" id="prezimeUnos">
            </div>

            <div class="form-group">
                <label for="gradUnos">Grad</label>
                <input type="text" class="form-control" placeholder="Unesite grad" id="gradUnos">
            </div>

            <div class="form-group">
                <label for="adresaUnos">Adresa</label>
                <input type="text" class="form-control" placeholder="Unesite adresu" id="adresaUnos">
            </div>

            <div class="form-group">
                <label for="emailUnos">Email</label>
                <input type="text" class="form-control" placeholder="Unesite email" id="emailUnos">
            </div>

            <div class="form-group">
                <label for="lozinkaUnos">Lozinka</label>
                <input type="password" class="form-control" placeholder="Unesite lozinku" id="lozinkaUnos">
            </div>

            <div class="form-group">
                <label for="ddlUloga">Uloga</label>
                <select name='ddlMarka' id='ddlUloga' class=form-control>
                    <option value='0'>Izaberite</option>
                    <?php foreach ($data['uloge'] as $i):?>
                        <option value='<?=$i->idUloga;?>'><?=$i->nazivUloga;?></option>
                    <?php endforeach;?>

                </select>
            </div>

            <input class="btn btn-primary" type="button" id="unosSave" value="Unesi">
            <input class="btn btn-primary" type="reset" id="resetUnos" value="Obrisi">

            <input type="hidden" id="skrivenoPoljeZaKorisnika" value="0">

        </form>

        <div id="obavestenjeunosKorisnika">

        </div>


    </div>

    <div class="col-md-7">
        <table class="korpaTabela" border="1" id="tabelaZaKorisnike">

        </table>

        <div id="blokPaginacija" class="punaDuzina">

            <ul class="pagination">

            </ul>

        </div>
    </div>

</div>