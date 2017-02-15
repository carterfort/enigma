<?php

namespace Enigma;

abstract class Rotor
{

	protected $offset;

	protected $manager;

	public function __construct($manager, $offset = 0)
	{
		$this->manager = $manager;
		$this->offset = $offset;
	}

	public function setOffset($offset)
	{
		$this->offset = $offset;
	}

	public function getOffset()
	{
		return $this->offset;
	}

	public function sequence()
	{
		return collect($this->getSequence());
	}

	public function step()
	{
		$this->offset += 1;
		if ($this->offset >= $this->sequence()->count()){
			$this->offset = 0;
			$this->manager->rotorDidCompleteRevolution($this);
		}
		var_dump($this->offset);
		
	}

	protected function transformFromOffset($position)
	{
		$transformed = $position - $this->offset;
		while ($transformed < 0){
			$transformed += $this->sequence()->count();
		}
		return $transformed;
	}

	public function inputLeft($postPosition)
	{
		return $this->transformFromOffset($this->sequence()[$this->transformFromOffset($postPosition)]);
	}

	public function inputRight($postPosition)
	{
		return $this->transformFromOffset($this->sequence()->search($this->transformFromOffset($postPosition)));
	}

}