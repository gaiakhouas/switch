<?php
session_start();
require_once('../model/room/account.class.php');
require_once('../model/room/room.class.php');
$product = new Room\Room();
if ($product->secureAjaxCall('commande')):
    extract($_POST);
    $content = '';
    require_once('../model/room/admin.class.php');
    $admin = new room\Admin();
    if($action=='save'):
    $content = $admin->insertNewData('commande');
    endif;
    if($action=='update'):
        $content = $admin->updateData('commande');
    endif;
    if($action=='delete'):
        $content = $admin->deleteData('commande');
    endif;
    if($action=='confirm'):
        $content = $admin->deleteData('commande');
    endif;
    echo json_encode($content);
else:
   header("Location:../index.php");
endif;
