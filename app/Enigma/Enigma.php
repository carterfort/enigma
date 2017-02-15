<?php

namespace Enigma;

class Enigma
{

	protected $rotorHandler;

	protected $plugboard;
	protected $reflector;

	public function __construct($rotorsString, $plugboardString)
	{
		$this->rotorHandler = (new RotorManager($rotorsString));
	}

	public function transform($letter)
	{
		$letter = $this->rotorHandler->transform($letter);

		return $letter;
	}

}