<?php
include "app/views/fixed/divLevo.php";

?>

<div id="sredina">

    <?php foreach ($data['proizvodiZaPrikaz'] as $i):?>

    <div class="clanak">
        <a href="index.php?page=proizvod&i=<?=$i->idProizvod;?>" class="clanakLink" target="_blank">

            <?php if($i->akcija=="1"):?>

            <span class="akcija">akcija</span>

            <?php endif;?>


            <img src="public/img/<?=$i->slikaNova;?>" alt="<?=$i->proizvodNaziv;?>"/>
            <div class="clanakOpis">
                <span class="proizvodNaziv"><?=$i->proizvodNaziv;?></span>
                <span class="proizvodCena">

                    <?php if($i->akcija=="1"):?>

                    <?= $i->cena*(100-$i->popust)/100;?> RSD <strike><sup><?=$i->cena;?></sup></strike></span>

                <?php else:?>

                <span class="proizvodCena">

                    <?= $i->cena*(100-$i->popust)/100;?> RSD </span>

                <?php endif;?>


            </div><p class="clanakLinija"></p>

            <?php if(!(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->nazivUloga==='admin')):?>

            <span><a class="fa-icon zelje" data-id="<?= $i->idProizvod;?>"><i class="fa fa-heart-o"></i></a></span>
            <span><a class="fa-icon korpa" data-id="<?= $i->idProizvod;?>"><i class="fa fa-shopping-cart"></i></a></span>

            <?php endif;?>

        </a>
    </div>

    <?php endforeach;?>

</div>
