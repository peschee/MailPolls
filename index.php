<?php

/**
 * Handle incoming links
 */

include('includes/init.php');

//Check required parameters
$requiredParams = array('o', 's');
foreach($requiredParams as $param) {
    if (!isset($_GET[$param])) {
        die('Missing parameter: '. $param);
    }
}

//Get option data from database
$query ='SELECT * FROM '.TABLES_PREFIX.'options WHERE options.id = ' . intval($_GET['o']);
if(!$result = $mysqli->query($query)){
    die('Could not execute query: '. $mysqli->error);
}

if($result->num_rows != 1){
    die('Invalid call.');
}
$optionData = $result->fetch_assoc();

//Check hash
$hash = getHash($optionData['id'], $optionData['poll_id']);
if($hash != $_GET['s']){
    header('location:'.$optionData['forward_error']);
    exit;
}

//Already voted?
if(isset($_COOKIE[COOKIES_PREFIX.$hash])){
    header('location:'.$optionData['forward_already_voted']);
    exit;
}

//Save vote to database
$query = sprintf(
    'INSERT INTO '.TABLES_PREFIX.'votes (option_id, datetime, ip) VALUES (%s, "%s", "%s")',
        intval($_GET['o']),
        date('Y-m-d h:i:s'),
        $_SERVER['REMOTE_ADDR']
    );

if(!$mysqli->query($query)){
    header('location:'.$optionData['forward_error']);
    exit;
}

//Set cookie
setcookie(COOKIES_PREFIX.$hash, true, time() + (COOKIES_EXPIRATION_IN_DAYS * 24 * 60 * 60));

//Forward
header('location:'.$optionData['forward_success']);
exit;

