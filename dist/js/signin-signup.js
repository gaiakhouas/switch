$(document).ready(function() {
    $("body").delegate("#signup", "click", function() {
        var back = "<p style='padding-left:0px!important; margin-left:0px; text-align:left'><button type='button' id='signin'  style='padding-left:0px!important; margin-left:0px;' class='link-icon back-signin signin' ><span class='material-icons' style='width: 25px;' >arrow_left_alt</span><span style='margin-left:5px'>RETOUR</span></button></p>";
        var header = "<p class='modal-title adaptMe'><b>Je m'inscris</b></p>";
        var formInfo = "<p class='adaptMe' >Veuillez renseigner les champs ci-dessous : </p>";
        var form = "<form method='POST'>";
        form += "<select class='form-control' name='sexe' id='sexe' >";
        form += "<option value=''>Civilité</option>";
        form += "<option value='m'>m</option>";
        form += "<option value='f'>f</option>";
        form += "</select>";
        form += "<div class='placeholder-focus' data-placeholder='Pseudo'>";
        form += "<input type='text' class='input-form' required  name='pseudo' id='pseudo'   maxlength='50' >";
        form += "</div>";
        form += "<span class='help-input hidden' id='help-pseudo'>Aide &agrave; la saisie</span>";
        form += "<div class='placeholder-focus' data-placeholder='Adresse email'>";
        form += "<input type='email' class='input-form' required  name='email' id='email'  pattern='[a-z0-9._%+-]+@[a-z0-9.-]+\\.[a-z]{2,}$'  maxlength='50' >";
        form += "</div>";
        form += "<span class='help-input hidden' id='help-email'>Aide &agrave; la saisie</span>";
        form += "<div class='placeholder-focus' data-placeholder='Mot de passe'>";
        form += "<input type='password' class='input-form' required name='password' id='password' maxlength='128'  >";
        form += "</div>";
        form += "<span class='help-input hidden' id='help-pass'>Aide &agrave; la saisie</span>";
        form += "<div class='placeholder-focus' data-placeholder='Nom'>";
        form += "<input type='text' class='input-form' required  name='lastName' id='lastName'  maxlength='50' >";
        form += "</div>";
        form += "<span class='help-input hidden' id='help-lastname'>Aide &agrave; la saisie</span>";
        form += "<div class='placeholder-focus' data-placeholder='Prénom'>";
        form += "<input type='text' class='input-form' required  name='firstName' id='firstName'  maxlength='50' >";
        form += "</div>";
        form += "<span class='help-input hidden'  id='help-firstname'>Aide &agrave; la saisie</span><br>";
        form += "<button class='btn btn-primary form-control' id='subscribe' name='signup' type='button'  >M'inscrire</button><br><br>";
        form += "<p class='text-form'>Vous avez déjà un compte ? <button type='button' class='customed-link signin' href='#'>Se connecter</button></p></form>";
        var token = $('#token').val();
        var signup = "";
        $("body").delegate("#email, #pseudo, #password, #firstName, #lastName, #management, #subscribe", "keyup change focus", function checkForm() {

        });


        $(".header-sign").html(back + header);
        $(".sign-form").html(formInfo + form);
        $('.adaptMe').addClass('animated fadeInLeft');
    });

    $("body").delegate("#signin, .signin", "click", function() {
        var header = "<p class='modal-title adaptMe'><b>Je me connecte</b></p>";
        var formInfo = "<p class='adaptMe'>Veuillez saisir ci-dessous votre identifiant de connexion et mot de passe pour vous connecter : </p>";
        var form = "<form method='POST'>";
        form += " <div class='placeholder-focus' data-placeholder='Email ou pseudo'>";
        form += "<input type='text' class='input-form' name='email' id='emailLog'  maxlength='50' >";
        form += "</div>";
        form += "<span class='help-input hidden' id='help-email'>Aide &agrave; la saisie</span>";
        form += "<div class='placeholder-focus' data-placeholder='Mot de passe'>";
        form += "<input type='password' class='input-form' name='password' id='passLog' maxlength='128'  >";
        form += "</div>";
        form += "<span class='help-input hidden' id='help-pass'>Aide &agrave; la saisie</span><br>";
        form += "<button class='btn btn-primary form-control' id='login' name='login'  type='button'>Me connecter</button><br><br>";
        form += "<span class='help-input error-input hidden' id='help-login'>Adresse mail/pseudo et/ou mot de passe incorrect</span>";
        form += "<p class='text-form'>Mot de passe oublié ? <a href='#' class='customed-link'>Cliquez-ici</a><br>Pas encore de compte ? <button type='button' class='customed-link signup' id='signup' >Créer un compte</button></p></form>";
        $(".header-sign").html(header);
        $(".sign-form").html(formInfo + form);
        $('.adaptMe').addClass('animated fadeInLeft');
    });
});