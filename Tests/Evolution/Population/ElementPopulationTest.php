<?php

use Hashbangcode\Wevolution\Evolution\Population\ElementPopulation;
use Hashbangcode\Wevolution\Type\Element\Element;
use Hashbangcode\Wevolution\Evolution\Individual\ElementIndividual;

/**
 * Test class for Color
 */
class ElementPopulationTest extends PHPUnit_Framework_TestCase
{

  public function testCreateObject() {
    $element = new Element();
    $element->setType('html');
    $element_individual = new ElementIndividual($element);
    $object = new ElementPopulation($element_individual);
    $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Population\ElementPopulation', $object);
  }

  public function testMinimalPageRender() {
    $element = new Element();
    $element->setType('html');
    $element_individual = new ElementIndividual($element);
    $page = new ElementPopulation($element_individual);
    $this->assertEquals('<html></html>', $page->render());
  }

  public function testPageRender() {
    $element = new Element();
    $element->setType('html');
    $element_individual = new ElementIndividual($element);
    $page = new ElementPopulation($element_individual);

    $page->getRootElement()->getObject()->addChild(new Element('head'));
    $page->getRootElement()->getObject()->addChild(new Element('body'));

    $this->assertEquals('<html><head></head><body></body></html>', $page->render());
  }

}
