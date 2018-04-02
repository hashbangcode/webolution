<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Population\ColorPopulation;
use Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual;

class ColorPopulationTest extends \PHPUnit_Framework_TestCase
{

    public function testEmptyColorPopulation()
    {
        $colorColorPopulation = new ColorPopulation();
        $this->assertEquals(0, $colorColorPopulation->getLength());
    }

    public function testAddItemColorPopulation()
    {
        $colorColorPopulation = new ColorPopulation();
        $colorColorPopulation->addIndividual();
        $this->assertEquals(1, $colorColorPopulation->getLength());
    }

    public function testAddItemsToColorPopulation()
    {
        $colorColorPopulation = new ColorPopulation();

        $colorColorPopulation->addIndividual();
        $colorColorPopulation->addIndividual();
        $colorColorPopulation->addIndividual();

        $this->assertEquals(3, $colorColorPopulation->getLength());
    }

    public function testColorIteration()
    {
        $colorColorPopulation = new ColorPopulation();

        $colorColorPopulation->addIndividual(ColorIndividual::generateRandomColor());
        $colorColorPopulation->addIndividual(ColorIndividual::generateRandomColor());
        $colorColorPopulation->addIndividual(ColorIndividual::generateRandomColor());

        $population = $colorColorPopulation->getIndividuals();

        foreach ($population as $color) {
            $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Color\Color', $color->getObject());
        }
    }

    public function testGetRandomIndividual()
    {
        $colorColorPopulation = new ColorPopulation();

        $colorColorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 0, 255));
        $colorColorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 0, 0));
        $colorColorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 255, 0));
        $colorColorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 255, 0));
        $colorColorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 0, 255));

        $object = $colorColorPopulation->getRandomIndividual();
        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Wevolution\Type\Color\Color', $object->getObject());
    }
}
