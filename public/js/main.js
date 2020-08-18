const baseURL="http://localhost/DrinkStore/index.php";

$(document).ready(function () {

    ispisiBrojProizvodaUGlavnojKorpi();

    $("#formaZaPretragu").submit(function () {

        let tekst=$("#textPretraga").val()

        if(tekst=="")
            return false;
        else
            return true;

    })

    $(document).on("click",".zelje",function(e){

        e.preventDefault();

        let id=$(this).data("id");

        $.ajax({
            url:"index.php?ajax=dodaj-zelju",
            dataType:"json",
            method:"post",
            data:{
                "idProizvod":id
            },
            success:function (data,status,xhr) {

                if(xhr.status==201){
                    alert(data.poruka)
                }

            },
            error:function (xhr,status,error) {

                if(xhr.status==403 || xhr.status==409){

                    let poruka = JSON.parse(xhr.responseText);
                    alert(poruka.greska)

                }
                else{

                    alert(xhr.status)

                }


            }
        })

    })

    $(document).on("click",".korpa",function (e) {

        e.preventDefault();

        let id=$(this).data("id");

        dodajUKorpu(id,true);

        $("#brojArtikalaUKorpi").html(ukupnaKolicina())

    })

    if((window.location.href==baseURL + "?admin=pocetna")
        || (window.location.href==baseURL + "?admin=pocetna#")){
        $.ajax({
            url:"index.php?ajax=statistika-stranice",
            dataType:"json",
            method:"get",
            success:function (data,status,xhr) {

                var chart = new CanvasJS.Chart("chartContainer", {
                    title:{
                        text: "Statistika posećenosti stranica"
                    },
                    data: [{
                        type: "pie",
                        legendText: "{label}",
                        indexLabelFontSize: 18,
                        indexLabel: "{label} - #percent%",
                        yValueFormatString: "฿#,##0",
                        dataPoints: data
            }]
            });
                chart.render();

            },
            error:function (xhr,status,error) {
                alert(xhr.status)
            }
        })
    }

    if((window.location.href==baseURL + "?page=kontakt")
        || (window.location.href==baseURL + "?page=kontakt#")){

        $("#posaljimail").click(function () {

            let email=$("#kontEmail").val().trim();
            let svrha=$("#kontSvrha").val().trim();
            let sadrzaj=$("#kontTekst").val().trim();

            let reEmail = /^\w+([\.\-]\w+)*@\w+([\.\-]\w+)*(\.\w{2,4})+$/;

            let greske=[];

            if(!reEmail.test(email)){
                greske.push("Email nije u dobrom formatu");
            }
            if(svrha==""){
                greske.push("Morate uneti svrhu poruke");
            }
            if(sadrzaj==""){
                greske.push("Morate uneti tekst poruke");
            }

            if(greske.length){
                let ispis="<ul>";

                for(let i of greske){
                    ispis+=`<li>${i}</li>`;
                }

                ispis+="</ul>";

                $("#obavestenjeKont").html(ispis);
            }
            else{

                $("#obavestenjeKont").html("");

                data={send:true,mail:email,svrha:svrha,tekst:sadrzaj};

                $.ajax({
                    url:"index.php?ajax=poruka",
                    dataType:"json",
                    data:data,
                    method:"post",
                    success:function (data,status,xhr) {
                        if(xhr.status==200){
                            $("#obavestenjeKont").html(data.poruka);
                        }
                    },
                    error:function (xhr,status,error) {
                        alert(xhr.status)
                    }
                })


            }

        });




    }


    if((window.location.href==baseURL + "?page=registracija")
        || (window.location.href==baseURL + "?page=registracija#")){

        $("#regSave").click(function () {

            let greske=null;
            let data=null;

            let ime=$("#imeReg").val().trim();
            let prezime=$("#prezimeReg").val().trim();
            let grad=$("#gradReg").val().trim();
            let adresa=$("#adresaReg").val().trim();
            let email=$("#emailReg").val().trim();
            let lozinka=$("#lozinkaReg").val().trim();

            greske=proveraParametaraZaRegistraciju(ime,prezime,grad,adresa,email,lozinka);

            if(greske.length){

                let ispis="<ul>";
                for (let i of greske){
                    ispis+="<li>" + i + "</li>";
                }
                ispis+="</ul>";

                $("#obavestenje").html(ispis)

            }
            else{

                $("#obavestenje").html("");

                data={
                    send:true,
                    ime:ime,
                    prezime:prezime,
                    grad:grad,
                    adresa:adresa,
                    email:email,
                    lozinka:lozinka
                };

                $.ajax({
                    url:"index.php?ajax=registracija",
                    dataType:"json",
                    data:data,
                    method:"post",
                    success:function (data,status,xhr) {
                        $("#obavestenje").html("Uspešna registracija");
                    },
                    error:function (xhr,status,error) {
                        alert(xhr.status)
                    }
                })
            }


        })

        $("#reset").click(function () {
            $("#obavestenje").html("")
        })
    }

    if((window.location.href==baseURL + "?admin=korisnici")
        || (window.location.href==baseURL + "?admin=korisnici#")){

        $("#unosSave").click(function () {

            let ime=$("#imeUnos").val().trim();
            let prezime=$("#prezimeUnos").val().trim();
            let grad=$("#gradUnos").val().trim();
            let adresa=$("#adresaUnos").val().trim();
            let email=$("#emailUnos").val().trim();
            let lozinka=$("#lozinkaUnos").val().trim();
            let uloga=$("#ddlUloga").val();
            let skriveno=$("#skrivenoPoljeZaKorisnika").val();

            if(lozinka=="" && skriveno!="0"){
                lozinka=null;
            }

            let greske=proveraParametaraZaRegistraciju(ime,prezime,grad,adresa,email,lozinka,uloga);

            if(greske.length){

                let ispis="<ul>";
                for (let i of greske){
                    ispis+="<li>" + i + "</li>";
                }
                ispis+="</ul>";

                $("#obavestenjeunosKorisnika").html(ispis)

            }
            else{

                $("#obavestenjeunosKorisnika").html("");

                let data={
                    send:true,
                    ime:ime,
                    prezime:prezime,
                    grad:grad,
                    adresa:adresa,
                    email:email,
                    lozinka:lozinka,
                    uloga:uloga
                };

                if(skriveno=="0"){
                    $.ajax({
                        url:"index.php?ajax=registracija",
                        dataType:"json",
                        data:data,
                        method:"post",
                        success:function (data,status,xhr) {

                            if(xhr.status=201){
                                $("#obavestenjeunosKorisnika").html("Uspešna registracija");
                                ocistiFormu();
                                ucitajKorisnike(1)
                            }

                        },
                        error:function (xhr,status,error) {
                            alert(xhr.status)
                        }
                    })
                }
                else{

                    data.id=skriveno;

                    $.ajax({
                        url:"index.php?ajax=azuriranje-profila",
                        dataType:"json",
                        data:data,
                        method:"post",
                        success:function (data,status,xhr) {

                            if(xhr.status==204){
                                $("#obavestenjeunosKorisnika").html("Uspešno ažuriranje");
                                ocistiFormu();
                                ucitajKorisnike($(".active").children().data('id'))
                            }


                        },
                        error:function (xhr,status,error) {
                            alert(xhr.status)
                        }
                    })
                }

            }


        })

        $("#resetUnos").click(function () {
            $("#obavestenjeunosKorisnika").html("")
            ocistiFormu();
        })

        ucitajKorisnike(1);
        ucitajpaginaciju();

        $(document).on("click",".detaljnijeKorisnik",function () {

            $("#obavestenjeunosKorisnika").html("");

            let id=$(this).data("id");

            $.ajax({
                url:"index.php?ajax=jedan-korisnik",
                dataType:"json",
                data:{id:id},
                method:"get",
                success:function (data,status,xhr) {

                    $("#imeUnos").val(data.ime)
                    $("#prezimeUnos").val(data.prezime)
                    $("#gradUnos").val(data.grad)
                    $("#adresaUnos").val(data.adresa)
                    $("#emailUnos").val(data.email)
                    $("#ddlUloga").val(data.idUloga);
                    $("#skrivenoPoljeZaKorisnika").val(data.idKorisnik);

                },
                error:function (xhr,status,error) {
                    alert(xhr.status)
                }
            })
        });

        $(document).on("click",".obrisiKorisnika",function () {
            let id=$(this).data("id");

            $.ajax({
                url:"index.php?ajax=obrisi-korisnika",
                dataType:"json",
                data:{id:id},
                method:"post",
                success:function (data,status,xhr) {

                    if(xhr.status==204){
                        ocistiFormu();
                        ucitajKorisnike($(".active").children().data('id'))
                    }

                },
                error:function (xhr,status,error) {

                    if(xhr.status==409){
                        let poruka = JSON.parse(xhr.responseText);
                        alert(poruka.greska)
                    }
                }
            })
        })

    }


    if((window.location.href==baseURL + "?admin=unos-proizvoda")
        || (window.location.href==baseURL + "?admin=unos-proizvoda#")){

        ucitajProizvodeZaAdmina(1)

        $("#popust").hide();

        $("#chbAkcija").click(function () {
            if($(this).prop("checked")){
                $("#popust").slideDown();
            }
            else {
                $("#popust").slideUp();
            }
        })

        $("#reset").click(function () {
            obrisiSveIzFormeZaUnosProizvoda()
        })

        ucitajpaginaciju();

    }

    if((window.location.href.split("&")[0]==baseURL + "?page=proizvodi")
        || (window.location.href.split("&")[0]==baseURL + "?page=proizvodi#")){

        ucitajpaginaciju();
        ucitajProizvode(1);

        $("#cenaPretraga").click(function () {

            let cenaOd=parseFloat($("#cenaOd").val());
            let cenaDo=parseFloat($("#cenaDo").val());

            if(cenaOd > 1 && cenaDo > 1 && cenaOd < cenaDo){
                $("#obavestenjeFiltriranje").html("");
                ucitajpaginaciju();
                ucitajProizvode(1);
            }
            else{
                $("#obavestenjeFiltriranje").html("Parametri za filtriranje po ceni nisu ispravni!");
            }


        })

        $("#sortirajNaziv").change(function () {
            ucitajpaginaciju();
            ucitajProizvode(1);
        })

        $("#sortirajCena").change(function () {
            ucitajpaginaciju();
            ucitajProizvode(1);
        })

        $("#filterMarka").change(function () {
            ucitajpaginaciju();
            ucitajProizvode(1);
        })

    }

    if((window.location.href==baseURL + "?page=profil")
        || (window.location.href==baseURL + "?page=profil#")){

        $("#azuSave").click(function () {

            let ime=$("#imeAzu").val().trim()
            let prezime=$("#prezimeAzu").val().trim()
            let grad=$("#gradAzu").val().trim()
            let adresa=$("#adresaAzu").val().trim()
            let email=$("#emailAzu").val().trim()
            let lozinka=$("#lozinkaAzu").val().trim()
            let id=$("#skrivenoProfil").val()

            if(lozinka==""){
                lozinka=null;
            }

            let greske=proveraParametaraZaRegistraciju(ime,prezime,grad,adresa,email,lozinka);

            if(greske.length){

                let ispis="<ul>";
                for (let i of greske){
                    ispis+="<li>" + i + "</li>";
                }
                ispis+="</ul>";

                $("#obavestenjeProfil").html(ispis)

            }
            else{

                $("#obavestenjeProfil").html("")

                let data={
                    "send":true,
                    "ime":ime,
                    "prezime":prezime,
                    "grad":grad,
                    "adresa":adresa,
                    "email":email,
                    "lozinka":lozinka,
                    "id":id
                };

                $.ajax({
                    url:"index.php?ajax=azuriranje-profila",
                    dataType:"json",
                    data:data,
                    method:"post",
                    success:function (data,status,xhr) {

                        if(xhr.status==204)
                            $("#obavestenjeProfil").html("Uspešno ažuriranje profila")

                    },
                    error:function (xhr,status,error) {
                        alert(xhr.status)
                    }
                })

            }

        })



    }

    if((window.location.href.split("&")[0]==baseURL + "?page=proizvod")
        || (window.location.href.split("&")[0]==baseURL + "?page=proizvod#")){

        let idProizvoda=$("#korpaDodaj").data("id");
        let kolicinaProizvodaUKorpi=getKolicinuZaProizvodIzKorpe(idProizvoda);
        $("#example-number-input").val(kolicinaProizvodaUKorpi)

        $("#korpaDodaj").click(function () {

            let id=$(this).data("id");
            let kolicina=$("#example-number-input").val();

            if(kolicina<1){
                alert("Količina nije u dobrom formatu");
            }
            else{
                kolicina=parseInt(kolicina);
                dodajUKorpu(id,false,kolicina);
                ispisiBrojProizvodaUGlavnojKorpi();
            }

        })

    }

    if((window.location.href==baseURL + "?page=korpa")
        || (window.location.href==baseURL + "?page=korpa#")){

        ucitajSveProizvodeUKorpi();

        $(document).on("click",".obrisiProizvodIzKorpe",function () {

            let id=$(this).data("id");
            obrisiProizvodIzKorpe(id);
            ispisiBrojProizvodaUGlavnojKorpi();
            ucitajSveProizvodeUKorpi();

        })

        $(document).on("change",".kolicina-korpa",function () {

            let value=$(this).val()
            let id=$(this).data("id");

            if(value<1){
                alert("Količina nije u dobrom formatu!");
            }
            else{
                dodajUKorpu(id,false,parseInt(value));
                ispisiBrojProizvodaUGlavnojKorpi();
                ucitajSveProizvodeUKorpi();
            }

        })

        $(document).on("click","#dugmeKorpa",function () {

            let proizvodi=proizvodiUKorpi();

            $.ajax({
                url:"index.php?ajax=izvrsi-porudzbinu",
                dataType:"json",
                method:"post",
                data:{
                    "obj":proizvodi
                },
                success:function (data,status,xhr) {

                    if(xhr.status==201){
                        alert(data.poruka);
                        isprazniKorpu();
                        ispisiVasaKorpaJePrazna();
                        ispisiBrojProizvodaUGlavnojKorpi();
                    }

                },
                error:function (xhr,status,error) {
                    if(xhr.status==403){

                        let poruka = JSON.parse(xhr.responseText);
                        alert(poruka.greska)

                    }
                    else{
                        console.log(xhr.status)
                    }

                }
            })

        })

    }

    if((window.location.href==baseURL + "?page=zelje-porudzbine")
        || (window.location.href==baseURL + "?page=zelje-porudzbine#")){

        $("#tabelaDetaljiPorudzbine").hide();

        $(".porudzbine").click(function () {

            let id=$(this).data("id");

            $.ajax({
                url:"index.php?ajax=dohvati-detalje-porudzbine",
                dataType:"json",
                method:"get",
                data:{
                    "id":id
                },
                success:function (data,status,xhr) {

                    ispisiDetaljePorudzbine(data);

                    $("#sakrijTabelu").click(function () {
                        $("#tabelaDetaljiPorudzbine").hide();
                    })

                },
                error:function (xhr,status,error) {
                    console.log(xhr.status)
                }
            })

        })

        ucitajListuZelja();
    }

    if((window.location.href==baseURL + "?admin=porudzbine")
        || (window.location.href==baseURL + "?admin=porudzbine#")){

        $("#tabelaDetaljiPorudzbine").hide();

        $(".porudzbine").click(function (e) {

            e.preventDefault();

            let id=$(this).data("id");

            $.ajax({
                url:"index.php?ajax=dohvati-detalje-porudzbine",
                dataType:"json",
                method:"get",
                data:{
                    "id":id
                },
                success:function (data,status,xhr) {

                    ispisiDetaljePorudzbine(data);

                    $("#sakrijTabelu").click(function () {
                        $("#tabelaDetaljiPorudzbine").hide();
                    })

                },
                error:function (xhr,status,error) {
                    alert(xhr.status)
                }
            })

        })

    }

})


/*      Global     */

function ispisiBrojProizvodaUGlavnojKorpi() {
    $("#brojArtikalaUKorpi").html(ukupnaKolicina())
}

function ucitajpaginaciju() {

    let adresa="index.php?ajax=";
    let data=null;

    if((window.location.href==baseURL + "?admin=unos-proizvoda")
        || (window.location.href==baseURL + "?admin=unos-proizvoda#")){
        adresa+="broj-proizvoda-admin";
    }

    if((window.location.href.split("&")[0]==baseURL + "?page=proizvodi")
        || (window.location.href.split("&")[0]==baseURL + "?page=proizvodi#")){

        adresa+="broj-proizvoda";
        data=dohvatiPodatkeZaFiltriranje()
    }

    if((window.location.href==baseURL + "?admin=korisnici")
        || (window.location.href==baseURL + "?admin=korisnici#")){
        adresa+="broj-korisnika-admin";
    }

    $.ajax({
        url:adresa,
        dataType:"json",
        method:"get",
        data:data,
        success:function (data,status,xhr) {

            ispisiPaginaciju(data.broj)
            $(".pag").click(klikNaPaginaciju)

        },
        error:function (xhr,status,error) {
            console.log(xhr.status)
        }
    })

}

function ispisiPaginaciju(broj) {

    let brojZaPrikaz=1;

    if((window.location.href==baseURL + "?admin=unos-proizvoda")
        || (window.location.href==baseURL + "?admin=unos-proizvoda#")){
        brojZaPrikaz=4;
    }

    if((window.location.href==baseURL + "?admin=korisnici")
        || (window.location.href==baseURL + "?admin=korisnici#")){
        brojZaPrikaz=10;
    }

    if((window.location.href.split("&")[0]==baseURL + "?page=proizvodi")
        || (window.location.href.split("&")[0]==baseURL + "?page=proizvodi#")){
        brojZaPrikaz=6;
    }

    let ispis="";
    let br=Math.ceil(broj/brojZaPrikaz);
    for(let i=1;i<=br;i++){
        if(i===1) {
            ispis+=`<li class="active"><a class="pag" data-id="${i}" href="#">${i}</a></li>`
        }
        else{
            ispis+=`<li><a class="pag" data-id="${i}" href="#">${i}</a></li>`;
        }
    }
    $(".pagination").html(ispis)
}

function klikNaPaginaciju(e) {

    e.preventDefault();
    $(".active").attr("class","")
    $(this).parent().attr("class","active");
    let id=$(this).data("id");

    if((window.location.href==baseURL + "?admin=unos-proizvoda")
        || (window.location.href==baseURL + "?admin=unos-proizvoda#")){
        ucitajProizvodeZaAdmina(id)
    }

    if((window.location.href.split("&")[0]==baseURL + "?page=proizvodi")
        || (window.location.href.split("&")[0]==baseURL + "?page=proizvodi#")){

        ucitajProizvode(id);
    }

    if((window.location.href==baseURL + "?admin=korisnici")
        || (window.location.href==baseURL + "?admin=korisnici#")){
        ucitajKorisnike(id)
    }

}

/*         Global - kraj         */




/*          Korisnici               */

function ucitajKorisnike(id){

    $.ajax({
        url:"index.php?ajax=svi-korisnici",
        dataType:"json",
        method:"get",
        data:{id:id},
        success:function (data,status,xhr) {

            ispisSveKorisnike(data);

        },
        error:function (xhr,status,error) {
            alert(xhr.status)
        }
    })

}

function ispisSveKorisnike(data){

    let ispis=`
            <tr>
                <th>ID</th>
                <th>Ime</th>
                <th>Prezime</th>
                <th>Email</th>
                <th></th>
                <th></th>
            </tr>`;

        for(let i of data){
            ispis+=`<tr>
                <td>${i.idKorisnik}</td>
                <td>${i.ime}</td>
                <td>${i.prezime}</td>
                <td>${i.email}</td>
                <td><a href="#" class="detaljnijeKorisnik" data-id="${i.idKorisnik}">Detaljnije</a></td>
                <td><a href="#" class="obrisiKorisnika" data-id="${i.idKorisnik}">Obrisi</a></td>
            </tr>`;
        }

    $("#tabelaZaKorisnike").html(ispis);
}

function proveraParametaraZaRegistraciju(ime,prezime,grad,adresa,email,lozinka,uloga) {

    let greske=[];

    let reImePrez=/^[A-Z][a-z]{2,14}(\s[A-Z][a-z]{2,14})*$/;
    let reLoz=/^\S{6,30}$/;
    let reEmail = /^\w+([\.\-]\w+)*@\w+([\.\-]\w+)*(\.\w{2,4})+$/;
    let reGrad=/^[A-Z][a-z]{1,14}(\s[A-Z][a-z]{1,14})*$/
    let reAdresa=/^[A-Z][a-z]{2,14}(\s([A-z]{3,14}|\d{1,}))*$/

    if(!reImePrez.test(ime)){
        greske.push("Ime nije u dobrom formatu");
    }
    if(!reImePrez.test(prezime)){
        greske.push("Prezime nije u dobrom formatu");
    }
    if(!reGrad.test(grad)){
        greske.push("Grad nije u dobrom formatu");
    }
    if(!reAdresa.test(adresa)){
        greske.push("Adresa nije u dobrom formatu");
    }
    if(!reEmail.test(email)){
        greske.push("Email nije u dobrom formatu");
    }
    if(lozinka!=null && !reLoz.test(lozinka)){
        greske.push("Lozinka nije u dobrom formatu");
    }
    if(uloga!=null && uloga=="0"){
        greske.push("Morate izabrati ulogu");
    }

    return greske;

}

function ocistiFormu() {
    $("#imeUnos").val("")
    $("#prezimeUnos").val("")
    $("#gradUnos").val("")
    $("#adresaUnos").val("")
    $("#emailUnos").val("")
    $("#ddlUloga").val("0")
    $("#skrivenoPoljeZaKorisnika").val("0")
    $("#lozinkaUnos").val("")
}

/*          Korisnici - kraj              */




/*         Porudzbine, detalji porudzbine i liste zelja       */


function ispisiDetaljePorudzbine(data){
    let ukupnaCena=0;

    let ispis=`
            <tr>
                <th>Naziv</th>
                <th>Proizvod</th>
                <th>Cena</th>
                <th>Kolicina</th>
                <th>Ukupno</th>
            </tr>`;

    for(let i of data){

        let cena=0;
        let ukupnaCenaZaJedanProizvod=0;

        if(i.akcija=="1"){
            cena=i.cena*(100-i.popust)/100;
        }
        else{
            cena=i.cena;
        }
        ukupnaCenaZaJedanProizvod=cena*i.kolicina
        ukupnaCena+=ukupnaCenaZaJedanProizvod;

        ispis+=`<tr>
                    <td>${i.proizvodNaziv}</td>
                    <td><img src="public/img/${i.slikaNova}" width="90px" alt="${i.proizvodNaziv}"/></td>
                    <td>${cena} RSD</td>
                    <td>${i.kolicina}</td>
                    <td>${ukupnaCenaZaJedanProizvod} RSD</td>
                </tr>`;
    }

    ispis+=`<tr>
                <td colspan="1"><button type="button" class="btn btn-primary" id="sakrijTabelu">Sakrij</button> </td>
                <td colspan="3">Ukupna cena kupovine iznosi :</td>
                <td colspan="1">${ukupnaCena} RSD</td>
            </tr>`;

    $("#tabelaDetaljiPorudzbine").show();
    $("#tabelaDetaljiPorudzbine").html(ispis);
}

function ucitajListuZelja() {

    $.ajax({
        url:"index.php?ajax=dohvati-listu-zelja",
        dataType:"json",
        method:"get",
        success:function (data,status,xhr) {

            ispisiListuZelja(data)
            $(".obrisiProizvodIzListeZelja").click(obrisiProizvodIzListeZelja)

        },
        error:function (xhr,status,error) {
            console.log(xhr.status)
        }
    })
}

function ispisiListuZelja(data) {
    let ispis=`<tr>
                <th colspan="4">Lista želja</th>
            </tr>
            <tr>
                <th>Naziv</th>
                <th>Proizvod</th>
                <th>Cena</th>
                <th>Izbriši</th>
            </tr>`;

    for(let i of data){

        let cena=0;

        if(i.akcija=="1"){
            cena=i.cena*(100-i.popust)/100;
        }
        else{
            cena=i.cena;
        }

        ispis+=`<tr><td><a target="_blank" href="index.php?page=proizvod&i=${i.idProizvod}">${i.proizvodNaziv}</a></td>
                    <td><a target="_blank" href="index.php?page=proizvod&i=${i.idProizvod}"><img src="public/img/${i.slikaNova}" width="90px" alt="${i.proizvodNaziv}"/></a></td>
                    <td>${cena} RSD</td>
                    <td><a href="#" data-id="${i.idProizvod}" class="obrisiProizvodIzListeZelja">Obrisi</a></td></tr>`;

    }

    $("#tabelaListaZelja").html(ispis);
}

function obrisiProizvodIzListeZelja(e) {

    e.preventDefault();
    let id=$(this).data("id");


    $.ajax({
        url:"index.php?ajax=obrisi-proizvod-iz-liste-zelja",
        dataType:"json",
        method:"post",
        data:{
            "id":id
        },
        success:function (data,status,xhr) {

            if(xhr.status==204){
                ucitajListuZelja();
            }

        },
        error:function (xhr,status,error) {
            alert(xhr.status)
        }
    })
}

/*         Porudzbine, detalji porudzbine i liste zelja - kraj       */



/*          Korpa         */

function proizvodiUKorpi() {

    return JSON.parse(localStorage.getItem("proizvodi"));

}

function dodajUKorpu(id,azuriranje,kolicina=1) {

    let proizvodi = proizvodiUKorpi();

    if (proizvodi) {
        if (proizvodJeVecUKorpi()) {
            azurirajKolicinu();
        } else {
            dodaj()
        }
    } else {
        dodajPrviProizvodUKorpu();
    }

    function dodajPrviProizvodUKorpu() {
        let proizvodi = [];
        proizvodi[0] = {
            id : id,
            kolicina : kolicina
        };
        localStorage.setItem("proizvodi", JSON.stringify(proizvodi));
    }

    function proizvodJeVecUKorpi() {

        return proizvodi.filter(p => p.id == id).length;

    }

    function dodaj() {

        proizvodi.push({
            id : id,
            kolicina : kolicina
        });

        localStorage.setItem("proizvodi", JSON.stringify(proizvodi));

    }

    function azurirajKolicinu() {

        for(let i of proizvodi)
        {
            if(i.id == id) {
                if(azuriranje){
                    i.kolicina+=kolicina;
                }
                else{
                    i.kolicina=kolicina;
                }
                break;
            }
        }

        localStorage.setItem("proizvodi", JSON.stringify(proizvodi));

    }

}

function ukupnaKolicina() {

    let proizvodi = proizvodiUKorpi();

    if(proizvodi){
        let suma=0;

        for (let i of proizvodi){
            suma+=i.kolicina;
        }

        return suma;
    }
    else return 0;
}

function getKolicinuZaProizvodIzKorpe(id) {

    let proizvodi=proizvodiUKorpi();
    let kolicina=1;
    if(proizvodi){

        for(let i of proizvodi){
            if(i.id==id){
                kolicina=i.kolicina;
                break;
            }
        }
    }
    return kolicina;
}

function obrisiProizvodIzKorpe(id) {

    let proizvodi=proizvodiUKorpi();
    let niz=[];
    for(let i of proizvodi){
        if(i.id!=id){
            niz.push(i);
        }
    }

    localStorage.setItem("proizvodi", JSON.stringify(niz));
}

function ucitajSveProizvodeUKorpi() {

    let proizvodi=proizvodiUKorpi();

    if(proizvodi==null || proizvodi.length==0){
        ispisiVasaKorpaJePrazna();
    }
    else{
        $.ajax({
            url:"index.php?ajax=svi-proizvodi-korpa",
            dataType:"json",
            method:"get",
            success:function (data,status,xhr) {

                data=data.filter(p=>{
                    for(let proizvod of proizvodi){
                        if(proizvod.id==p.idProizvod){
                            p.kolicina=proizvod.kolicina;
                            return true;
                        }
                    }
                    return false;
                });

                ispisiProizvodeUKorpi(data);



            },
            error:function (xhr,status,error) {
                alert(xhr.status)
            }
        })
    }






}

function ispisiProizvodeUKorpi(data){

    let cena=0;

    let ispis=`<table class="korpaTabela" border="1">
        <thead>

        <tr>
            <th>Naziv</th>
            <th>Proizvod</th>
            <th>Cena po komadu</th>
            <th>Količina</th>
            <th>Ukupna cena</th>
            <th>Obriši</th>
        </tr>
        </thead>
        <tbody>`;

    for(let i of data){
        ispis+=`<tr>
            <td><a href="index.php?page=proizvod&i=${i.idProizvod}">${i.proizvodNaziv}</a></td>
            <td><a href="index.php?page=proizvod&i=${i.idProizvod}"><img src="public/img/${i.slikaNova}" width="100px" alt="${i.proizvodNaziv}"/></a></td>
            <td>`;

        if(i.akcija=="1"){
            cena=i.cena*(100-i.popust)/100;
        }
        else{
            cena=i.cena;
        }

        ispis+=`${cena} RSD</td>
            <td><input data-id="${i.idProizvod}" class="form-control kolicina-korpa" type="number" value="${i.kolicina}"></td>
            <td>${cena*i.kolicina}</td>
            <td><button type="button" data-id="${i.idProizvod}" class="btn btn-primary obrisiProizvodIzKorpe">Obrisi</button></td>

        </tr>`;

    }

    ispis+=`</tbody>
    </table>

    <button id="dugmeKorpa" type="button">Poruči</button>`;

    $("#korpaDiv").html(ispis);
}

function isprazniKorpu(){
    localStorage.removeItem("proizvodi");
}

function ispisiVasaKorpaJePrazna() {
    $("#korpaDiv").html("<div class=\".punaDuzina h1TagSredina\">\n" +
        "\n" +
        "    <h1>VAŠA KORPA JE PRAZNA!!!</h1>\n" +
        "\n" +
        "</div>");
}

/*          Korpa - kraj         */




/*          Prikaz proizvoda          */

function ucitajProizvode(id) {

    let data= dohvatiPodatkeZaFiltriranje()
    data.id=id

    $.ajax({
        url:"index.php?ajax=svi-proizvodi",
        dataType:"json",
        method:"get",
        data:data,
        success:function (data,status,xhr) {

            if(data.length==0){
                $("#sredina").html("<div class=\".punaDuzina h1TagSredina\"><h1>Nema proizvoda!!!</h1></div>")
            }
            else{
                ispisiSveProizvode(data);
            }

        },
        error:function (xhr,status,error) {
            console.log(xhr.status)
        }
    })

}

function ispisiSveProizvode(data) {
    let ispis=``;

    for(let i of data){
        ispis+=` <div class="clanak">
        <a href="index.php?page=proizvod&i=${i.idProizvod}" class="clanakLink" target="_blank">`;

        if(i.akcija=="1"){
            ispis+=`<span class="akcija">akcija</span>`;
        }

        ispis+=`
            <img src="public/img/${i.slikaNova}" alt="${i.proizvodNaziv}"/>
            <div class="clanakOpis">
                <span class="proizvodNaziv">${i.proizvodNaziv}</span>`;

        if(i.akcija=="1"){
            ispis+=`<span class="proizvodCena">`;ispis+= i.cena*(100-i.popust)/100;
            ispis+=` RSD
                    <strike><sup>${i.cena}</sup></strike>`;
        }
        else{
            ispis+=`<span class="proizvodCena">${i.cena} RSD`;
        }

        ispis+=`              
                </span>
            </div>
            <p class="clanakLinija"></p>`;

        if($("#poljeZaIdentifikacijuAktivnosti").val()==1){
            ispis+=`<span><a href="#" data-id="${i.idProizvod}" class="fa-icon zelje"><i class="fa fa-heart-o"></i></a></span>
            <span><a data-id="${i.idProizvod}" class="fa-icon korpa"><i class="fa fa-shopping-cart"></i></a></span>`;
        }
        ispis+=`</a></div>`;
    }

    $("#sredina").html(ispis)
}

function dohvatiPodatkeZaFiltriranje() {
    return data={
        "naziv":$("#sortirajNaziv").val(),
        "cena":$("#sortirajCena").val(),
        "marka":$("#filterMarka").val(),
        "cenaOd":$("#cenaOd").val(),
        "cenaDo":$("#cenaDo").val(),
        "kategorija":$("#kategorijaHidden").val()
    }
}

/*          Prikaz proizvoda - kraj          */




/*      Unos proizvoda admin      */

function obrisiSveIzFormeZaUnosProizvoda() {
    $("#popust").hide()
    $("#popust").val("")
    $("#skriveno").val("")

    $("#praznaSlika").attr("src","")
    $("#obavestenjeunosProizvoda").html("")

    $("#nazivProizvoda").val("")
    $("#cenaProizoda").val("")
    $("#opisProizvoda").val("")
    $("#ddlMarka").val("0")
    $("#ddlKategorija").val("0")

    document.getElementById("chbAkcija").checked=false;
    document.getElementById("chbPreporuceno").checked=false;

    $("#original").val("")
    $("#nova").val("")
}

function dohvatiProizvod() {

    let id=$(this).data('id')

    $.ajax({
        url:"index.php?ajax=jedan-proizvod",
        dataType:"json",
        data:{
            "send":true,
            "id":id,
        },
        method:"get",
        success:function (data,status,xhr) {

                $("#nazivProizvoda").val(data.proizvodNaziv)
                $("#cenaProizoda").val(data.cena)
                $("#opisProizvoda").val(data.opis)
                $("#ddlMarka").val(data.idMarka)
                $("#ddlKategorija").val(data.idKategorija)
                $("#praznaSlika").attr("src","public/img/" + data.slikaNova)
                $("#skriveno").val(data.idProizvod)

                $("#original").val(data.slikaNova)
                $("#nova").val(data.slikaOriginal)

                $("#popust").hide()
                $("#popust").val("")


                document.getElementById("chbAkcija").checked=false;

                if(data.akcija==1){
                    document.getElementById("chbAkcija").checked=true;
                    $("#popust").val(data.popust)
                    $("#popust").slideDown()
                }


                document.getElementById("chbPreporuceno").checked=false;

                if(data.preporuceno==1){
                    document.getElementById("chbPreporuceno").checked=true;
                }

        },
        error:function (xhr,status,error) {
            alert(xhr.status)
        }
    })
}

function obrisiProizvod() {

    let id = $(this).data("id")
    console.log(id)
    let nova = $(this).data("nova")
    let original = $(this).data("original")

    $.ajax({
        url:"index.php?ajax=obrisi-proizvod",
        dataType:"json",
        data:{
            "send":true,
            "id":id,
            "nova":nova,
            "original":original
        },
        method:"post",
        success:function (data,status,xhr) {
            if(xhr.status===204){
                ucitajProizvodeZaAdmina($(".active").children().data('id'));
                obrisiSveIzFormeZaUnosProizvoda()
            }
        },
        error:function (xhr,status,error) {
            alert(xhr.status)
        }
    })

}

function ucitajProizvodeZaAdmina(id) {

    $.ajax({
        url:"index.php?ajax=svi-proizvodi-admin",
        dataType:"json",
        method:"get",
        data:{"id":id},
        success:function (data,status,xhr) {

            ispisiSveProizvodeZaAdmina(data);
            $(".obrisiProizvod").click(obrisiProizvod);
            $(".azurirajProizvod").click(dohvatiProizvod)

        },
        error:function (xhr,status,error) {
            console.log(xhr.status)
        }
    })
}

function ispisiSveProizvodeZaAdmina(data) {
    let ispis=`<thead>

            <tr>
                <th>ID</th>
                <th>Naziv Proizvoda</th>
                <th>Slika</th>
                <th>Cena (sa popustom)</th>
                <th>Ažuriraj</th>
                <th>Obriši</th>
            </tr>
            </thead>
            <tbody>`;

    for(let i of data){
        ispis+=`<tr>
                <td>${i.idProizvod}</td>
                <td>${i.proizvodNaziv}</td>
                <td><img src="public/img/${i.slikaNova}" width="90px" alt="${i.proizvodNaziv}"/></td>
                <td>`;

        let cena=0;
        if(i.akcija==1){
            cena=i.cena*(100-i.popust)/100;
        }
        else{
            cena=i.cena;
        }

        ispis+=`${cena} RSD</td>
                <td><button type="button" data-id="${i.idProizvod}" class="btn btn-primary azurirajProizvod">Ažuriraj</button></td>
                <td><button type="button" data-id="${i.idProizvod}" data-nova="${i.slikaNova}" data-original="${i.slikaOriginal}" class="btn btn-primary obrisiProizvod">Obrisi</button></td>
            </tr>`;
    }

    ispis+=`</tbody>`;

    $(".korpaTabela").html(ispis)

}

/*      Unos proizvoda admin - kraj     */