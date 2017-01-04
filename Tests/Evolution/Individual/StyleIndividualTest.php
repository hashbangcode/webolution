<?php

use Hashbangcode\Wevolution\Evolution\Individual\StyleIndividual;
use Hashbangcode\Wevolution\Type\Style\Style;

/**
 * Test class for ColorIndividual
 */
class StyleIndividualTest extends PHPUnit_Framework_TestCase
{

  public function testCreateIndividual() {
    $object = new StyleIndividual(1);
    $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\StyleIndividual', $object);
    $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Style\Style', $object->getObject());
  }

  public function testCreateIndividualWithObject() {
    $style = new Style('.div');
    $object = new StyleIndividual($style);
    $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\StyleIndividual', $object);
    $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Style\Style', $object->getObject());
  }

  public function testCliRender() {
    $object = new StyleIndividual('.div');
    $renderType = 'cli';
    $this->assertEquals('.div{}' . PHP_EOL, $object->render($renderType));
  }

  public function testHtmlRender() {
    $object = new StyleIndividual('.div');
    $renderType = 'html';
    $this->assertEquals('.div{}<br>', $object->render($renderType));
  }

  public function testDefaultRender() {
    $object = new StyleIndividual('.div');
    $this->assertEquals('.div{}' . PHP_EOL, $object->render());
  }

  public function testGetFitness() {
    $object = new StyleIndividual('.div');
    $this->assertEquals(1, $object->getFitness());
  }

  public function testSetProperties () {
    $object = new StyleIndividual('.div');
    $object->getObject()->setAttrbute('color', 'black');
    $this->assertEquals('.div{color:black;}' . PHP_EOL, $object->render());
  }

  public function testMutateStyle() {
    $object = new StyleIndividual('.div');
    //$object->getObject()->setAttrbute('color', '000000');
    $object->getObject()->setAttrbute('margin', '0px');
    $object->mutateStyle(1);
    //$this->assertEquals('.div{color:000000;}' . PHP_EOL, $object->render());
  }
}
