<?php

namespace Enigma;

use Illuminate\Support\Facades\Log;
use Enigma\Reflectors\ReflectorI;

class Enigma
{

	protected $rotorHandler;
	protected $plugboard;
	protected $reflector;

	public function __construct($rotorsString, $offsets = '', $plugboardString = false)
	{
		$this->rotorHandler = (new RotorManager($rotorsString));
		$this->rotorHandler->setRotorOffsets(explode(' ', $offsets));
		$this->reflector = (new ReflectorI);
		$this->plugboard = new Plugboard($plugboardString);
	}

	public function transformMessage($message)
	{
		$plainText = collect(str_split($message));
		return $plainText->filter(function($character){
			return ctype_alpha($character);
		})->map(function($letter){
			return $this->transform($letter);
		})->implode("");
	}

	public function transform($letter)
	{
		Log::info("Beginning transformation of ".$letter);

		$index = $this->letterToIndex($letter);

		Log::info("{$letter} => {$index}");
		
		$index = $this->runThroughMachinery($index);
		$this->rotorHandler->circuitComplete();

		$outputLetter = $this->indexToLetter($index);
		Log::info("Ending transformation {$index} => {$outputLetter}");
		Log::info("\r\r");

		return $outputLetter;
	}

	protected function runThroughMachinery($index)
	{

		$index = $this->plugboard->swap($index);

		$index = $this->rotorHandler->transformInput($index);
		$index = $this->reflector->reflect($index);
		$index = $this->rotorHandler->transformOutput($index);

		$index = $this->plugboard->swap($index);

		return $index;

	}

	protected function indexToLetter($index)
	{
		return $this->alphabet()[$index];
	}

	protected function letterToIndex($letter)
	{
		return $this->alphabet()->search(strtoupper($letter));
	}

	protected function alphabet(){
		return collect([
			"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"
		]);
	}
	

}