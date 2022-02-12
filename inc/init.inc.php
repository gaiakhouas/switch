<?php
ini_set('display_errors',1);
session_start();
// token for treatment in ajax
$token = md5(rand(10000, 99999));
$_SESSION['token'] = $token;
// URL 
if ($_SERVER['SERVER_NAME'] == 'localhost') : $domain = $_SERVER['SERVER_NAME'] . ':81/switch/';
else : $domain = $_SERVER['SERVER_NAME'].'/switch/';
endif;
define('URL', 'https://' . $domain );
$_SESSION['URL'] = URL;
$mainCtrl = new Controller();
//spl_autoload_register(array('Controller', 'autoload'));
require('model/room/account.class.php');
require('model/room/room.class.php');
$room = new Room\Room();
// handle of signup
$signup = $room->signUp();
// handle of login
if ($signup == "ok" || isset($_POST["login"])) : $userInfo = $room->logIn($signup);
else : $userInfo = $room->logIn();
endif;
($userInfo != 0) ?  $_SESSION["userInfo"] = $userInfo : "";
// admin class instanciation
if ($room->getAccountName() == "admin") :
	require ('model/room/admin.class.php');
    $admin = new Room\Admin();
    $_SESSION['admin'] = true;
    if(isset($_GET['id'])): $_SESSION['id']=$_GET['id']; endif;
endif;
// automating logout function
$room->autoLogOut();


