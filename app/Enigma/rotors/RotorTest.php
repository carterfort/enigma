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
			0 => 6,
			1 => 7,
			2 => 5,
			3 => 8,
			4 => 1,
			5 => 9,
			6 => 4,
			7 => 0,
			8 => 2,
			9 => 3
		];
	}
}