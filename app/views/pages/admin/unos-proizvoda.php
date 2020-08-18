<?php
include "app/views/fixed/divLevoAdmin.php";
?>
<div class="row">
    <div class="col-md-5">

        <form method="POST" action="index.php?admin=insert-proizvoda" enctype='multipart/form-data'>
            <div class="form-group">
                <input type="text" name="nazivProizvoda" id="nazivProizvoda" placeholder='Naziv proizvoda' class='form-control'>
            </div>
            <div class="form-group">
                <label>Slika proizvoda : &nbsp;</label> <input type="file" name="slikaProizvoda" id="slikaProizvoda">
            </div>
            <img src="" id="praznaSlika" width="120px"/>
            <div class="form-group">
                <input type="text" name="cenaProizvoda" id="cenaProizoda" placeholder='Cena proizvoda' class='form-control'>
            </div>
            <div class="form-group">
                <textarea class="form-control tekstForme" rows="6" id="opisProizvoda" name="opisProizvoda" placeholder="Opis proizvoda"></textarea>
            </div>
            <label>Kategorija proizvoda : </label>
            <div class="form-group">
                <select name='ddlKategorija' id='ddlKategorija' class=form-control>
                    <option value='0'>Izaberite</option>

                    <?php foreach ($data['kategorije'] as $x):?>
                        <option value='<?=$x->idKategorija;?>'><?=$x->nazivKategorija;?></option>
                    <?php endforeach;?>


                </select>
            </div>

            <label>Marka proizvoda : </label>
            <div class="form-group">
                <select name='ddlMarka' id='ddlMarka' class=form-control>
                    <option value='0'>Izaberite</option>
                    <?php foreach ($data['marke'] as $i):?>
                        <option value='<?=$i->idMarka;?>'><?=$i->nazivMarka;?></option>
                    <?php endforeach;?>

                </select>
            </div>

            <div class="form-group">
                <label>Preporučeno Da | Ne </label>&nbsp;
                <input type="checkbox" name="chbPreporuceno" id="chbPreporuceno" value='1'>
            </div>

            <div class="form-group">
                <label>Na akciji Da | Ne </label>&nbsp;
                <input type="checkbox" name="chbAkcija" id="chbAkcija" value='1'>
            </div>

            <div class="form-group">
                <input type="text" name="popust" id="popust" placeholder='Naziv proizvoda' class='form-control'>
            </div>

            <input type="submit" value="Unesi" name='btnUnosProizvoda' id='btnUnosProizvoda' class='btn btn-primary'>&nbsp;
            <input type="reset" value="Obriši" id='reset' class='btn btn-primary'>&nbsp;
            <input type="hidden" name="skriveno" id="skriveno" class=form-control>

            <input type="hidden" name="original" id="original" class=form-control>
            <input type="hidden" name="nova" id="nova" class=form-control>

        </form>

        <div id="obavestenjeunosProizvoda">
            <?php if(isset($_SESSION['uspeh'])) {echo $_SESSION['uspeh']; unset($_SESSION['uspeh']);}?>

            <?php if(isset($_SESSION['greskeUnosProizvoda'])):?>

                <ul>

                    <?php foreach ($_SESSION['greskeUnosProizvoda'] as $i):?>

                        <li><?=$i;?></li>

                    <?php endforeach;?>

                </ul>

                <?php unset($_SESSION['greskeUnosProizvoda']); endif;?>
        </div>


    </div>

    <div class="col-md-7">
        <table class="korpaTabela" border="1">

        </table>

        <div id="blokPaginacija" class="punaDuzina">

            <ul class="pagination">

            </ul>

        </div>
    </div>

</div>