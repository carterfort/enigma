<?php

namespace Enigma;

use Illuminate\Support\Facades\Log;

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

	public function circuitComplete()
	{
		$this->rotors->first()->step();
	}

	public function getRotors()
	{
		return $this->rotors;
	}

	public function rotorDidCompleteRevolution(Rotor $rotor)
	{
		$nextRotorIndex = $this->rotors->search($rotor) + 1;
		$nextRotorToMove = $this->rotors[$nextRotorIndex] ?? false;
		if ($nextRotorToMove)
			$nextRotorToMove->step();
	}

	public function setRotorOffsets($offsets = [])
	{
		foreach($offsets as $rotorPosition => $offset)
		{
			if ($offset)
				$this->rotors[$rotorPosition]->setOffset($offset);
		}
	}

	public function transformInput($index)
	{

		$this->rotors->each(function($rotor, $i) use (&$index){
			Log::info($i . " In => ".$index);
			$index = $rotor->inputLeft($index, false);
			Log::info($i . " Out => ".$index);
		});

		return $index;
	}

	public function transformOutput($index)
	{
		$this->rotors->reverse()->each(function($rotor, $i) use (&$index){
			Log::info($i . " In => ".$index);
			$index = $rotor->inputRight($index, true);
			Log::info($i . " Out => ".$index);
		});

		return $index;

	}


}