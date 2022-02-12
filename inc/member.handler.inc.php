<?php
session_start();
require_once('../model/room/account.class.php');
require_once('../model/room/room.class.php');
$room = new Room\Room();
if ($room->secureAjaxCall('membre')):
    extract($_POST);
    $content = '';
    require_once('../model/room/admin.class.php');
    $admin = new room\Admin();
    if($action=='save'):
    $content = $admin->insertNewData('membre');
    endif;
    if($action=='update'):
        $content = $admin->updateData('membre');
    endif;
    if($action=='delete'):
        $content = $admin->deleteData('membre');
    endif;
    if($action=='confirm'):
        $content = $admin->deleteData('membre');
    endif;
    echo json_encode($content);
else:
   header("Location:../index.php");
endif;
