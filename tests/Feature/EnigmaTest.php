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
    	$machineA = new Enigma("I II III", '8 14 19', 'EG HA SP OQ DM');
		$machineB = new Enigma("I II III", '8 14 19', 'EG HA SP OQ DM');


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

    /** @test */
    function it_builds_a_plugboard()
    {
    	//Because the swap only occurs on certain letters,
    	//all other letters should remain unswapped
    	$machineA = new Enigma("I II III", '', 'TE SI AL CD');
    	$machineB = new Enigma("I II III");

    	$resultsA = $machineA->transform("B");
    	$resultsOne = $machineA->transform("A");

    	$resultsB = $machineB->transform("B");
    	$resultsTwo = $machineB->transform("A");
    	
    	$this->assertEquals($resultsA, $resultsB);
    	$this->assertNotEquals($resultsOne, $resultsTwo);

    }


}
