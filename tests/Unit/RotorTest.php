<?php

namespace Tests\Unit;

use Tests\TestCase;
use Enigma\RotorManager;
use Enigma\Rotors\RotorTest as R;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SingleRotorTest extends TestCase
{

   /** @test */
   function it_transforms_a_number_from_the_left()
   {
       $rotorHandler = new RotorManager();
       $rotor = new R($rotorHandler);

       $this->assertEquals($rotor->inputLeft(3, true), 8);
       $this->assertEquals($rotor->inputLeft(1, true), 7);

   }

   /** @test */
  function it_transforms_a_number_from_the_right()
   {
        $rotorHandler = new RotorManager();
        $rotor = new R($rotorHandler);

        $this->assertEquals($rotor->inputRight(3, true), 9);
        $this->assertEquals($rotor->inputRight(1, true), 4);
   }

   /** @test */
   function it_offsets_transformations()
   {
       $rotorHandler = new RotorManager();
       $rotor = new R($rotorHandler);

       $rotor->step();

       $this->assertEquals($rotor->inputLeft(1, false), 6);
       $this->assertEquals($rotor->inputRight(1, false), 9);


       $rotor->step();

       $this->assertEquals($rotor->inputLeft(2, false), 3);
       $this->assertEquals($rotor->inputRight(3, false), 4);
    }
}
