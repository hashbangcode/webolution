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

    public function testCrossover()
    {
        $population = new StylePopulation();

        $style1 = StyleIndividual::generateFromSelector('div.monkey');
        $style1->getObject()->setAttribute('border-style', 'none');
        $population->addIndividual($style1);

        $style2 = StyleIndividual::generateFromSelector('p.ape');
        $style2->getObject()->setAttribute('text-align', 'left');
        $population->addIndividual($style2);

        $this->assertEquals(2, $population->getIndividualCount());

        $population->crossover();
        $this->assertEquals(3, $population->getIndividualCount());

        $individuals = $population->getIndividuals();

        $this->assertEquals('div.monkey', $individuals[2]->getObject()->getSelector());
        $this->assertEquals('left', $individuals[2]->getObject()->getAttribute('text-align'));
    }
}
