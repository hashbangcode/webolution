<?php

use Hashbangcode\Wevolution\Evolution\NumberEvolution;

/**
 * Test class for ColorEvolution
 */
class NumberEvolutionTest extends PHPUnit_Framework_TestCase
{

  public function testCreateColorIndividual() {
    $object = new NumberEvolution();
    $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\NumberEvolution', $object);
  }

  public function testRunSingleGeneration() {
    $object = new NumberEvolution();
    /*$object->runGeneration();
    $this->assertEquals(1, $object->getCurrentGeneration());
    $object->runGeneration();
    $this->assertEquals(2, $object->getCurrentGeneration());*/
  }
}
