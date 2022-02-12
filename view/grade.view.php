<?php include_once('inc/header.inc.php'); ?>
<!-- html content of home page -->
<section class='container'>
    <br>
    <div class='row'>
        <div class="col-12" style="text-align:center">
            <h1 class="animated fadeInDown">Noter votre salle !</h1>
            <br><br>
        </div>
        <div class="xol-12 col-md-4" style="text-align:center">
            <img class="img-fluid animated fadeInLeft" src='src/img/<?= $room->getInfoTable('photo', 'produit', 'salle'); ?>'>
        </div>
        <div class="col-12 col-md-8" style="text-align:center">
            <form method="post" action="inc/grade.handler.inc.php">
                <label>Evaluez votre expérience</label>
                <br><br>
                <div id="slider-range2"></div>
                <input type="text" name="costText" id="gradeText" readonly style="border:0; font-size:12px; width:100%">
                <input type="hidden" name="grade" id="grade">
                <label>Ajoutez un commentaire :</label>
                <br><br>
                <textarea class="form-control" name="post" placeholder="Ecrivez quelque chose"></textarea>
                <br>
                <input type="hidden" name="idprod" id="idprod" value="<?= $_GET['id']; ?>">
                <?= $room->getMyBtn('addGrade', 'Envoyer la note') ?>
                <?php if (isset($_GET['statut']) && $_GET['statut'] == 'error') : ?>
                    <br><br>
                    <p class="alert-danger animated fadeInDown">Vous avez déjà donné votre avis pour cette salle !</p>
                <?php endif; ?>
            </form>
        </div>
        <div class="col-12" style="text-align:center">
            <br>
            <a href="index.php?action=ficheproduit&id=<?= $_GET['id']; ?>">Revenir à ma salle</a>
        </div>
    </div>
</section>
<?php include_once('inc/footer.inc.php'); ?>