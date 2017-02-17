<?php

namespace Enigma;

use Illuminate\Support\Facades\Log;

abstract class Rotor
{

	protected $offset = 0;
	protected $manager;
	protected $currentIsLeftToRight;

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
	}

	protected function transformFromOffset($position)
	{
		switch($this->currentIsLeftToRight)
		{
			case true:
				$transformed = $position - $this->offset;
				while ($transformed < 0){
					$transformed += $this->sequence()->count();
				}
			break;
			case false:
				$transformed = $position + $this->offset;
				while ($transformed >= $this->sequence()->count()){
					$transformed -= $this->sequence()->count();
				}
			break;
		}

		Log::info("Offset transforms ".$position." to ".$transformed);

		return $transformed;
	}

	public function inputLeft($postPosition, $currentIsLeftToRight)
	{
		$this->currentIsLeftToRight = $currentIsLeftToRight;
		return $this->transformFromOffset($this->sequence()[$this->transformFromOffset($postPosition)]);
	}

	public function inputRight($postPosition, $currentIsLeftToRight)
	{
		$this->currentIsLeftToRight = $currentIsLeftToRight;
		return $this->transformFromOffset($this->sequence()->search($this->transformFromOffset($postPosition)));
	}

}