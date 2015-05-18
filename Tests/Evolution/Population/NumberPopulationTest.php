<?php

use Hashbangcode\Wevolution\Evolution\Population\NumberPopulation;
use Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual;

class NumberPopulationTest extends \PHPUnit_Framework_TestCase {

  public function testEmptyNumberPopulation() {
    $numberPopulation = new NumberPopulation();
    $this->assertEquals(0, $numberPopulation->getLength());
  }

  public function testAddItemNumberPopulation() {
    $numberPopulation = new NumberPopulation();
    $numberPopulation->addIndividual();
    $this->assertEquals(1, $numberPopulation->getLength());
  }

  public function testAddItemsToNumberPopulation() {
    $numberPopulation = new NumberPopulation();

    $numberPopulation->addIndividual();
    $numberPopulation->addIndividual();
    $numberPopulation->addIndividual();

    $this->assertEquals(3, $numberPopulation->getLength());
  }

  public function testSortByHue() {
    $numberPopulation = new NumberPopulation();

    $numberPopulation->addIndividual(new NumberIndividual(1));
    $numberPopulation->addIndividual(new NumberIndividual(2));
    $numberPopulation->addIndividual(new NumberIndividual(3));
    $numberPopulation->addIndividual(new NumberIndividual(4));
    $numberPopulation->addIndividual(new NumberIndividual(5));

    $numberPopulation->sort();
  }

  public function testColorIteration() {
    $numberPopulation = new NumberPopulation();

    $numberPopulation->addIndividual(NumberIndividual::generateRandomNumber());
    $numberPopulation->addIndividual(NumberIndividual::generateRandomNumber());
    $numberPopulation->addIndividual(NumberIndividual::generateRandomNumber());

    $population = $numberPopulation->getPopulation();

    foreach ($population[0]->getObject() as $color) {
      $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Number\Number', $color);
    }
  }
}
