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
        $this->assertEquals(0, $population->getIndividualCount());
    }

    public function testAddPopulation()
    {
        $population = new UnitPopulation();
        $population->addIndividual();
        $population->addIndividual(UnitIndividual::generateFromUnitArguments(1, 'px'));
        $this->assertEquals(2, $population->getIndividualCount());
    }

    public function testCrossover()
    {
        $population = new UnitPopulation();
        $population->addIndividual(UnitIndividual::generateFromUnitArguments(1, 'px'));
        $population->addIndividual(UnitIndividual::generateFromUnitArguments(2, 'em'));
        $this->assertEquals(2, $population->getIndividualCount());

        $population->crossover();
        $this->assertEquals(3, $population->getIndividualCount());

        $individuals = $population->getIndividuals();
        $this->assertEquals('px', $individuals[2]->getObject()->getUnit());
        $this->assertEquals(2, $individuals[2]->getObject()->getNumber());
    }
}
