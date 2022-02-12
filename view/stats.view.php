<?php include_once('inc/header.inc.php'); ?>
<!-- html content of home page -->
<section class='container'>
    <br>
    <div class='row'>
        <div class="col-12">
            <h1>Statistiques</h1>
            <p>Vous trouverez ci-dessous l'ensemble des statistiques réalisées côté client : </p>
            <br>
        </div>
        <div class="col-12 col-md-6">
            <p><b>Top 5 des salles les mieux notées</b></p>
            <div class="animated fadeIn" style="background-color:grey; color:white; padding :20px;margin:20px; border-radius:4px;">
                <?= $admin->getTop5BestRate(); ?>
            </div>


        </div>
        <div class="col-12 col-md-6">
            <p><b>Top 5 des salles les mieux commandées</b></p>
            <div class="animated fadeIn" style="background-color:#31d32e; color:white; padding :20px;margin:20px; border-radius:4px;">
            <?= $admin->getTop5Order(); ?>
            </div>
        </div>
        <div class="col-12">
        </div>
        <div class="col-12 col-md-6">
            <p><b>Top 5 des membre qui achètent le plus (en termes de quantité)</b></p>
            <div class="animated fadeIn" style="background-color:#07c1ff; color:white; padding :20px;margin:20px; border-radius:4px;">
            <?= $admin->getTop5Orders(); ?>
            </div>
        </div>
        <div class="col-12 col-md-6">
            <p><b>Top 5 des membres qui achètent le plus cher (en termes de prix)</b></p>
            <div class="animated fadeIn" style="background-color:#fc4646; color:white; padding :20px;margin:20px; border-radius:4px;">
            <?= $admin->getTop5Buyers(); ?>
        </div>
        </div>
    </div>
</section>
<?php include_once('inc/footer.inc.php'); ?>