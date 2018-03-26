<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Population\StylePopulation;
use Hashbangcode\Wevolution\Evolution\Individual\StyleIndividual;

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

    public function __testRenderPopulation()
    {
      // @todo : refactor into decorator.
        $population = new StylePopulation();
        $population->addIndividual(StyleIndividual::generateFromSelector('div.monkey'));
        $output = $population->render();
        $this->assertContains('div.monkey{}', $output);
    }
}
