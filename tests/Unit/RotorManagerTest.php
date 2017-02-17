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
    function it_advances_the_rotor_positions_correctly()
    {
    	$rotorHandler = new RotorManager("Test Test Test");
    	$rotorHandler->setRotorOffsets([
    		$rotorHandler->getRotors()[0]->sequence()->count() - 1,
    		0,
    		0
    	]);

    	$rotorHandler->getRotors()[0]->step();

    	$this->assertEquals( 0, $rotorHandler->getRotors()[0]->getOffset());
		$this->assertEquals( 1, $rotorHandler->getRotors()[1]->getOffset());

    }

    /** @test */
    function it_returns_different_results_when_the_offsets_are_changed()
    {
        $rotorHandler = new RotorManager("Test Test Test");
        $rotorHandler->setRotorOffsets([3,4,1]);
        
        $index = $rotorHandler->transformInput(10, true);
        $this->assertEquals($index, 2);

        $rotorHandler->setRotorOffsets([2,4,1]);

        $index = $rotorHandler->transformInput(10, true);
        $this->assertNotEquals($index, 2);
    }
 
}
