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

    public function __testSortByHue()
    {
      // @todo : just refactor
        $colorColorPopulation = new ColorPopulation();

        $colorColorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 0, 255));
        $colorColorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 0, 0));
        $colorColorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 255, 0));
        $colorColorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 255, 0));
        $colorColorPopulation->addIndividual(ColorIndividual::generateFromRgb(255, 0, 0));
        $colorColorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 0, 255));

        $colorColorPopulation->sort();

        $this->assertStringEqualsFile('tests/Evolution/Population/data/color01.html', $colorColorPopulation->render());
    }

    public function __testSortByHueDescending()
    {
      // @todo : just refactor
        $colorColorPopulation = new ColorPopulation();

        $colorColorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 0, 255));
        $colorColorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 0, 0));
        $colorColorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 255, 0));
        $colorColorPopulation->addIndividual(ColorIndividual::generateFromRgb(255, 0, 0));
        $colorColorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 255, 0));
        $colorColorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 0, 255));

        $colorColorPopulation->sort('hue', 'DESC');

        // Need to bypass the normal render helper as there is an internal sort.
        $output = '';
        foreach ($colorColorPopulation->getIndividuals() as $individual) {
            $output .= $individual->render();
        }

        $this->assertStringEqualsFile('tests/Evolution/Population/data/color02.html', $output);
    }


    public function __testSortByEachType()
    {
      // @todo : just refactor
        $colorColorPopulation = new ColorPopulation();

        $colorColorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 0, 255));
        $colorColorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 0, 0));
        $colorColorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 255, 0));
        $colorColorPopulation->addIndividual(ColorIndividual::generateFromRgb(255, 0, 0));
        $colorColorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 255, 0));
        $colorColorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 0, 255));

        $colorColorPopulation->sort('hue');
        $colorColorPopulation->sort('hex');
        $colorColorPopulation->sort('intensity');
        $colorColorPopulation->sort('hsv_saturation');
        $colorColorPopulation->sort('hsl_saturation');
        $colorColorPopulation->sort('hsi_saturation');
        $colorColorPopulation->sort('value');
        $colorColorPopulation->sort('luma');
        $colorColorPopulation->sort('lightness');
        $colorColorPopulation->sort('fitness');

        // Need to bypass the normal render helper as there is an internal sort in the render() function.
        $output = '';
        foreach ($colorColorPopulation->getIndividuals() as $individual) {
            $output .= $individual->render();
        }

        $this->assertStringEqualsFile('tests/Evolution/Population/data/color03.html', $output);
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

    public function __testRenderTwoColors()
    {
      // @todo : refactor into decorator.
        $colorColorPopulation = new ColorPopulation();

      $colorColorPopulation->addIndividual(ColorIndividual::generateFromRgb(0, 0, 0));
        $colorColorPopulation->addIndividual(ColorIndividual::generateFromRgb(255, 255, 255));

        $colorColorPopulation->setDefaultRenderType('cli');

        $this->assertEquals('000000' . PHP_EOL . 'FFFFFF' . PHP_EOL, $colorColorPopulation->render());
    }
}
