<!-- modal de connexion -->
<div class="container">
    <div class="text-center">
        <div class="modal right animated fadeInRight faster" id="account" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
            <div class="modal-dialog" role="document" id="signModal">
                <div class="modal-content">
                    <div class="modal-header">
                        <div class="header-sign">
                            <p class="modal-title adaptMe"><b>Mon compte</b></p>
                        </div>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <div class="modal-body" id="body-sign">
                        <div>
                            <p>Gérer votre compte en séléctionnant l'une des actions ci-dessous : </p>
                            <form method="POST" action="inc/logout.inc.php">
                                <button class="btn btn-primary" name="logout" type='submit' >Me déconnecter</button>
                            </form>
                        </div>
                    </div>
                </div><!-- modal-content -->
            </div><!-- modal-dialog -->
        </div><!-- modal -->
    </div>
</div>