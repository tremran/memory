<?php 

namespace Memoire;

class MemoireDeck extends \CardGame\Deck
{
	const MAX_NUMBER_OF_PAIR = 18;

	private $numberOfPair;
	
	public function __construct($numberOfPair)
	{
		if ($numberOfPair > self::MAX_NUMBER_OF_PAIR)
		{
			throw new \Exception('Le nombre maximum de carte est de ' . self::MAX_NUMBER_OF_PAIR);
		}
		$this->numberOfPair = $numberOfPair;
		for ($i = 0; $i < $numberOfPair; $i++)
		{
			$card1 = new MemoireCard($i);
			$this->addCard($card1);
			
			$card2 = new MemoireCard($i);
			$this->addCard($card2);
		}
	}
}