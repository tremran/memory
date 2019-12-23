<?php 

namespace Memoire;

/** 
 * @Entity 
 * @Table(name="game")
 */
class MemoireGame 
{
	/**
     * @Id
     * @Column(type="integer")
     * @GeneratedValue
     */
	private $id;
	
    /** @Column(length=25, unique=true) */
	private $gameId;

	/** @Column(type="integer", nullable=true) */
	private $time;

	/** @Column(type="integer", nullable=true) */
	private $pairCount;
	
	private $deck;
	private $cardList;

	public function __construct($gameId, $numberOfPair)
	{
		$this->deck = new MemoireDeck($numberOfPair);
		$this->gameId = $gameId;
		$this->pairCount = $numberOfPair;

		while($card = $this->deck->getCard()) {
			$this->cardList[] = $card;
		}
	}

	public function getCards()
	{		
		return $this->cardList;
	}

	/**
	 * Get the value of gameId
	 */ 
	public function getGameId()
	{
		return $this->gameId;
	}

	/**
	 * Set the value of time
	 *
	 * @return  self
	 */ 
	public function setTime($time)
	{
		$this->time = $time;

		return $this;
	}

	/**
	 * Get the value of time
	 */ 
	public function getTime()
	{
		return $this->time;
	}
}