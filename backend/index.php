<?php

include('../includes/init.php');

//Get polls
$query = '
    SELECT
    polls.id,
    polls.name,
    COUNT(votes.id) as votes

    FROM
    (polls,
    options)

    LEFT JOIN
    (votes) on (votes.option_id = options.id)

    WHERE
    options.poll_id = polls.id

    GROUP BY
    polls.id

    ORDER BY
    polls.id DESC
   ';

if(!$result = $mysqli->query($query)){
    die('Could not execute query: '. $mysqli->error);
}

$polls = array();
while($poll = $result->fetch_assoc()){
    array_push($polls, $poll);
}

//Render view
$template = $twig->loadTemplate('polls.html.twig');
echo $template->render(array(
    'polls' => $polls,
));