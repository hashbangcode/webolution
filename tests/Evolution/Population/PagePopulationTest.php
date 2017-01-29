<?php

use Hashbangcode\Wevolution\Evolution\Population\PagePopulation;
use Hashbangcode\Wevolution\Evolution\Individual\PageIndividual;

class PagePopulationTest extends \PHPUnit_Framework_TestCase {


  public function testCreateObject() {
    $object = new PagePopulation();
    $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Population\PagePopulation', $object);
  }
}