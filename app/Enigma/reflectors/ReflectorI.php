<?php

namespace Enigma\Reflectors;

use Psy\Exception\ErrorException;
use Illuminate\Support\Facades\Log;

class ReflectorI
{

	protected $map = [
		24 => 12,
		23 => 7,
		15 => 19,
		17 => 1,
		18 => 21,
		8 => 25,
		16 => 6,
		14 => 2,
		3 => 5,
		0 => 20,
		22 => 10,
		4 => 11,
		13 => 9
	];

	public function reflect($position)
	{
		$map = collect($this->map);

		try {
			$reflected = $map->search($position);
			if ( $reflected === false) {
				$reflected = $map[$position];
			}
		} catch (ErrorException $e){
			dd("Couldn't find {$position} in the reflector");
		}

		Log::info("Reflected {$position} to {$reflected}");
		return $reflected;
	}

}