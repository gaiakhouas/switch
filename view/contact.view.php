<?php include_once('inc/header.inc.php'); ?>
<!-- html content of home page -->
<section class='container'>
    <br>
    <div class='row'>
        <div class="col-12" style="text-align:center">
            <h1 class="animated fadeInDown">Contactez-nous</h1>
            <br><br>
        </div>
        <div class="col-12 col-md-3"></div>
        <div class="col-12 col-md-6" style="text-align:left">
            <?php if (isset($_GET['statut'])) :
            ?>
                <div class="col-12 animated fadeInDown" style="text-align:center ">
                    <?php
                    if ($_GET['statut'] == 'error') : ?>
                        <span class='alert-danger' style="padding:10px; text-align:center; ">Veuillez remplir tous les champs demandés</span>
                    <?php
                    elseif ($_GET['statut'] == 'ok') : ?>
                        <span class='alert-success' style="padding:10px; text-align:center; ">Votre message a bien été envoyé.</span>
                    <?php endif; ?>
                </div>
            <?php
            endif; ?>
            <form method="post" action="inc/contact.handler.php">
                <label>Nom</label>
                <input class='form-control' type="text" name="lastname" placeholder="Nom" value="<?= (isset($_GET['lastname']) ? $_GET['lastname'] : '')  ?>">
                <label>Prénom</label>
                <input class='form-control' type="text" name="firstname" placeholder="Prénom" value="<?= (isset($_GET['firstname']) ? $_GET['firstname'] : '')  ?>">
                <label>Message</label>
                <textarea class='form-control' name="msg" placeholder="Ajouter un message"><?= (isset($_GET['msg']) ? $_GET['msg'] : '')  ?></textarea>
                <br><br>
                <div class="col-12" style="text-align:center">
                    <button class='btn btn-primary' type="submit" name="sendMsg">Envoyer le message</button>
                </div>
            </form>
        </div>
        <div class="col-12 col-md-3"></div>
    </div>
</section>
<?php include_once('inc/footer.inc.php'); ?>