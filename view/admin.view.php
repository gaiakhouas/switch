<?php include_once('inc/header.inc.php'); ?>
<!-- html content of home page -->
<section class='container'>
    <br>
        <div class="col-12"> 
            <h1>Bienvenue sur le back-office</h1>      
        </div>
        <div class="col-12"> 
            <br>
            <h3>Que souhaitez-vous faire ?</h3>  
        </div>
        <div class="col-12 animated fadeInRight"> 
            <br>
            <p><a href="index.php?action=salle">Gérer les salles</a></p>    
            <p><a href="index.php?action=produit">Gérer les produits</a></p>   
            <p><a href="index.php?action=membre">Gérer les membres</a></p>  
            <p><a href="index.php?action=avis">Gérer les avis</a></p>  
            <p><a href="index.php?action=commande">Gérer les commandes</a></p>  
            <p><a href="index.php?action=stats">Voir les statistiques</a></p>  
        </div>
</section>
<?php include_once('inc/footer.inc.php'); ?>