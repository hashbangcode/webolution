<?php

namespace Hashbangcode\Webolution\Test\Type\Unit;

use Hashbangcode\Webolution\Type\Unit\UnitPopulation;
use Hashbangcode\Webolution\Type\Unit\UnitIndividual;
use PHPUnit\Framework\TestCase;

class UnitPopulationTest extends TestCase
{

    public function testEmptyPopulation()
    {
        $population = new UnitPopulation();
        $this->assertEquals(0, $population->getLength());
    }

    public function testAddPopulation()
    {
        $population = new UnitPopulation();
        $population->addIndividual();
        $population->addIndividual(UnitIndividual::generateFromUnitArguments(1, 'px'));
        $this->assertEquals(2, $population->getLength());
    }
}
