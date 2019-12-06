<?php

namespace Hashbangcode\Webolution\Test\Type\Style;

use Hashbangcode\Webolution\Type\Style\StylePopulation;
use Hashbangcode\Webolution\Type\Style\StyleIndividual;
use PHPUnit\Framework\TestCase;

class StylePopulationTest extends TestCase
{

    public function testEmptyPopulation()
    {
        $population = new StylePopulation();
        $this->assertEquals(0, $population->getIndividualCount());
    }

    public function testAddPopulation()
    {
        $population = new StylePopulation();
        $population->addIndividual();
        $population->addIndividual(StyleIndividual::generateFromSelector('div.monkey'));
        $this->assertEquals(2, $population->getIndividualCount());
    }
}
