<div class="centar">

    <div class="levo">


        <div class="vertical-menu">

            <a href="#" class="aktivna">kategorije</a>

            <?php foreach ($data["kategorijeMeni"] as $kat):?>

                <a href="index.php?page=proizvodi&i=<?= $kat->idKategorija;?>"><?= $kat->nazivKategorija;?></a>

            <?php endforeach; ?>

        </div>

        <div class="vertical-menu">

            <a href="#" class="aktivna">dodatno</a>

            <?php foreach ($data["meniDodatno"] as $meni):?>

                <a href="index.php?<?= $meni->link;?>"><?= $meni->tekst;?></a>

            <?php endforeach; ?>

        </div>


    </div>

    <div class="desno">