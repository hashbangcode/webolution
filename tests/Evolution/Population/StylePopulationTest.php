<?php

namespace Hashbangcode\Webolution\Test\Evolution\Population;

use Hashbangcode\Webolution\Evolution\Population\StylePopulation;
use Hashbangcode\Webolution\Evolution\Individual\StyleIndividual;

class StylePopulationTest extends \PHPUnit_Framework_TestCase
{

    public function testEmptyPopulation()
    {
        $population = new StylePopulation();
        $this->assertEquals(0, $population->getLength());
    }

    public function testAddPopulation()
    {
        $population = new StylePopulation();
        $population->addIndividual();
        $population->addIndividual(StyleIndividual::generateFromSelector('div.monkey'));
        $this->assertEquals(2, $population->getLength());
    }
}
