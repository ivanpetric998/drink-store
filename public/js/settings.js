var mreze=[
    {"url":"https://sr-rs.facebook.com/", "class":"fa-facebook"},
    {"url":"https://twitter.com/", "class":"fa-twitter"},
    {"url":"https://www.instagram.com", "class":"fa-instagram"},
    {"url":"https://accounts.google.com", "class":"fa-google-plus"},
    {"url":"https://www.youtube.com/", "class":"fa-youtube"},
]

$(document).ready(function () {

    ispisiDrustveneMreze();

    $("#logReg").click(function () {
        $("#divRegLog").show();
    })

    $("#close").click(function () {
        $("#divRegLog").hide();
    })

    $(".search").mouseenter(function(){
        $(this).css("background-color","#005aa9")
        $(this).css("color","#fff")
    })
    $(".search").mouseleave(function(){
        $(this).css("background-color","#fff")
        $(this).css("color","#005aa9")
    })

    $(document).on("mouseenter",".clanak",function () {
        $(this).children().find(".clanakLinija").addClass("crvenaLinija")
    })

    $(document).on("mouseleave",".clanak",function () {
        $(this).children().find(".clanakLinija").removeClass("crvenaLinija")
    })

    $("#korpa").mouseenter(function () {
        $("#ikonica").css("color","#005aa9")
    })

    $("#korpa").mouseleave(function () {
        $("#ikonica").css("color","red")
    })

})

function ispisiDrustveneMreze() {
    let ispis="<ul>";

    for(let i of mreze){
        ispis+=`<li><a target="_blank" href="${i.url}"><i class="fa ${i.class}"></i></a></li>`;
    }
    ispis+="</ul>"

    $(".social").html(ispis)
}