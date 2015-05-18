<?php

use Hashbangcode\Wevolution\Evolution\Evolution;
use Hashbangcode\Wevolution\Evolution\Population\NumberPopulation;
use Hashbangcode\Wevolution\Evolution\Population\ColorPopulation;

class EvolutionTest extends \PHPUnit_Framework_TestCase {

  public function testEvolutionNumber()
  {
    $numberPopulation = new NumberPopulation();
    $evolution = new Evolution($numberPopulation);

    $population = $evolution->getCurrentPopulation();
    $this->assertEquals($evolution->getIndividualsPerGeneration(), $population->getLength());
  }

  public function testEvolutionColor()
  {
    $colorPopulation = new ColorPopulation();
    $evolution = new Evolution($colorPopulation);

    $population = $evolution->getCurrentPopulation();
    $this->assertEquals($evolution->getIndividualsPerGeneration(), $population->getLength());
  }

}
