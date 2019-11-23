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
        $element = new Element();
        $element->setType('html');
        $element_individual = new ElementIndividual($element);
        $object = new ElementPopulation();
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Element\ElementPopulation', $object);
    }
}
