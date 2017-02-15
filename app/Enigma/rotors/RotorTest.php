<?php

namespace Enigma\Rotors;

use Enigma\Rotor;

class RotorTest extends Rotor
{
	//Wiring:
	//
	//	A => C
	//	B => A
	//	C => F
	//	D => E
	//	E => B
	//	F => D
	

	protected function getSequence()
	{
		return [
			0 => 2,
			1 => 0,
			2 => 5,
			3 => 4,
			4 => 1,
			5 => 3
		];
	}

}