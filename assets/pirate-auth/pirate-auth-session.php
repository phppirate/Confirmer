<?php
/**
 * Created by PhpStorm.
 * User: sam
 * Date: 10/31/14
 * Time: 11:43 PM
 */

session_start();

function pirate_auth_logged_in(){
    global $pirate_auth_config;
    if (isset($_SESSION[$pirate_auth_config['login_key']]) && isset($_SESSION[$pirate_auth_config['login_key'] . '-' . 'user_id'])){
        return true;
    } else {
        return false;
    }
}

function confirm_pirate_auth_login(){
    if (!pirate_auth_logged_in()){
        header("Location: login.php");
        exit;
    }
}
