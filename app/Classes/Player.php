<?php

namespace App\Classes;

class Player
{
  /**
   * Represents the name of the player
   * 
   * @var string
   */
  private $name;

  /**
   * Represents the deck of the player
   * 
   * @var Deck
   */
  private $deck;

  /**
   * Represents the visible card of the player
   * 
   * @var Card
   */
  private $visibleCard;

  /**
   * Represents the score of the player
   * 
   * @var int
   */
  private $score;

  /**
   * Constructor
   *
   * @param string $name The name of the player
   */
  public function __construct(string $name)
  {
    $this->name = $name;
    $this->deck = new Deck();
    $this->visibleCard = null;
    $this->score = 0;
  }

  /**
   * Get the string description of the player
   *
   * @return string
   */
  public function toString()
  {
    $strDeck = $this->deck->toString();
    if (strlen($strDeck) === 0) {
      $strDeck = 'vide';
    }

    return 'Joueur : '.$this->name."\n"
          .'--- jeu de cartes : '.$strDeck."\n";
  }

  /**
   * Get the string description of the player during a round
   *
   * @return string
   */
  public function roundToString()
  {
    $strDeck = $this->deck->toString();
    if (strlen($strDeck) > 0) {
      $strDeck = ' ('.$strDeck.')';
    }

    return 'Joueur : '.$this->name."\n"
          .'--- carte visible sur la table : '.($this->isCardVisible() ? $this->visibleCard->toString() : 'aucune')."\n"
          .'--- '.$this->deck->getCount().' carte(s) restante(s)'.$strDeck."\n"
          .'--- score : '.$this->score."\n";
  }

  /**
   * Show the first card of the deck of the player
   *
   * @param integer $isCardRemovedOutOfDeck Boolean to indicate if the card has to be removed out of the deck (default, true)
   * @return bool|Card
   */
  public function showFirstCardOfDeck(bool $isCardRemovedOutOfDeck = true)
  {
    $card = $this->deck->getFirstCard();
    if (is_bool($card)) {
      return false;
    }

    if ($isCardRemovedOutOfDeck) {
      $card = $this->deck->removeCard($card);
      if (is_bool($card)) {
        return false;
      }
    }
    
    $this->visibleCard = $card;
    
    return $card;
  }

  /**
   * Reset the visible card
   *
   * @return void
   */
  public function resetVisibleCard()
  {
    $this->visibleCard = null;
  }

  /**
   * Check if the card is visible
   *
   * @return boolean
   */
  public function isCardVisible()
  {
    return $this->visibleCard !== null;
  }

  /**
   * Increase the score of the player
   *
   * @param integer $number The number to add to the score (by default, 1)
   * @return void
   */
  public function increaseScore(int $number = 1)
  {
    $this->score += $number;
  }

  /**
   * Get the value of name
   *
   * @return  string
   */ 
  public function getName()
  {
    return $this->name;
  }

  /**
   * Get the value of deck
   *
   * @return  Deck
   */ 
  public function getDeck()
  {
    return $this->deck;
  }

  /**
   * Get the value of visibleCard
   *
   * @return  Card
   */ 
  public function getVisibleCard()
  {
    return $this->visibleCard;
  }

  /**
   * Get the value of score
   *
   * @return  int
   */ 
  public function getScore()
  {
    return $this->score;
  }
}

?>