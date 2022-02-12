<?php
session_start();
require_once('../model/room/account.class.php');
require_once('../model/room/room.class.php');
$room = new Room\Room();
if ($room->secureAjaxCall('salle')):
    extract($_POST);
    $content = '';
    require_once('../model/room/admin.class.php');
    $admin = new room\Admin();
    if($action=='save'):
    $content = $admin->insertNewData('salle');
    endif;
    if($action=='update'):
        $content = $admin->updateData('salle');
    endif;
    if($action=='delete'):
        $content = $admin->deleteData('salle');
    endif;
    if($action=='confirm'):
        $content = $admin->deleteData('salle');
    endif;
    echo json_encode($content);
else:
   header("Location:../index.php");
endif;
