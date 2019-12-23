<?php 


namespace Memoire;

class MemoireCard extends \CardGame\Card
{
	private $id;
	private $number;
	
	public function __construct($number)
	{
		$this->id = uniqid($number);
		$this->number = $number;
	}
	
	public function getId()
	{
		return $this->id;
	}
	
	public function getNumber()
	{
		return $this->number;
	}
}
