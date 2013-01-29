<?php

include('../includes/init.php');

//Get poll info
$query = ' SELECT * FROM polls WHERE id = '.intval($_GET['id']);
if(!$result = $mysqli->query($query)){
    die('Could not execute query: '. $mysqli->error);
}

if($result->num_rows != 1){
    header('location:index.php');
    exit;
}
$poll = $result->fetch_assoc();

//Get options and results
$query = '
    SELECT
    options.id,
    options.poll_id,
    options.name,
    COUNT(votes.id) as votes

    FROM
    (polls,
    options)

    LEFT JOIN
    (votes) on (votes.option_id = options.id)

    WHERE
    options.poll_id = polls.id and
    polls.id = '.intval($_GET['id']).'

    GROUP BY
    options.id

    ORDER BY
    votes DESC
';

if(!$result = $mysqli->query($query)){
    die('Could not execute query: '. $mysqli->error);
}

$options = array();
$totalVotes = 0;

while($option = $result->fetch_assoc()){
    $option['link'] = createOptionLink($option['id'], $option['poll_id']);
    $totalVotes += $option['votes'];
    array_push($options, $option);
}


//Render view
$template = $twig->loadTemplate('poll.html.twig');
echo $template->render(array(
    'options'    => $options,
    'poll'       => $poll,
    'totalVotes' => $totalVotes,
));