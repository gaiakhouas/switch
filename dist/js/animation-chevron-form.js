$(document).ready(function() {
    // on fait execute l'animation après une seconde
    setInterval(function() {
        $('.expandIco').addClass('fadeInDown faste');
        $('.expandIco').removeClass('fadeOutUp');
    }, 1000);

    setInterval(function() {
        $('.expandIco').removeClass('fadeInDown');
        $('.expandIco').addClass('fadeOutUp');
    }, 2000);

    // function click sur le chevron

    $('.expandBtn, .expandIco').click(function() {

        $('.expandBtn').addClass("hidden");
        $('.expanded-criterias').addClass("show animated fadeIn");
        $('.labelFunction').addClass("hidden");
    });

    $('.dropdown-menu').click(function(e) {
        e.stopPropagation();
    });

    // fonction jquery click on 


});