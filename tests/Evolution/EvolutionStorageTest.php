<?php

namespace Hashbangcode\Wevolution\Test\Evolution;

use Hashbangcode\Wevolution\Evolution\EvolutionStorage;
use Hashbangcode\Wevolution\Evolution\Population\NumberPopulation;
use Hashbangcode\Wevolution\Evolution\Population\ColorPopulation;

class EvolutionStorageTest extends \PHPUnit_Framework_TestCase
{

    public function testEvolutionNumber()
    {
        $numberPopulation = new NumberPopulation();
        $evolution = new EvolutionStorage($numberPopulation);

        $population = $evolution->getCurrentPopulation();
        $this->assertEquals($evolution->getIndividualsPerGeneration(), $population->getLength());
    }

    public function testEvolutionColor()
    {
        $colorPopulation = new ColorPopulation();
        $evolution = new EvolutionStorage($colorPopulation);

        $population = $evolution->getCurrentPopulation();
        $this->assertEquals($evolution->getIndividualsPerGeneration(), $population->getLength());
    }
}
