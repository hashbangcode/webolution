<?php

require_once '../includes/Color.php';
require_once '../includes/EvolutionColor.php';

/**
 * Test class for Color
 */
class EvolutionColorTest extends PHPUnit_Framework_TestCase
{

  public function testEvolutionColer()
  {
    $evolution_color = new EvolutionColor(1000, 5);
    $evolution_color->start();
  }

  /**
   * Sets up the fixture, for example, opens a network connection.
   * This method is called before a test is executed.
   */
  protected function setUp()
  {

  }

  /**
   * Tears down the fixture, for example, closes a network connection.
   * This method is called after a test is executed.
   */
  protected function tearDown()
  {

  }

}
