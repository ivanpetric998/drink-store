

<nav class="navbar" id="gornjiMeni">

  <div class="container">

	  <div class="row">

			<ul class="nav navbar-nav">
			  <li id="brojTelefona">kontakt telefon : +381 64/444-44-44</li>
			</ul>


              <ul class="nav navbar-nav navbar-right">


                  <?php if(isset($_SESSION['korisnik'])):?>

                      <?php if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->nazivUloga==="admin"):?>

                          <li><a href="index.php?admin=pocetna">Admin panel</a></li>
                          <li><a href="index.php">Nazad na sajt</a></li>

                      <?php endif;?>

                      <li><a href="index.php?page=profil">Profil</a></li>

                      <?php if(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->nazivUloga==="korisnik"):?>

                          <li><a href="index.php?page=kontakt">Kontakt</a></li>

                          <li><a href="index.php?page=zelje-porudzbine">Istorija kupovina | Lista želja</a></li>

                      <?php endif;?>

                      <li><a href="index.php?page=logout">Odjavi se</a></li>

                  <?php else:?>

                      <li><a href="index.php?page=kontakt">Kontakt</a></li>
                      <li><a href="#" id="logReg">registracija | prijava</a></li>

                  <?php endif;?>


              </ul>

	  </div>

  </div>

</nav>

<div id="divRegLog">

	<span id="nalovLog">Ulogujte se</span>
	<span id="close"><i class="fa fa-close"></i></span>

    <form action="index.php?page=login" method="post">

        <div class="form-group" id="emailLogDrzac">
            <label for="emailLog">Email</label>
            <input type="text" class="form-control" name="emailLog" placeholder="Unesite email" id="emailLog">
        </div>

        <div class="form-group">
            <label for="lozlLog">Lozinka</label>
            <input type="password" class="form-control" name="lozLog" placeholder="Unesite lozinku" id="lozlLog">
        </div>

        <input class="btn btn-primary" type="submit" name="logDugme" id="logDudme" value="Uloguj se">

    </form>

	<p><a href="index.php?page=registracija">Nemate nalog? Registrujte se</a></p>

    <?php

        if(isset($_SESSION['greske'])){
            if(count($_SESSION['greske'])){
                foreach ($_SESSION['greske'] as $greska){
                    echo $greska."</br>";
                }
            }
            unset($_SESSION['greske']);
        }

    ?>


</div>

<div class="container-fluid" id="naslov">

	<div class="container">

		<div id="zaglavlje">

			<div id="logoo">
				<a href="index.php"><img src="public/images/logo1.jpg" alt="Logo"></a>
			</div>

			<div id="pretraga">

				<form class="form-inline" method="post" action="index.php?page=pretraga" id="formaZaPretragu">
					<input class="form-control mr-sm-2 inpSearch" id="textPretraga" name="textPretraga" type="text" placeholder="Pretraga" aria-label="Search">
					<button class="btn btn-outline-success my-2 my-sm-0 search" name="pretragaButton" type="submit"><i class="fa fa-search"></i></button>
				</form>

			</div>

            <?php if(!(isset($_SESSION['korisnik']) && $_SESSION['korisnik']->nazivUloga==="admin")):?>

			<a href="index.php?page=korpa">
				<div id="korpa">
						<span id="ikonica"><i class="fa fa-shopping-cart"></i></span>Korpa
                       (<span id="brojArtikalaUKorpi">0</span>)
				</div>
			</a>

            <?php endif;?>

		</div>


	</div>

</div>

<div class="container-fluid">