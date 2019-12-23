<?php 

namespace CardGame;

class Deck
{
	protected $cardList;
	
	public function addCard(Card $card)
	{
		$this->cardList[] = $card;
	}

	private function shuffle()
	{
		shuffle($this->cardList);
	}

	public function getCard($autoShuffle = true)
	{
		if ($autoShuffle)
		{
			shuffle($this->cardList);
		}
		return array_pop($this->cardList);
	}
}
