<?php

use Hashbangcode\Wevolution\Type\Color\Collection;
use Hashbangcode\Wevolution\Type\Color\Color;

/**
 * Test class for Collection
 */
class CollectionTest extends PHPUnit_Framework_TestCase
{

  public function testEmptyCollection() {
    $colorCollection = new Collection();
    $this->assertEquals(0, $colorCollection->getLength());
  }

  public function testAddItemCollection() {
    $colorCollection = new Collection();

    $color = Color::generateRandomColor();

    $colorCollection->add($color);

    $this->assertEquals(1, $colorCollection->getLength());
  }

  public function testAddItemsToCollection() {
    $colorCollection = new Collection();

    $colorCollection->add(Color::generateRandomColor());
    $colorCollection->add(Color::generateRandomColor());
    $colorCollection->add(Color::generateRandomColor());

    $this->assertEquals(3, $colorCollection->getLength());
  }

  public function testSortByHue() {
    $colorCollection = new Collection();

    $colorCollection->add(new Color(0, 0, 255));
    $colorCollection->add(new Color(0, 0, 0));
    $colorCollection->add(new Color(0, 255, 0));
    $colorCollection->add(new Color(0, 255, 0));
    $colorCollection->add(new Color(0, 0, 255));

    $colorCollection->sort();

    //print $colorCollection->toString();
  }

  public function testColorIteration() {
    $colorCollection = new Collection();

    $colorCollection->add(Color::generateRandomColor());
    $colorCollection->add(Color::generateRandomColor());
    $colorCollection->add(Color::generateRandomColor());

    foreach ($colorCollection->getColors() as $color) {
      $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Color\Color', $color);
    }
  }
}
