<?php

use iutnc\deefy\repository\DeefyRepository;
use iutnc\deefy\dispatch\Dispatcher;

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

require_once 'vendor/autoload.php';

session_start();
DeefyRepository::setConfig( 'Config.db.ini' );

if (isset($_GET[ 'action' ])){
    $action = $_GET[ 'action' ];
    $dispatch = new Dispatcher($action);
    $dispatch->run();
} else {
    $dispatch = new Dispatcher('default');
    $dispatch->run();
}

