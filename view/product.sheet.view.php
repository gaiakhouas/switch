<?php include_once('inc/header.inc.php'); ?>
<!-- html content of home page -->
<section class='container'>
    <br>
    <div class='row'>
        <div class="col-12">
            <h1 style="display:inline">
                <?= $room->getInfoTable('nom', 'produit', 'salle'); ?>
                <?= $room->getStars('produit.id_salle', 'produit', 'salle'); ?>
            </h1>
            <form method="post" action="inc/booking.handler.inc.php" style="display:inline;">
            <input type="hidden" name="idprod" value="<?= $_GET['id']; ?>">
           <?= $room->getBookBtn(); ?>
            </form>
            <hr>
        </div>
        <div class="xol-12 col-md-7">
            <img class="img-fluid animated fadeInLeft" src='src/img/<?= $room->getInfoTable('photo', 'produit', 'salle'); ?>'>
        </div>
        <div class="xol-12 col-md-5">
            <br>
            <p><b>Description</b></p>
            <p><?= $room->getInfoTable('description', 'produit', 'salle'); ?></p>
            <p><b>Localisation</b></p>
        </div>
        <div class="xol-12 col-md-12">
            <br>
            <p><b>Informations complémentaires</b></p>
            <div class="row">
                <div class="xol-12 col-md-4">
                    <p>
                        <span class="material-icons styled-colored-el" style="font-size:16px;">calendar_today</span>
                        Arrivée : <?= $room->dateChange($room->getInfoTable('date_arrivee', 'produit', 'salle'), "fr"); ?>
                    </p>
                    <p>
                        <span class="material-icons styled-colored-el" style="font-size:16px;">calendar_today</span>
                        Départ : <?= $room->dateChange($room->getInfoTable('date_depart', 'produit', 'salle'), "fr"); ?>
                    </p>
                </div>
                <div class="xol-12 col-md-4">
                    <p>
                        <span class="material-icons styled-colored-el" style="font-size:16px;">perm_identity</span>
                        Capacité : <?= $room->getInfoTable('capacite', 'produit', 'salle'); ?>
                    </p>
                    <p>
                        <span class="material-icons" style="font-size:16px;">category</span>
                        Catégorie : <?= $room->getInfoTable('categorie', 'produit', 'salle'); ?>
                    </p>
                </div>
                <div class="xol-12 col-md-4">
                    <p>
                        <span class="material-icons" style="font-size:16px;">location_on</span>
                        Adresse : <?= $room->getInfoTable('adresse', 'produit', 'salle'); ?>
                    </p>
                    <p>
                        <span class="material-icons" style="font-size:16px;">euro_symbol</span>
                        Tarif : <?= $room->getInfoTable('prix', 'produit', 'salle'); ?> €
                    </p>
                </div>
            </div>
        </div>
        <div class="xol-12 col-md-12">
            <br>
            <h2>Autres produits</h2>
            <hr>
            <div class="row">
                <?= $room->getOtherProducts('photo', 'produit', 'salle', 'img'); ?>
            </div>
            <hr>
        </div>
        <div class="xol-12 col-md-12">
            <br>
            <h2>Commentaires</h2>
            <hr>
            <a href="index.php?action=note&id=<?= $_GET['id'] ?>" class='btn btn-primary'>
                <span class="material-icons">post_add</span>Déposer un commentaire et une note
            </a>
            <span style="float:right;"><a href="index.php?action=searchroom">Retour au catalogue</a></span>
        </div>
    </div>
    </div>
</section>
<?php include_once('inc/footer.inc.php'); ?>