<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Population\ElementPopulation;
use Hashbangcode\Wevolution\Type\Element\Element;
use Hashbangcode\Wevolution\Evolution\Individual\ElementIndividual;

/**
 * Test class for ElementPopulation
 */
class ElementPopulationTest extends \PHPUnit_Framework_TestCase
{

    public function testCreateObject()
    {
        $element = new Element();
        $element->setType('html');
        $element_individual = new ElementIndividual($element);
        $object = new ElementPopulation($element_individual);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Population\ElementPopulation', $object);
    }

    public function __testPageRender()
    {
      // @todo : refactor into decorator.
        $page = new ElementPopulation();
        $page->addIndividual();
        $output = $page->render();
        $this->assertContains('<div></div>', $output);
    }

    public function __testMinimalPageRender()
    {
      // @todo : refactor into decorator.
        $element = new Element('div');
        $element_individual = new ElementIndividual($element);
        $page = new ElementPopulation();
        $page->addIndividual($element_individual);
        $output = $page->render();
        $this->assertContains('<div></div>', $output);
    }
}
