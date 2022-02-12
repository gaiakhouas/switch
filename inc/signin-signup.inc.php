<!-- modal de connexion -->
<div class="container">
    <div class="text-center">
        <div class="modal right animated fadeInRight faster" id="signIn" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document" id="signModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="header-sign">
                            <p class="modal-title adaptMe"><b>Je me connecte</b></p>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body" id="body-sign">
                        <div class="sign-form">
                            <p>Veuillez saisir ci-dessous votre identifiant de connexion et mot de passe pour vous connecter : </p>
                            <form method="POST">
                                <div class="placeholder-focus" data-placeholder="Email ou pseudo">
                                    <input type="text" class="input-form" id="emailLog" name="email" maxlength="50">
                                </div>
                                <span class='help-input hidden' id='help-email'>Aide &agrave; la saisie</span>
                                <div class="placeholder-focus" data-placeholder="Mot de passe">
                                    <input type="password"  name="password" id="passLog" class="input-form" maxlength="128">
                                </div>
                                <span class="help-input hidden" id="help-pass">Aide &agrave; la saisie</span>
                                <br>
                                <button class="btn btn-primary form-control" id="login" name="login" type='button' >Me connecter</button>
                                <br>
                                <p class="text-form">Mot de passe oublié ? <a href="#" class="customed-link">Cliquez-ici</a><br>
                                    Pas encore de compte ? <button type="button" id="signup" class="signup" >Créer un compte</button></p>
                            </form>
                        </div>
                    </div>
                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- modal -->
    </div>
</div>