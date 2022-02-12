<?php

use Docs\Account;

session_start();

/**
 * http_referer 
 * local : http://localhost:81/eureka/search-doc.php
 * Prod : to define
 * 
 */
if (!empty($_SERVER['HTTP_REFERER'])) :
    if (
        $_SERVER['HTTP_REFERER'] == "http://localhost:81/switch/"
        || $_SERVER['HTTP_REFERER'] == "http://localhost:81/switch/index.php"
    ):
        require_once('../model/account.class.php');
        $clientSearch = new Account();
        // Search doc case : 

        endif;
    endif;

