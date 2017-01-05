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

  public function testGetRandomIndividual() {
    $numberPopulation = new NumberPopulation();
    $numberPopulation->addIndividual();
    $this->assertEquals(1, $numberPopulation->getLength());
    $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual', $numberPopulation->getRandomIndividual());
  }

  public function testAddItemsToNumberPopulation() {
    $numberPopulation = new NumberPopulation();

    $numberPopulation->addIndividual();
    $numberPopulation->addIndividual();
    $numberPopulation->addIndividual();

    $this->assertEquals(3, $numberPopulation->getLength());
  }

  public function testDefaultSort() {
    $numberPopulation = new NumberPopulation();

    $numberPopulation->addIndividual(new NumberIndividual(1));
    $numberPopulation->addIndividual(new NumberIndividual(2));
    $numberPopulation->addIndividual(new NumberIndividual(3));
    $numberPopulation->addIndividual(new NumberIndividual(4));
    $numberPopulation->addIndividual(new NumberIndividual(5));

    $numberPopulation->sort();
  }

  public function testNumberIteration() {
    $numberPopulation = new NumberPopulation();

    $numberPopulation->addIndividual(NumberIndividual::generateRandomNumber());
    $numberPopulation->addIndividual(NumberIndividual::generateRandomNumber());
    $numberPopulation->addIndividual(NumberIndividual::generateRandomNumber());

    $population = $numberPopulation->getIndividuals();

    foreach ($population[0]->getObject() as $number) {
      $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Number\Number', $number);
    }
  }
}
