<?php

namespace Tests\Unit;

use Tests\TestCase;
use Enigma\RotorManager;
use Enigma\Rotors\RotorTest;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class RotorManagerTest extends TestCase
{

    /** * @test */
    function it_sets_offsets_for_rotors()
    {
    	$rotorHandler = new RotorManager("Test Test Test");
    	$rotorHandler->setRotorOffsets([3,4,1]);
    	
    	$this->assertEquals( 3, ($rotorHandler->getRotors()[0]->getOffset() ));	
    	$this->assertEquals( 4, ($rotorHandler->getRotors()[1]->getOffset() ));
    	$this->assertEquals( 1, ($rotorHandler->getRotors()[2]->getOffset() ));	

    }

    /** @test */
    function it_scrambles_a_letter_through_its_rotors()
    {
    	$rotorHandler = new RotorManager("Test Test Test");
    	$rotorHandler->setRotorOffsets([0, 0, 0]);

        var_dump("Start with 000");

    	$this->assertEquals($rotorHandler->transform("A"), "D");

    	$rotorHandler->setRotorOffsets([1, 0, 0]);
        var_dump("Start with 100");
    	$this->assertEquals($rotorHandler->transform("A"), "D");
    }

    /** @test */
    function it_encrypts_a_decryptable_letter()
    {
        $rotorHandler = new RotorManager("Test Test Test");
        $rotorHandler->setRotorOffsets([3, 1, 2]);

        $results = $rotorHandler->transform("A");

        $rotorHandler->setRotorOffsets([3, 1, 2]);

        $this->assertEquals("A", $rotorHandler->transform($results));

        $results = $rotorHandler->transform("D");
        
        $rotorHandler->setRotorOffsets([3, 1, 2]);

        $this->assertEquals("D", $rotorHandler->transform($results));
    }

    /** @test */
    function it_encrypts_a_decryptable_phrase()
    {
        $rotorHandler = new RotorManager("Test Test Test");
        $rotorHandler->setRotorOffsets([3, 1, 2]);

        $phrase = collect(str_split("AEBDBDEEABDCEDA"));
        $encrypted = $phrase->map(function($letter) use ($rotorHandler){
            return $rotorHandler->transform($letter);
        });

        $rotorHandler->setRotorOffsets([3, 1, 2]);

        $decrypted = $encrypted->map(function($letter) use ($rotorHandler){
            return $rotorHandler->transform($letter);
        });

        dd($phrase, $decrypted);
    }
}
