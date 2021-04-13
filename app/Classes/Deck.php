<?php

namespace App\Classes;

class Deck
{
  /**
   * Represents the list of cards
   * 
   * @var Card[]
   */
  private $cards;

  /**
   * Constructor
   *
   * @param Card[] $cards The list of cards (by default, empty)
   */
  public function __construct(array $cards = [])
  {
    $this->cards = $cards;
  }

  /**
   * Shuffle randomly all cards of the deck
   *
   * @return void
   */
  public function shuffle()
  {
    shuffle($this->cards);
  }

  /**
   * Cut randomly the deck
   *
   * @return void
   */
  public function cut()
  {
    if ($this->getCount() > 1) {
      // Get a randomized number like the player cut the deck
      $randomizedNumber = random_int(1, $this->getCount());

      // Get the first part of the deck
      $cards1 = array_slice($this->cards, 0, $randomizedNumber);

      // Get the second part of the deck
      $cards2 = array_slice($this->cards, $randomizedNumber);
      
      // Merge the two parts of the deck and reorder the index of the new deck
      $this->cards = array_merge($cards2, $cards1);
    }
  }

  /**
   * Get the number of cards
   *
   * @return int
   */
  public function getCount()
  {
    return count($this->cards);
  }

  /**
   * Check if the deck is empty (no more cards)
   *
   * @return bool
   */
  public function isEmpty()
  {
    return $this->getCount() === 0;
  }

  /**
   * Get a card of the deck
   *
   * @param integer $index the index of the card in the deck
   * @return bool|Card
   */
  private function getCard(int $index)
  {
    if ($index < $this->getCount()) {
      return $this->cards[$index];
    }

    return false;
  }

  /**
   * Get the first card of the deck
   *
   * @return bool|Card
   */
  public function getFirstCard()
  {
    return $this->getCard(0);
  }

  /**
   * Add a card in the deck
   *
   * @param Card $card The card to add
   * @return void
   */
  public function addCard(Card $card)
  {
    $this->cards[] = $card;
  }

  /**
   * Remove a card out of the deck
   *
   * @param Card $card  The card to remove
   * @return bool|Card
   */
  public function removeCard(Card $card)
  {
    // Search the card in the deck
    $key = array_search($card, $this->cards);

    // Manage if the card doesn't exist in the deck
    if (is_bool($key)) {
      return false;
    }

    // Remove the card out of the deck
    unset($this->cards[$key]);

    // Reorder the index of the new deck
    $this->cards = array_merge($this->cards);

    return $card;
  }

  /**
   * Get the string description of the deck
   *
   * @return string
   */
  public function toString()
  {
    if ($this->isEmpty()) {
      return '';

    } elseif ($this->getCount() === 1) {
      return $this->getCard(0)->toString();

    } else {
      $str = $this->getCard(0)->toString();
      for ($i = 1; $i < $this->getCount(); $i++) {
        $str .= ', '.$this->getCard($i)->toString();
      }
      return $str;
    }
  }
}

?>