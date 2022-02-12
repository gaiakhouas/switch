<?php 
session_start();
require_once('../model/room/account.class.php');
require_once('../model/room/room.class.php');
if($_POST):
    extract($_POST);
    if(isset($sendMsg)):
        if(!empty($lastname) && !empty($firstname) && !empty($msg)):
            $contact= new room\room();
            $contact->secureData();
            $contact->contact($_POST['lastname'], $_POST['firstname'], $_POST['msg']);
            header("Location:../index.php?action=contact&statut=ok&lastname=$lastname&firstname=$firstname&msg=$msg");
        else:
            header("Location:../index.php?action=contact&statut=error&lastname=$lastname&firstname=$firstname&msg=$msg");
        endif;
    endif;
endif;