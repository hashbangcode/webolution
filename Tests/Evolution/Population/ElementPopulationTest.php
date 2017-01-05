<?php

use Hashbangcode\Wevolution\Evolution\Population\ElementPopulation;
use Hashbangcode\Wevolution\Type\Element\Element;
use Hashbangcode\Wevolution\Evolution\Individual\ElementIndividual;

/**
 * Test class for ElementPopulation
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

  public function testPageRender() {
    $page = new ElementPopulation();
    $page->addIndividual();
    $output = $page->render();
    $this->assertContains('<html><body></body></html>', $output);
  }

  public function testMinimalPageRender() {
    $element = new Element('html');
    $element_individual = new ElementIndividual($element);
    $page = new ElementPopulation();
    $page->addIndividual($element_individual);
    $output = $page->render();
    $this->assertContains('<html></html>', $output);
  }

  public function testAddIndividualError() {
    $this->setExpectedException('Hashbangcode\Wevolution\Evolution\Population\Exception\ElementPageRootException');
    $element = new Element('p');
    $element_individual = new ElementIndividual($element);
    $page = new ElementPopulation();
    $page->addIndividual($element_individual);
    //$output = $page->render();
  }
}
