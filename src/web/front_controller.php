<?php
require '../../vendor/autoload.php';


require_once '../dispatcher.php';
require_once '../routing.php';
require_once '../controllers.php';
require_once '../controllers/upload.php';
require_once '../controllers/login.php';
require_once '../controllers/register.php';

session_start();

$action_url = isset($_GET['action']) ? $_GET['action'] : '/';

dispatch($routing, $action_url);