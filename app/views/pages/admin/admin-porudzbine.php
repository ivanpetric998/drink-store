<?php
include "app/views/fixed/divLevoAdmin.php";
?>
<div class="row">

    <div class="col-md-6">

        <table class="korpaTabela" border="1">
            <tr>
                <th>Ime i prezime</th>
                <th>Datum</th>
                <th>Vreme</th>
                <th></th>
            </tr>

            <?php $br=1; foreach($data['porudzbine'] as $i):

                $datumVreme=explode(" ",$i->datum);
                $datum=explode("-",$datumVreme[0]);
                $datumIspis="{$datum[2]}-{$datum[1]}-{$datum[0]}";
                $vreme=explode(":",$datumVreme[1]);
                $vremeIspis="{$vreme[0]}:{$vreme[1]}";

                ?>

                <tr>

                    <td><?= $i->ime." ".$i->prezime;?></td>
                    <td><?= $datumIspis;?></td>
                    <td><?= $vremeIspis;?></td>
                    <td><a href="#" data-id="<?= $i->idPorudzbina;?>" class="porudzbine">Detaljnije</a></td>
                </tr>

            <?php endforeach;?>

        </table>

    </div>

    <div class="col-md-6">
        <table class="korpaTabela" border="1" id="tabelaDetaljiPorudzbine">



        </table>
    </div>

</div>


