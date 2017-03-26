<?php

$suits = array('Spades', 'Hearts', 'Clubs', 'Diamonds');
$numbers = array('2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10, 'J' => 10, 'Q' => 10, 'K' => 10, 'A' => array(1, 11));

Class Card {
	public $suit;
	public $number;
	public $value;
}

Class Deck {
	public $deck = array();

	public function __construct() {
		$this->buildDeck();
	}

	public function buildDeck() {
		global $suits, $numbers;
		unset($this->deck);
		$this->deck = array();
		foreach ($suits as $suit) {
			echo $suit;
			foreach ($numbers as $number => $numberValue) {
				$newCard = new Card;
				$newCard->suit = $suit;
				$newCard->number = $number;
				$newCard->value = $numberValue;
				$this->deck[] = $newCard;
			}
		}
	}
	public function shuffle() {
		for($i = 0; $i < 100; $i++) {
			$tempCard;
			$tempNumber = rand(0, sizeof($this->deck) - 1);
			$tempCard = $this->deck[$tempNumber];
			$this->deck[$tempNumber] = $this->deck[1];
			$this->deck[1] = $tempCard;
		}
	}
	public function resetDeck() {
		$this->buildDeck();
	}
	public function dealCard() {
		return array_pop( $this->deck );
	}
}

$firstDeck = new Deck;
$firstDeck->shuffle();
$firstDeck->resetDeck();
$card1 = $firstDeck->dealCard();
echo var_dump($card1);
echo var_dump($firstDeck->deck);




?>