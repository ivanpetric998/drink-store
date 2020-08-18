<div class="centar">

    <div class="levo">

        <?php if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->nazivUloga==="admin"):?>

            <div class="vertical-menu">

                <a href="#" class="aktivna">meni</a>

                <?php foreach ($data["meniAdmin"] as $meni):?>

                    <a href="index.php?<?= $meni->link;?>"><?= $meni->tekst;?></a>

                <?php endforeach; ?>

            </div>


        <?php endif;?>

    </div>

    <div class="desno">