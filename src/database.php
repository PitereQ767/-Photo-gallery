<?php 

require '../../vendor/autoload.php';

use MongoDB\BSON\ObjectID;

function get_db(){
    $mongo = new MongoDB\Client(
        "mongodb://localhost:27017/wai",
        [
            'username' => 'wai_web',
            'password' => 'w@i_w3b',
        ]);
    $db = $mongo->wai;

    return $db;

}

function add_document(&$model, $title, $author, $image_name, $watermarked_name, $thumbnail_name, $visibility){
    $db = get_db();
    if($db){
        $document = [
            'title' => $title,
            'author' => $author,
            'image' => $image_name,
            'watermarked' => $watermarked_name,
            'thumbnail' => $thumbnail_name,
            'visibility' => $visibility
        ];
        
        $collection = $db->images;
        $collection -> insertOne($document);
    }else{
        $model['error'] = "Błąd połączenia z bazą danych";
    }
}

function show_gallery(&$model){
    $db = get_db();

    if (!$db){
        $model['error'] = "Błąd połączenia z bazą";
        return 'gallery_view';
    }

    $collection = $db -> images;


    if(isset($_SESSION['username'])){
        $filter['$or'] = [
            ['visibility' => 'public'],
            ['visibility' => 'private', 'author' => $_SESSION['username']]
        ];
    }else{
        $filter = ['visibility' => 'public'];
    }

    $documents = $collection->find($filter);
    $model['images'] = iterator_to_array($documents);

    return 'gallery_view';
}

function show_remembered_gallery(&$model){
    if (!isset($_SESSION['remembered']) || empty($_SESSION['remembered'])){
        $model['error'] = "Nie zapamiętano żadnych zdjęć";
        return 'remembered_gallery_view';
    }

    $db = get_db();
    $collection = $db->images;

    $remembered_id = [];

    foreach($_SESSION['remembered'] as $id){
        $remembered_id[] = new ObjectID($id);
    }

    $documents = $collection->find(['_id' => ['$in' => $remembered_id]]);
    $model['remembered_images'] = iterator_to_array($documents);
    return 'remembered_gallery_view';
}

function add_user(&$model, $username, $password, $email){
    $db = get_db();
    $users = $db->users;

    $existing_user = $users->findOne(['username' => $username]);

    if($existing_user){
        $model['error'] = "Ten login jest już zajęty.";
    }else{
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $users->insertOne([
            'email' => $email,
            'username' => $username,
            'password' => $hashed_password
        ]);

        $model['success'] = "Rejstracja zakończona pomyślnie. Możesz się zalogować.";
    }
}

function check_login(&$model, $username, $password){
    $db = get_db();
    $users = $db->users;
    $user = $users->findOne(['username' => $username]);

    if ($user && password_verify($password, $user['password'])){
        $_SESSION['user_id'] = (string)$user['_id'];
        $_SESSION['username'] = $user['username'];
        
        return true;
    }else{
        $model['error'] = "Nieprawidłowy login lub hasło.";
        return false;
    }
}


