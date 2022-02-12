<?php
session_start();
require_once('../model/room/account.class.php');
require_once('../model/room/room.class.php');
if ($_POST) :
    if (isset($_POST['addGrade'])) :
        $grade = new room\room();
        $grade->secureData();
        $check = $grade->checkPost('avis', $_POST['idprod'],  $_SESSION["userInfo"]['id_membre']);
        if ($check) :
            ($_POST['grade']==0) ? $gradeVal=0 : $gradeVal=$_POST['grade'];
     
          // insert
          $insert=$grade->executeQuery(
              "INSERT INTO avis(id_membre, id_salle, commentaire, note, date_enregistrement) 
              VALUES(
                  '".$_SESSION["userInfo"]['id_membre']."', 
                  '".$grade->getRoomId($_POST['idprod'])."',
                  '".$_POST['post']."', 
                  '".$gradeVal."', 
                  NOW()
                  )
              ");
               header('Location:../index.php?action=message&id='.$_POST['idprod'].'');
        else:
            header('Location:../index.php?action=note&id='.$_POST['idprod'].'&statut=error');
        endif;
    endif;
else :
    header('Location:../index.php');
endif;
