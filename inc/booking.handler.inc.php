<?php
session_start();
require_once('../model/room/account.class.php');
require_once('../model/room/room.class.php');
if ($_POST) :
    if (isset($_POST['book'])) :
        $booking = new room\room();
        $check = $booking->checkProduct('produit', $_POST['idprod']);
        if ($check) :
            $booking->executeQuery("INSERT INTO commande(id_membre, id_produit, date_enregistrement) 
        VALUES('" . $_SESSION["userInfo"]['id_membre'] . "', '" . $_POST['idprod'] . "', NOW() ) ");
            $booking->executeQuery("UPDATE produit SET etat='reservation' WHERE id_produit='" . $_POST['idprod'] . "'");
        header('Location:../index.php?action=reservation&id='.$_POST['idprod'].'');
        endif;
    endif;
else :
    header('Location:../index.php');
endif;
