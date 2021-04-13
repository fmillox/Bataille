<?php

require_once('./vendor/autoload.php');

use App\Classes\Card;

$card = new Card(10);
echo ($card->toString() === '10')."\n";

$card1 = new Card(100);
$card2 = new Card(100);
echo ($card1->compareTo($card2) === 0)."\n";

$card1 = new Card(100);
$card2 = new Card(101);
echo ($card1->compareTo($card2) === -1)."\n";

$card1 = new Card(101);
$card2 = new Card(100);
echo ($card1->compareTo($card2) === 1)."\n";

?>