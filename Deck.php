<?php
session_start();

$suits = array('Spades', 'Hearts', 'Clubs', 'Diamonds');
$numbers = array('2' => 2, '3' => 3, '4' => 4, '5' => 5, '6' => 6, '7' => 7, '8' => 8, '9' => 9, '10' => 10, 'j' => 10, 'q' => 10, 'k' => 10, '1' => 11);
// array(1, 11)
Class Card {
	public $suit;
	public $number;
	public $value;
	public $img;
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
			foreach ($numbers as $number => $numberValue) {
				$newCard = new Card;
				$newCard->suit = $suit;
				$newCard->number = $number;
				$newCard->value = $numberValue;
				$newCard->img = cardGenerator($suit, $number);
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

class Player {
	public $name;
	public $cards = array();
	public function getCard($deck) {
		$sum = 0;
		$this->cards[] = $deck->dealCard();
		foreach ($this->cards as $key => $value) {
			$sum += $value->value;
		}
		if($sum > 21) {
			echo "You, $this->name, have lost! $sum is over!";
			$this->cards = array();
		}
	}
}

function cardGenerator($suit, $number) {
	if($suit == 'Spades') {
		return 's'.$number.'.png';
	} elseif ($suit == 'Hearts') {
		return 'h'.$number.'.png';
	} elseif ($suit == "Diamonds") {
		return 'd'.$number.'.png';
	} else {
		return 'c'.$number.'.png';
	}
}

//----------Initializes Game -----------------------------//
if(!isset($_SESSION['all'])) {
	$_SESSION['all'] = array();
	$_SESSION['firstDeck'] = new Deck;
	$_SESSION['firstDeck'] ->shuffle();
	$house = new Player;
	$house->name = "House";
	$_SESSION['all'][] = $house;	
}
//-------------------------------------------------------//

if(isset($_POST['clearSession'])) {
	session_destroy();
}

if(isset($_POST['submit'])) {
	${$_POST['name']} = new Player;
	${$_POST['name']}->name = $_POST['name'];
	$_SESSION['all'][] = ${$_POST['name']};
}

if(isset($_POST['startRound'])) {
	foreach ($_SESSION['all'] as $key => $value) {
		$value->getCard($_SESSION['firstDeck']);
		$value->getCard($_SESSION['firstDeck']);
	}
}

echo var_dump($_SESSION['all']);

?>
<html>
<head>
	<title>Black Jack</title>
</head>
<body>
	<header>
		<form method = "post" action = "Deck.php">
			<input type = "text" name = "name">
			<input type = "submit" name = "submit" value = "Add Player">
		</form>
		<form method = "post" action = "Deck.php">
			<input type = "submit" name = "clearSession" value = "Reset Game">
		</form>
		<form method = "post" action = "Deck.php">
			<input type = "submit" name = "startRound" value = "Start Round">
		</form>
		<hr>
	</header>
	<div class = "main">
		<div class = "table">
			<ul>
				<?php 
				foreach ($_SESSION['all'] as $key => $value) {
					echo "<li> $value->name ";
					foreach ($value->cards as $cardKey => $cardValue) {
						echo "<img src = './cards-png/$cardValue->img'>";
					}
					echo "</li>";
				} 
				?>
			</ul>
		</div>
	</div>
</body>
<style type="text/css">
	.table {
		background-color: lightgrey;
		width: 80%;
		height: 70%;
		border-radius: 10px;
		margin-top: 20px;
		margin-left: 10%;
	}
	li {
		padding-top: 10px;
		text-align: center;
		margin: 3%;
		display: inline-block;
		vertical-align: top;
	}
</style>
</html>