<?php

require_once('./vendor/autoload.php');

use App\Classes\Card;
use App\Classes\Deck;

$deck = new Deck();
echo 'Deck is empty : '.($deck->isEmpty() === true)."\n\n";

$cards = [];
for ($i = 1; $i <= 52; $i++) {
  $cards[] = new Card($i);
}
$deck = new Deck($cards);
echo 'Création du jeu de cartes : '."\n".$deck->toString()."\n\n";

echo 'Deck is not empty : '.($deck->isEmpty() === false)."\n\n";

$deck->shuffle();
echo 'Mélange du jeu de cartes : '."\n".$deck->toString()."\n\n";

$deck->cut();
echo 'Coupe du jeu de cartes : '."\n".$deck->toString()."\n\n";

echo 'Première carte : '.$deck->getFirstCard()->toString()."\n\n";

$deck->addCard(new Card(1000));
echo 'Nouvelle carte ajoutée : '."\n".$deck->toString()."\n\n";

echo $deck->removeCard($deck->getFirstCard())->toString()."\n";
echo 'Première carte retirée : '."\n".$deck->toString()."\n\n";
?>