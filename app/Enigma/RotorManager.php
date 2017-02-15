<?php

namespace Enigma;

class RotorManager
{

	protected $rotors;

	public function __construct($rotors = false)
	{
		if ( $rotors )
		{
			$rotorStrings = collect(explode(' ', $rotors));

			$this->rotors = collect([]);

			$rotorClasses = $rotorStrings->each(function($id, $index){
				$class = 'Enigma\Rotors\Rotor'.$id;
				$this->rotors[] = new $class($this);
			});
		}
	}

	public function getRotors()
	{
		return $this->rotors;
	}

	public function rotorDidCompleteRevolution(Rotor $rotor)
	{
		$nextRotorIndex = $this->rotors->search($rotor) + 1;
		$nextRotorToMove = $this->rotors[$nextRotorIndex];
		$nextRotorToMove->step();
		var_dump($nextRotorIndex." advanced");
	}

	public function setRotorOffsets($offsets = [])
	{
		foreach($offsets as $rotorPosition => $offset)
		{
			$this->rotors[$rotorPosition]->setOffset($offset);
		}
	}

	public function transform($letter)
	{
		$index = $this->alphabet()->search(strtoupper($letter));

		$index = $this->runThroughRotors($index);

		$this->rotors->first()->step();

		return $this->indexToLetter($index);
	}

	protected function runThroughRotors($index)
	{
		$this->rotors->each(function($rotor) use (&$index){
			$index = $rotor->inputLeft($index);

		});

		$halfOfLastRotor = $this->rotors->last()->sequence()->count() / 2;
		if ($index - $halfOfLastRotor < 0){
			$index += $halfOfLastRotor;
		} else {
			$index -= $halfOfLastRotor;
		}

		$this->rotors->each(function($rotor) use (&$index){
			$index = $rotor->inputRight($index);
		});

		return $index;
	}

	protected function indexToLetter($index)
	{
		return $this->alphabet()[$index];
	}

	public function alphabet(){
		return collect([
			"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"
		]);
	}
	

}