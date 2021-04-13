<?php

require_once('./vendor/autoload.php');

use App\Classes\Battle;

$playersName = ['Tintin', 'Milou'];
$battle = new Battle($playersName);
$battle->startGame();

?>