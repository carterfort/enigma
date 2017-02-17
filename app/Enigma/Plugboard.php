<?php

namespace Enigma;

use Exception;

class Plugboard
{

	protected $map;

	public function __construct($letterSwaps)
	{
		$this->map = collect([]);

		if ( ! $letterSwaps) return $this;

		$pairs = collect(explode(' ', $letterSwaps));
		$pairs->each(function($set){
			
			$pair = collect(str_split($set));
			$indexPair = $pair->map(function($letter){
				return $this->alphabet()->search($letter);
			});

			$indexPair->each(function($index){
				$exists = ($this->map[$index] ?? $this->map->search($index));
				if ($exists || $exists === 0)
					throw new Exception("A letter cannot be swapped twice");
			});

			if ($indexPair[0] == $indexPair[1])
					throw new Exception("A letter cannot be swapped with itself");

			$this->map[$indexPair[0]] = $indexPair[1];
		});
	}

	public function swap($index)
	{
	 	$swapped = $this->map[$index] ?? $this->map->search($index);
	 	if ( $swapped || $swapped === 0 ) return $swapped;
	 	return $index;
	}

	protected function alphabet(){
		return collect([
			"A","B","C","D","E","F","G","H","I","J","K","L","M","N","O","P","Q","R","S","T","U","V","W","X","Y","Z"
		]);
	}
}