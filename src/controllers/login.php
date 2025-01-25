<?php

include_once '../database.php';
include_once 'session.php';

function login(&$model){
    if (is_logged_in()){
        return 'welcome_view';

    }

    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        
        if (check_login($model, $username, $password)){
            return 'welcome_view';
        }

    }
    return 'login_view';
}