<?php

use Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual;

/**
 * Test class for ColorIndividual
 */
class ColorIndividualTest extends PHPUnit_Framework_TestCase
{

  public function testCreateIndividual() {
    $object = new ColorIndividual(0, 0, 0);
    $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual', $object);
    $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Color\Color', $object->getObject());
  }

  public function testGenerateFromHex() {
    $object = ColorIndividual::generateFromHex('123456');
    $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual', $object);
    $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Color\Color', $object->getObject());
    $renderType = 'cli';
    $this->assertEquals('123456', $object->getObject()->render($renderType));
    $this->assertEquals('123456' . PHP_EOL, $object->render($renderType));
  }

  public function testRenderIndividual() {
    $object = new ColorIndividual(125, 125, 125);
    $object->setMutationFactor(0);
    $object->mutateProperties();
    $renderType = 'cli';

    $this->assertEquals('7D7D7D', $object->getObject()->render($renderType));
    $this->assertEquals('7D7D7D' . PHP_EOL, $object->render($renderType));
  }

  public function testMutateColorThroughIndividual() {
    $object = new ColorIndividual(125, 125, 125);
    $object->setMutationFactor(1);
    $object->mutateProperties();
    $renderType = 'cli';
    $this->assertNotEquals('125125125', $object->getObject()->render($renderType));
    $this->assertNotEquals('125125125' . PHP_EOL, $object->render($renderType));
  }

  public function testColorFitness() {
    $object = new ColorIndividual(255, 255, 255);
    $this->assertEquals(0, $object->getFitness());

    $object = new ColorIndividual(125, 125, 125);
    $this->assertEquals(5, $object->getFitness());
  }

  public function testColorMutation()
  {
    $object = new ColorIndividual(125, 125, 125);
    $object->mutateColor(1);
    $new_rgb = $object->getObject()->getRGB();
    $object->mutateColor(0.5);
  }

  public function testLargeColorMutation()
  {
    $object = new ColorIndividual(0, 0, 0);
    for ($i = 0; $i < 100; ++$i) {
      $object->mutateColor(100);

      $this->assertGreaterThanOrEqual(0, $object->getObject()->getRed());
      $this->assertLessThanOrEqual(255, $object->getObject()->getRed());

      $this->assertGreaterThanOrEqual(0, $object->getObject()->getGreen());
      $this->assertLessThanOrEqual(255, $object->getObject()->getGreen());

      $this->assertGreaterThanOrEqual(0, $object->getObject()->getBlue());
      $this->assertLessThanOrEqual(255, $object->getObject()->getBlue());
    }
  }
}
