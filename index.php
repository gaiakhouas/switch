<?php
// rooter
require_once('controller/controller.php');
require_once('inc/init.inc.php');
if (!isset($_GET['action'])) :
    if (!isset($_SESSION['admin'])):
        require_once('view/home.view.php');
    else:
        require_once('view/admin.view.php');
    endif;
else :
    if ($_GET['action'] == 'contact') : require_once('view/contact.view.php'); endif;
    if ($_GET['action'] == 'searchroom') : require_once('view/home.view.php'); endif;
    if ($_GET['action'] == 'ficheproduit') : require_once('view/product.sheet.view.php');  endif;
    if ($_GET['action'] == 'reservation') : require_once('view/booking.view.php'); endif;
    if ($_GET['action'] == 'note') : require_once('view/grade.view.php'); endif;
    if ($_GET['action'] == 'message') : require_once('view/message.view.php'); endif;
endif;
if (isset($_SESSION['admin'])) :
    if (isset($_GET['action'])) :
        if ($_GET['action'] == 'salle') : require_once('view/room.view.php'); endif;
        if ($_GET['action'] == 'produit') : require_once('view/product.view.php'); endif;
        if ($_GET['action'] == 'membre') : require_once('view/member.view.php');  endif;
        if ($_GET['action'] == 'avis') : require_once('view/post.view.php');  endif;
        if ($_GET['action'] == 'commande') : require_once('view/order.view.php');  endif;
        if ($_GET['action'] == 'ficheproduit') : require_once('view/product.sheet.view.php');  endif;
        if ($_GET['action'] == 'stats') : require_once('view/stats.view.php'); endif;
    endif;
endif;
