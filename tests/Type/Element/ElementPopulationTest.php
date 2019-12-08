<?php

namespace Hashbangcode\Webolution\Test\Type\Element;

use Hashbangcode\Webolution\Type\Element\ElementPopulation;
use Hashbangcode\Webolution\Type\Element\Element;
use Hashbangcode\Webolution\Type\Element\ElementIndividual;
use PHPUnit\Framework\TestCase;

/**
 * Test class for ElementPopulation
 */
class ElementPopulationTest extends TestCase
{

    public function testCreateObject()
    {
        $object = new ElementPopulation();
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Element\ElementPopulation', $object);
    }

    public function testAddElementsToPopulation()
    {
        $element = new Element();
        $element->setType('div');
        $element_individual = new ElementIndividual($element);

        $object = new ElementPopulation();
        $object->addIndividual($element_individual);
        $object->addIndividual();

        $this->assertEquals(2, $object->getIndividualCount());

        foreach ($object->getIndividuals() as $individual) {
            $this->assertEquals('div', $individual->getObject()->getType());
        }
    }

    public function testCrossover()
    {
        $population = new ElementPopulation();

        $element1 = ElementIndividual::generateFromElementType('p');
        $population->addIndividual($element1);

        $element2 = ElementIndividual::generateFromElementType('div');
        $population->addIndividual($element2);

        $this->assertEquals(2, $population->getIndividualCount());

        $population->crossover();
        $this->assertEquals(3, $population->getIndividualCount());

        $individuals = $population->getIndividuals();

        $this->assertEquals('p', $individuals[2]->getObject()->getType());
    }
}
