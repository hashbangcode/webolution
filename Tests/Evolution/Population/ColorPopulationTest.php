<?php

use Hashbangcode\Wevolution\Evolution\Population\ColorPopulation;
use Hashbangcode\Wevolution\Type\Color\Color;
use Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual;

class ColorPopulationTest extends \PHPUnit_Framework_TestCase {

  public function testEmptyColorPopulation() {
    $colorColorPopulation = new ColorPopulation();
    $this->assertEquals(0, $colorColorPopulation->getLength());
  }

  public function testAddItemColorPopulation() {
    $colorColorPopulation = new ColorPopulation();
    $colorColorPopulation->addIndividual();
    $this->assertEquals(1, $colorColorPopulation->getLength());
  }

  public function testAddItemsToColorPopulation() {
    $colorColorPopulation = new ColorPopulation();

    $colorColorPopulation->addIndividual();
    $colorColorPopulation->addIndividual();
    $colorColorPopulation->addIndividual();

    $this->assertEquals(3, $colorColorPopulation->getLength());
  }

  public function testSortByHue() {
    $colorColorPopulation = new ColorPopulation();

    $colorColorPopulation->addIndividual(new ColorIndividual(0, 0, 255));
    $colorColorPopulation->addIndividual(new ColorIndividual(0, 0, 0));
    $colorColorPopulation->addIndividual(new ColorIndividual(0, 255, 0));
    $colorColorPopulation->addIndividual(new ColorIndividual(0, 255, 0));
    $colorColorPopulation->addIndividual(new ColorIndividual(0, 0, 255));

    $colorColorPopulation->sort();
  }

  public function testColorIteration() {
    $colorColorPopulation = new ColorPopulation();

    $colorColorPopulation->addIndividual(ColorIndividual::generateRandomColor());
    $colorColorPopulation->addIndividual(ColorIndividual::generateRandomColor());
    $colorColorPopulation->addIndividual(ColorIndividual::generateRandomColor());

    $population = $colorColorPopulation->getPopulation();

    foreach ($population[0]->getObject() as $color) {
      $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Color\Color', $color);
    }
  }

}
