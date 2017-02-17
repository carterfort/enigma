<?php

namespace Tests\Unit;

use Tests\TestCase;
use Enigma\Reflectors\ReflectorI as R;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class ReflectorTest extends TestCase
{
    /** @test */
    function it_reflects_a_number_back_as_its_pair()
    {
        $reflector = new R();
        $this->assertEquals(11, $reflector->reflect(4));
        $this->assertEquals(4, $reflector->reflect(11));
    }
}
