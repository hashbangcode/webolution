<?php

require_once '../includes/Color.php';
require_once '../includes/ColorCollection.php';

/**
 * Test class for ColorCollection
 */
class ColorCollectionTest extends PHPUnit_Framework_TestCase
{

  public function testEmptyCollection() {
    $colorCollection = new ColorCollection();
    $this->assertEquals(0, $colorCollection->getLength());
  }

  public function testAddItemCollection() {
    $colorCollection = new ColorCollection();

    $color = Color::generateRandomColor();

    $colorCollection->add($color);

    $this->assertEquals(1, $colorCollection->getLength());
  }

  public function testAddItemsToCollection() {
    $colorCollection = new ColorCollection();

    $colorCollection->add(Color::generateRandomColor());
    $colorCollection->add(Color::generateRandomColor());
    $colorCollection->add(Color::generateRandomColor());

    $this->assertEquals(3, $colorCollection->getLength());
  }

  public function testSortByHue() {
    $colorCollection = new ColorCollection();

    $colorCollection->add(new Color(0, 0, 255));
    $colorCollection->add(new Color(0, 0, 0));
    $colorCollection->add(new Color(0, 255, 0));
    $colorCollection->add(new Color(0, 255, 0));
    $colorCollection->add(new Color(0, 0, 255));

    $colorCollection->sort();

    //print $colorCollection->toString();
  }

  public function testColorIteration() {
    $colorCollection = new ColorCollection();

    $colorCollection->add(Color::generateRandomColor());
    $colorCollection->add(Color::generateRandomColor());
    $colorCollection->add(Color::generateRandomColor());

    foreach ($colorCollection->getColors() as $color) {
      $this->assertInstanceOf('Color', $color);
    }
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
