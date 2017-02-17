<?php

namespace Tests\Unit;

use Tests\TestCase;
use Enigma\RotorManager;
use Enigma\Rotors\RotorTest;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SampleRotorTest extends TestCase
{
    /** @test */
    function it_has_an_input_and_an_output()
    {
    	$rotorHandler = new RotorManager();
    	$rotor = new RotorTest($rotorHandler);

    	$this->assertEquals(5, $rotor->inputLeft(2, true));
    	$this->assertEquals(4, $rotor->inputRight(1, true));
    }

	/** @test */
    function it_alters_the_input_and_output_based_on_offset()
    {
    	$rotorHandler = new RotorManager();
    	$rotor = new RotorTest($rotorHandler, 1);

		$output = ([$rotor->inputLeft(3, true), $rotor->inputRight(1, true)]);
		$this->assertEquals([4,6], $output);

		$rotor->step();

		$output = ([$rotor->inputLeft(3, true), $rotor->inputRight(1, true)]);
		$this->assertEquals([5,3], $output);

		$rotor->step();

		$output = ([$rotor->inputLeft(3, true), $rotor->inputRight(1, true)]);
		$this->assertEquals([3,0], $output);

    }
}
