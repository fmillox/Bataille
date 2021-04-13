<?php

require_once('./vendor/autoload.php');

use App\Classes\Card;
use App\Classes\Deck;
use App\Classes\Player;

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

$player = new Player('Toto');
echo 'Affichage du joueur : '."\n".$player->toString()."\n\n";
echo 'Affichage du round du joueur : '."\n".$player->roundToString()."\n\n";

$card = $deck->getFirstCard();
$player->getDeck()->addCard($card);
$deck->removeCard($card);
$card = $deck->getFirstCard();
$player->getDeck()->addCard($card);
$deck->removeCard($card);
echo 'Affichage du joueur : '."\n".$player->toString()."\n\n";
echo 'Affichage du round du joueur : '."\n".$player->roundToString()."\n\n";

$card = $player->getDeck()->getFirstCard();
$player->getDeck()->removeCard($card);
$player->setVisibleCard($card);
$player->increaseScore();
echo 'Affichage du joueur : '."\n".$player->toString()."\n\n";
echo 'Affichage du round du joueur : '."\n".$player->roundToString()."\n\n";

$player->resetVisibleCard();
echo 'Affichage du joueur : '."\n".$player->toString()."\n\n";
echo 'Affichage du round du joueur : '."\n".$player->roundToString()."\n\n";
?>