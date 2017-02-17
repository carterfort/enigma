<?php

namespace Tests\Unit;

use Tests\TestCase;
use Enigma\Plugboard;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class PlugboardTest extends TestCase
{
    /** @test */
    function it_swaps_letters_in_both_directions()
    {
        $plugboard = new Plugboard("AG CD EF BH");

        $this->assertEquals($plugboard->swap(6), 0);
    }

    /**
     *  @expectedException Exception
     * 
    */
    function test_it_throws_an_error_when_attempting_to_swap_a_letter_with_itself()
    {
    	$plugboard = new Plugboard("AA");
    }

    /**
     *  @expectedException Exception
     * 
    */
    function test_it_throws_an_error_when_attempting_to_swap_the_same_letter()
    {
    	$plugboard = new Plugboard("AB BD");
    }
}
