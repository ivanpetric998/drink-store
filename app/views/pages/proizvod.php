<?php
include "app/views/fixed/divLevo.php";
?>

<div id="sredinaProizvod" class="row">


    <div class="col-sm-6 offset-sm-3" id="slikaProizvod">
        <img src="public/img/<?=$data['proizvod']->slikaOriginal;?>" alt="<?=$data['proizvod']->proizvodNaziv;?>"/>
    </div>

    <div class="col-xs-1">
    </div>

    <div class="col-sm-5">

        <?php if($data['proizvod']->akcija):?>

        <div class="row">
            <span class="akcija" id="akcijaNaStraniProizvod">akcija</span>
        </div>

        <?php endif;?>

        <div class="row">
            <h3><?=$data['proizvod']->proizvodNaziv;?></h3>
        </div>

        <div class="row">
            <p class="tekstProizvodOpis">Cena :</p>
        </div>

        <?php if($data['proizvod']->akcija):?>

        <div class="row">
            <p class="cenaBroj"><?= $data['proizvod']->cena*(100-$data['proizvod']->popust)/100;?>  RSD <strike><sup><?= $data['proizvod']->cena;?></sup></strike></p>
        </div>

        <?php else:?>

            <div class="row">
                <p class="cenaBroj"><?=$data['proizvod']->cena;?> RSD
            </div>

        <?php endif;?>

        <?php if(!(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->nazivUloga==='admin')):?>

        <div class="row">
            <p class="tekstProizvodOpis">Izaberite kolicinu :</p>
            <input class="form-control" type="number" value="1" id="example-number-input">
        </div>

        <div class="row">
            <button type="button" data-id="<?= $data['proizvod']->idProizvod;?>" class="dugmeKorpaZelje" id="korpaDodaj">Dodaj u korpu <i class="fa fa-shopping-cart"></i></button>
            <button type="button" data-id="<?= $data['proizvod']->idProizvod;?>" class="dugmeKorpaZelje zelje" id="dugmeZelje">Dodaj u listu želja <i class="fa fa-heart-o"></i></button>
        </div>

        <?php endif;?>

    </div>

</div>

<div id="divOpis">
    <p>Opis :</p>
    <p>
        <?=$data['proizvod']->opis;?>

    </p>
</div>
