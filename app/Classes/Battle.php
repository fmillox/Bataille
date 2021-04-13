<?php

namespace App\Classes;

class Battle
{
  /**
   *
   * @var Player[]
   */
  private $players;

  /**
   * Represents the deck of the battle
   *
   * @var Deck
   */
  private $deck;

  /**
   * Represents the round number of the battle 
   *
   * @var int
   */
  private $roundNumber;

  /**
   * Constructor
   *
   * @param array $playersName The list of players name
   */
  public function __construct(array $playersName)
  {
    $this->players = [];
    foreach ($playersName as $playerName) {
      $this->players[] = new Player($playerName);
    }
  }

  /**
   * Reset the round number
   *
   * @return void
   */
  private function resetRoundNumber()
  {
    $this->roundNumber = 0;
  }

  /**
   * Increase the round number by 1
   *
   * @return void
   */
  private function increaseRoundNumber()
  {
    $this->roundNumber += 1;
  }

  /**
   * Get the number of players
   *
   * @return int
   */
  public function getPlayersCount()
  {
    return count($this->players);
  }

  /**
   * Create the deck
   *
   * @return void
   */
  private function createDeck()
  {
    $cards = [];
    for ($i = 1; $i <= 52; $i++) {
      $cards[] = new Card($i);
    }
    $this->deck = new Deck($cards);
    echo 'Création du jeu de cartes : '."\n".$this->deck->toString()."\n\n";
  }

  /**
   * Distribute the deck to all the players
   *
   * @return void
   */
  private function distributeDeckToPlayers()
  {
    $this->deck->shuffle();
    echo 'Mélange du jeu de cartes : '."\n".$this->deck->toString()."\n\n";
    $this->deck->cut();
    echo 'Coupe du jeu de cartes : '."\n".$this->deck->toString()."\n\n";
    do {
      foreach ($this->players as $player) {
        $card = $this->deck->getFirstCard();
        if (!is_bool($card)) {
          $this->deck->removeCard($card);
          $player->getDeck()->addCard($card);
        }
      }
    } while (!$this->deck->isEmpty());
    echo 'Cartes distribuées aux '.$this->getPlayersCount().' joueurs'."\n\n";

    foreach ($this->players as $player) {
      echo $player->toString();
    }
    echo "\n\n";
  }

  /**
   * Get all the players with a not empty deck
   *
   * @return Player[]
   */
  public function getAvalaiblePlayers()
  {
    $avalaiblePlayers = [];
    foreach ($this->players as $player) {
      if (!$player->getDeck()->isEmpty()) {
        $avalaiblePlayers[] = $player;
      }
    }
    return $avalaiblePlayers;
  }

  /**
   * Check if the game is over
   *
   * @return bool
   */
  private function gameIsOver()
  {
    return count($this->getAvalaiblePlayers()) <= 1;
  }

  /**
   * Get the string description of the players result
   *
   * @return string
   */
  private static function playersResultToString(array $players)
  {
    if (count($players) === 1) {
      return $players[0]->getName().' a gagné';
    } else {
      $str = $players[0]->getName();
      $count = count($players);
      for ($i = 1; $i < $count ; $i++) {
        if ($i === $count - 1) {
          $str .= ' et '.$players[$i]->getName();
        } else {
          $str .= ', '.$players[$i]->getName();
        }
      }
      return $str.' sont égalités';
    }
  }

  /**
   * Show the result of the round
   *
   * @param array $winningPlayers The list of the winning players
   * @return void
   */
  private function showRoundResult(array $winningPlayers)
  {
    echo 'Tour n°'.strval($this->roundNumber)."\n";
    foreach ($this->players as $player) {
      echo $player->roundToString();
    }
    echo 'Vainqueur du tour : '.self::playersResultToString($winningPlayers); 
    echo "\n\n";
  }

  /**
   * Show the result of the game
   *
   * @return void
   */
  private function showGameResult()
  {
    $gameWinningPlayers = [];
    foreach ($this->players as $player) {
      if (count($gameWinningPlayers) === 0) {
        // Initialize with the first player
        $gameWinningPlayers[] = $player;

      } else if ($gameWinningPlayers[0]->getScore() < $player->getScore()) {
        // Reset the list of winning players with the current player
        $gameWinningPlayers = [$player];

      } elseif ($gameWinningPlayers[0]->getScore() === $player->getScore()) {
        // Add the current player to the list of winning players
        $gameWinningPlayers[] = $player;
      }
    }

    echo 'Résultat de la partie : ';
    echo self::playersResultToString($gameWinningPlayers); 
    echo "\n";
  }

  /**
   * Reset the visible card of all the players
   *
   * @return void
   */
  private function resetVisibleCardPlayers()
  {
    foreach ($this->players as $player) {
      if ($player->isCardVisible()) {
        $player->resetVisibleCard();
      }
    }
  }

  /**
   * Play one round of the game
   *
   * @return void
   */
  private function playRound()
  {
    $this->increaseRoundNumber();

    $avalaiblePlayers = $this->getAvalaiblePlayers();
    $roundWinningPlayers = [];
    foreach ($avalaiblePlayers as $player) {
      $player->showFirstCardOfDeck();
      if (count($roundWinningPlayers) === 0) {
        // Initialize with the first player
        $roundWinningPlayers[] = $player;
      } else {
        // All the winning players have the same card value so we compare the first winning player card value with the current player card value
        $result = $roundWinningPlayers[0]->getVisibleCard()->compareTo($player->getVisibleCard());
        switch ($result) {
          case -1:
            // Reset the list of winning players with the current player
            $roundWinningPlayers = [$player];
            break;
          case 0:
            // Add the current player to the list of winning players
            $roundWinningPlayers[] = $player;
            break;
          case 1:
            // still the same winner ;-)
            break;
        }
      }
    }
    // Increase the score only if we have one winner.
    if (count($roundWinningPlayers) === 1) {
      $roundWinningPlayers[0]->increaseScore();
    }
    $this->showRoundResult($roundWinningPlayers);

    $this->resetVisibleCardPlayers();
  }

  /**
   * Start the game
   *
   * @return void
   */
  public function startGame()
  {
    $this->createDeck();
    $this->distributeDeckToPlayers();
    $this->resetRoundNumber();
    while (!$this->gameIsOver()) {
      $this->playRound();
    }
    $this->showGameResult();
  }
}

?>