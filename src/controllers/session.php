<?php


function is_logged_in(){
    return isset($_SESSION['user_id']);
}

function logout(){
    session_destroy();
    header('Location: login.php');
    exit;
}

function remember_selected(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selected_images'])){
        $selected_images = $_POST['selected_images'];

        if(!isset($_SESSION['remembered'])){
            $_SESSION['remembered'] = [];
        }

        $_SESSION['remembered'] = array_unique(array_merge($_SESSION['remembered'], $selected_images));

    }

    header('Location: /gallery.php');
}

function remove_remembered(){
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['remove_images'])){
        $remove_images = $_POST['remove_images'];

        if (isset($_SESSION['remembered'])){
            $_SESSION['remembered'] = array_diff($_SESSION['remembered'], $remove_images);
        }
    }

    header('Location: /remembered_gallery.php');
    exit;
}
