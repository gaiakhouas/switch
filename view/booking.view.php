<?php include_once('inc/header.inc.php'); ?>
<!-- html content of home page -->
<section class='container'>
    <br>
    <div class='row'>
        <div class="col-12" style="text-align:center">
            <h1 class="animated fadeInDown">Votre salle a été réservée avec succès ! </h1>
            <br>
        </div>
        <div class="col-12" style="text-align:center">
            <img class='img-fluid animated fadeIn' style='max-width:50%; border-radius:250px;' src='src/img/success-order.jpg'>
        </div>
        <div class="col-12" style="text-align:center">
        <br>
            <a href="index.php?action=ficheproduit&id=<?= $_GET['id']; ?>">Revenir à ma salle</a>
        </div>
    </div>
</section>
<?php include_once('inc/footer.inc.php'); ?>