<?php
session_start();
//login handler : 
if (!empty($_SERVER['HTTP_REFERER'])) :
    if ($_SERVER['SERVER_NAME'] == 'localhost' ||  $_SERVER['SERVER_NAME'] == 'gaia-kh.com') :
        require_once('../model/room/account.class.php');
        // focus on signing Up btn : 
        if (isset($_POST["emailC"]) && isset($_POST["passC"])):
            if (!empty($_POST["emailC"])) :
                $email_pseudo = htmlspecialchars($_POST["emailC"]);
                $password = "";
                if (!empty($_POST["passC"])) :
                    $password = sha1($_POST["passC"]);
                endif;
                $checkIn=new Room\Account();
                // check if the email address exists inside membre table
                $data = $checkIn->checkEmailPseudo($email_pseudo, $password);
            else : $data = 0;
            endif;
            echo json_encode($data);
        endif;
    endif;
endif;
