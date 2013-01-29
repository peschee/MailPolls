<?php

function getHash($value1, $value2){
    $string = $value1.'.'.$value2;
    $hash = hash('sha256', $string);
    $hash = substr($hash, 0, 15);

    return $hash;
}

function createOptionLink($optionId, $pollId){

    $params = array(
        'o' => $optionId,
        's' => getHash($optionId, $pollId),
    );

    $link = 'http://'.$_SERVER['SERVER_NAME'].'/'. BASE_DIR . '?'. http_build_query($params);

    return $link;
}