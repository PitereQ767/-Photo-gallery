<?php 

include_once '../database.php';
function register(&$model){
    if($_SERVER['REQUEST_METHOD'] === 'POST'){
        $email = trim($_POST['email']);
        $username = trim($_POST['username']);
        $password = trim($_POST['password']);
        $confirm_password = trim($_POST['confirm_password']);

        if (empty($email) || empty($username) || empty($password) || empty($confirm_password)){
            $model['error'] = "Wszystkie pola są obowiązkowe.";
        }elseif(!filter_var($email, FILTER_VALIDATE_EMAIL)){
            $model['error'] = "Nieprawidłowy adres email.";
        }elseif($password !== $confirm_password){
            $model['error'] = "Hasła nie pasują do siebie.";
        }else {
            add_user($model, $username, $password, $email);
        }
    }

    return 'register_view';
}