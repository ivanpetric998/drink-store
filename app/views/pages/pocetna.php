<?php

include "app/views/fixed/divLevo.php";
?>
<div id="slikanes" class="punaDuzina">

    <div id="myCarousel" class="carousel slide" data-ride="carousel">


            <!-- Indicators -->
            <ol class="carousel-indicators">
                <?php for($i=0;$i<count($data["slajder"]);$i++):?>

                    <?php if($i===0):?>
                        <li data-target="#myCarousel" data-slide-to="<?= $i;?>" class="active"></li>
                    <?php else:?>
                        <li data-target="#myCarousel" data-slide-to="<?= $i;?>"></li>

                    <?php endif;?>

                <?php endfor;?>
            </ol>

            <!-- Wrapper for slides -->
            <div class="carousel-inner" role="listbox">

                <?php $br=0; foreach($data["slajder"] as $x):

                    if($br==0):

                 ?>

                    <div class="item active">
                        <a href="index.php?page=proizvodi&i=<?= $x->idKategorija?>">
                            <img src="public/images/<?= $x->src?>" alt="<?= $x->alt?>">
                        </a>
                        <div class="carousel-caption">
                            <h3><?= $x->opis?></h3>
                        </div>
                    </div>

                <?php else:?>

                      <div class="item">
                          <a href="index.php?page=proizvodi&i=<?= $x->idKategorija?>">
                              <img src="public/images/<?= $x->src?>" alt="<?= $x->alt?>">
                          </a>
                          <div class="carousel-caption">
                              <h3><?= $x->opis?></h3>
                          </div>
                      </div>

                <?php endif; $br++; endforeach;?>

            </div>



        <!-- Left and right controls -->
        <a class="left carousel-control" href="#myCarousel" role="button" data-slide="prev">
            <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span>
            <span class="sr-only">Previous</span>
        </a>

        <a class="right carousel-control" href="#myCarousel" role="button" data-slide="next">
            <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span>
            <span class="sr-only">Next</span>
        </a>

    </div>

</div>

<div class="section-title text-center punaDuzina">
    <p class="naslov">Najprodavaniji proizvodi</p>
</div>

<div id="sredina">


    <?php foreach ($data['najprodavaniji'] as $i):?>

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
