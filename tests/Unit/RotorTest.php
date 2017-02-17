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

       $this->assertEquals($rotor->inputLeft(3), 4);
       $this->assertEquals($rotor->inputLeft(1), 0);

   }

   /** @test */
  function it_transforms_a_number_from_the_right()
   {
        $rotorHandler = new RotorManager();
        $rotor = new R($rotorHandler);

        $this->assertEquals($rotor->inputRight(3), 5);
        $this->assertEquals($rotor->inputRight(1), 4);
   }

   /** @test */
   function it_offsets_transformations()
   {
       $rotorHandler = new RotorManager();
       $rotor = new R($rotorHandler);

       $rotor->step();

       $this->assertEquals($rotor->inputLeft(1), 1);
       $this->assertEquals($rotor->inputRight(1), 0);


       $rotor->step();

       $this->assertEquals($rotor->inputLeft(2), 0);
       $this->assertEquals($rotor->inputRight(3), 2);
    }
}
