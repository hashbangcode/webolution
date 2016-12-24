<?php

use Hashbangcode\Wevolution\Evolution\Population\StylePopulation;
use Hashbangcode\Wevolution\Evolution\Individual\StyleIndividual;

class StylePopulationTest extends \PHPUnit_Framework_TestCase {

  public function testEmptyNumberPopulation() {
    $numberPopulation = new StylePopulation();
    $this->assertEquals(0, $numberPopulation->getLength());
  }
}
