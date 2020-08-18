<?php
include "app/views/fixed/divLevo.php";
?>

<div class="row" id="porudzbineZelje">

    <div class="col-md-6">

        <table class="korpaTabela" border="1">

            <tr>
                <th colspan="4">Lista porudžbina</th>
            </tr>
            <tr>
                <th>RB</th>
                <th>Datum</th>
                <th>Vreme</th>
                <th>Vidi detaljnije</th>
            </tr>

            <?php $br=1; foreach($data['porudzbine'] as $i):

                $datumVreme=explode(" ",$i->datum);
                $datum=explode("-",$datumVreme[0]);
                $datumIspis="{$datum[2]}-{$datum[1]}-{$datum[0]}";
                $vreme=explode(":",$datumVreme[1]);
                $vremeIspis="{$vreme[0]}:{$vreme[1]}";

             ?>

            <tr>
                <td><?= $br++;?></td>
                <td><?= $datumIspis;?></td>
                <td><?= $vremeIspis;?></td>
                <td><a href="#" data-id="<?= $i->idPorudzbina;?>" class="porudzbine">Detaljnije</a></td>
            </tr>

            <?php endforeach;?>

        </table>


    </div>

    <div class="col-md-6">

        <table class="korpaTabela" border="1" id="tabelaListaZelja">


        </table>


    </div>

</div>
<div class="row">

    <table class="korpaTabela" border="1" id="tabelaDetaljiPorudzbine">



    </table>
</div>
