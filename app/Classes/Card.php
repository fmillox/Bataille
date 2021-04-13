<?php

namespace App\Classes;

class Card
{
  /**
   * Represents the value of the card
   * 
   * @var int
   */
  private $value;

  /**
   * Constructor
   *
   * @param integer $value The value of the card
   */
  public function __construct(int $value)
  {
    $this->value = $value;
  }

  /**
   * Compare the current card value with an other card
   *
   * @param Card $card The card compare to
   * @return integer
   */
  public function compareTo(Card $card)
  {
    if ($this->value > $card->getValue()) {
      return 1;
    } elseif ($this->value < $card->getValue()) {
      return -1;
    } else {
      return 0;
    }
  }

  /**
   * Get the string description of the card
   *
   * @return string
   */
  public function toString()
  {
    return strval($this->value);
  }

  /**
   * Get the value of value
   *
   * @return  int
   */ 
  public function getValue()
  {
    return $this->value;
  }
}

?>