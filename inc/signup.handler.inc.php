<?php
session_start();
require_once('../model/room/account.class.php');
require_once('../model/room/room.class.php');
$room = new Room\Room();
    extract($_POST);
    $content = '';

// focus on email input for signing Up :
    if (isset($_POST["email"])) :
        // check if the email address exists inside contacts table
        $data = $room->checkEmailPseudo($_POST["email"]);
        echo json_encode($data);
    endif;
    if (isset($_POST["pseudo"])) :
        // check if the email address exists inside contacts table
        $data = $room->checkEmailPseudo($_POST["pseudo"]);
        echo json_encode($data);
    endif;

