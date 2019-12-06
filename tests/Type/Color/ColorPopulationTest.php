<?php

namespace Hashbangcode\Webolution\Test\Type\Color;

use Hashbangcode\Webolution\Type\Color\ColorFactory;
use Hashbangcode\Webolution\Type\Color\ColorPopulation;
use Hashbangcode\Webolution\Type\Color\ColorIndividual;
use PHPUnit\Framework\TestCase;

class ColorPopulationTest extends TestCase
{

    public function testEmptyColorPopulation()
    {
        $colorPopulation = new ColorPopulation();
        $this->assertEquals(0, $colorPopulation->getIndividualCount());
    }

    public function testAddItemColorPopulation()
    {
        $colorPopulation = new ColorPopulation();
        $colorPopulation->addIndividual();
        $this->assertEquals(1, $colorPopulation->getIndividualCount());
    }

    public function testAddItemsToColorPopulation()
    {
        $colorPopulation = new ColorPopulation();

        $colorPopulation->addIndividual();
        $colorPopulation->addIndividual();
        $colorPopulation->addIndividual();

        $this->assertEquals(3, $colorPopulation->getIndividualCount());
    }

    public function testColorIteration()
    {
        $colorPopulation = new ColorPopulation();

        $colorPopulation->addIndividual(ColorIndividual::generateRandomColor());
        $colorPopulation->addIndividual(ColorIndividual::generateRandomColor());
        $colorPopulation->addIndividual(ColorIndividual::generateRandomColor());

        $population = $colorPopulation->getIndividuals();

        foreach ($population as $color) {
            $this->assertInstanceOf('Hashbangcode\Webolution\Type\Color\Color', $color->getObject());
        }
    }

    public function testGetRandomIndividual()
    {
        $colorPopulation = new ColorPopulation();

        $colorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 0, 255));
        $colorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 0, 0));
        $colorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 255, 0));
        $colorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 255, 0));
        $colorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 0, 255));

        $object = $colorPopulation->getRandomIndividual();
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Color\ColorIndividual', $object);
        $this->assertInstanceOf('Hashbangcode\Webolution\Type\Color\Color', $object->getObject());
    }

    public function testCrossover() {
        $colorPopulation = new ColorPopulation();

        $color1 = ColorFactory::generateFromHex('000000');
        $colorPopulation->addIndividual(new ColorIndividual($color1));

        $color2 = ColorFactory::generateFromHex('FFFFFF');
        $colorPopulation->addIndividual(new ColorIndividual($color2));

        $colorPopulation->crossover();

        $individuals = $colorPopulation->getIndividuals();

        $this->assertEquals('0F0F0F', $individuals[2]->getObject()->getHex());
    }
}
