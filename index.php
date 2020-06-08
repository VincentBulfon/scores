<?php
define('TODAY', (new DateTime('now', new DateTimeZone('Europe/Brussels')))->format('M jS, Y'));
define('FILE_PATH', 'matches.csv');
$matches = [];
$standings = [];
$teams = [];

function getEmptyStatsArray()
{
    return [
        'games' => 0,
        'points' => 0,
        'wins' => 0,
        'losses' => 0,
        'draws' => 0,
        'GF' => 0,
        'GA' => 0,
        'GD' => 0,
    ];
}

//ouvre le fichier
$handle = fopen(FILE_PATH, 'r');
//récupère la première ligne
$headers = fgetcsv($handle, 1000, ",");
//ouvre le fichier et récupère la ligne, tant que line est égal à qqch la fonction s'exécute de nouveau
while ($line = fgetcsv($handle, 1000, ",")) {
    $match = array_combine($headers, $line);
    $matches[] = $match;
    $homeTeam = $match['home-team'];
    $awayTeam = $match['away-team'];
    //si la clé "hometeam" n'existe pas dans le tableau des "standings" (classement) on créer un tableau vide qu'on assigne a la clé hometeam dans standings
    if (!array_key_exists($homeTeam, $standings)) {
        $standings[$homeTeam] = getEmptyStatsArray();
    }
    //la même chose mais avec away team
    if (!array_key_exists($awayTeam, $standings)) {
        $standings[$awayTeam] = getEmptyStatsArray();
    }
    //on ajoute un match joué à "hometeam"et un a "awayteam"
    $standings[$homeTeam]['games']++;
    $standings[$awayTeam]['games']++;

    //si égalité on ajoute un point pour chaque équipe, ainsi qu'une égalité au compteur de chacune d'entre elles
    if ($match['home-team-goals'] === $match['away-team-goals']) {
        $standings[$homeTeam]['points']++;
        $standings[$awayTeam]['points']++;
        $standings[$homeTeam]['draws']++;
        $standings[$awayTeam]['draws']++;
        //si hometeam à gagné on ajoute un point à celle ci ainsi qu'une victoire et on ajoute une défaite à la team adverse
    } elseif ($match['home-team-goals'] > $match['away-team-goals']) {
        $standings[$homeTeam]['points'] += 3;
        $standings[$homeTeam]['wins']++;
        $standings[$awayTeam]['losses']++;
        //opposé du cas précédent
    } else {
        $standings[$awayTeam]['points'] += 3;
        $standings[$awayTeam]['wins']++;
        $standings[$homeTeam]['losses']++;
    }
    //on ajoute les goals à hometeam et awayteam pour garder le calssement à jour
    $standings[$homeTeam]['GF'] += $match['home-team-goals'];
    $standings[$homeTeam]['GA'] += $match['away-team-goals'];
    $standings[$awayTeam]['GF'] += $match['away-team-goals'];
    $standings[$awayTeam]['GA'] += $match['home-team-goals'];
    $standings[$homeTeam]['GD'] = $standings[$homeTeam]['GF'] - $standings[$homeTeam]['GA'];
    $standings[$awayTeam]['GD'] = $standings[$awayTeam]['GF'] - $standings[$awayTeam]['GA'];

}

uasort($standings, function ($a, $b) {
    if ($a['points'] === $b['points']) {
        return 0;
    }
    return $a['points'] > $b['points'] ? -1 : 1;
});

$teams = array_keys($standings);
sort($teams);

require('scores.view.php');
