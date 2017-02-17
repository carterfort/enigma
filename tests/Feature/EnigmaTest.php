<?php

namespace Tests\Feature;

use Enigma\Enigma;
use Tests\TestCase;
use Illuminate\Support\Facades\Log;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class EnigmaTest extends TestCase
{
    /** @test */
    function it_transforms_an_encryptable_letter()
    {
    		$machineA = new Enigma("I II III", false);
			$machineB = new Enigma("I II III", false);

			$input = "C";
			$outputA = ($machineA->transform($input));
			$outputB = ($machineB->transform($outputA));

			$this->assertEquals($input, $outputB);

			Log::info("-----\r------");

			$input = "C";
			$outputA = ($machineA->transform($input));
			$outputB = ($machineB->transform($outputA));

			$this->assertEquals($input, $outputB);
    }

    /** @test */
    function it_transforms_an_encryptable_phrase()
    {
    	$machineA = new Enigma("I II III", false);
		$machineB = new Enigma("I II III", false);


		$plainText = collect(str_split(strtoupper("ThisIsAnEncryptedPhrase")));

		$encrypted = $plainText->map(function($character) use ($machineA){
			return $machineA->transform($character);
		});

		Log::info("-----\r------");

		$decrypted = $encrypted->map(function($character) use ($machineB){
			return $machineB->transform($character);
		});

		$this->assertEquals($plainText, $decrypted);

    }


}
