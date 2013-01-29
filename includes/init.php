<?php

include('config.php');
include('functions.php');

//Set root directory
define('ROOT_DIR', dirname(__FILE__).'/../');

//Create database connection
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
if ($mysqli->connect_error) {
    die('Connect Error (' . $mysqli->connect_errno . ') '
        . $mysqli->connect_error);
}
$mysqli->set_charset("utf8");

//Init Twig template engine
require_once ROOT_DIR.'vendors/Twig/Autoloader.php';
Twig_Autoloader::register();
$loader = new Twig_Loader_Filesystem(ROOT_DIR.'backend/templates');
$twig = new Twig_Environment($loader);