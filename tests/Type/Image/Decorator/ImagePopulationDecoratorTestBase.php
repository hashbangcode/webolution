<?php

namespace Hashbangcode\Webolution\Test\Type\Image\Decorator;

use Hashbangcode\Webolution\Type\Image\Decorator\ImagePopulationDecoratorCli;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class ImagePopulationDecoratorTestBase extends TestCase
{

    protected $prophet;

    protected $imagePopulation;

    public function setup(): void
    {
        $this->prophet = new Prophet();

        $imageMatrix = array_fill_keys(range(0, 9), 0);
        foreach ($imageMatrix as $id => $imagePart) {
            $imageMatrix[$id] = array_fill_keys(range(0, 9), 0);
        }

        $image1 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Image\Image');
        $image1->getImageMatrix()->willReturn($imageMatrix);

        $image2 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Image\Image');
        $image2->getImageMatrix()->willReturn($imageMatrix);

        $image3 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Image\Image');
        $image3->getImageMatrix()->willReturn($imageMatrix);

        $imagePopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Image\ImagePopulation');

        $imageIndividual1 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Type\Image\ImageIndividual');
        $imageIndividual1->getObject()->willReturn($image1);

        $imageIndividual2 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Type\Image\ImageIndividual');
        $imageIndividual2->getObject()->willReturn($image2);

        $imageIndividual3 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Type\Image\ImageIndividual');
        $imageIndividual3->getObject()->willReturn($image3);

        $individuals = [
            $imageIndividual1,
            $imageIndividual2,
            $imageIndividual3,
        ];

        $imagePopulation->getIndividuals()->willReturn($individuals);
        $imagePopulation->getIndividualCount()->willReturn(3);
        $imagePopulation->sort()->willReturn(null);

        $this->imagePopulation = $imagePopulation;
    }

    protected function tearDown(): void
    {
        $this->prophet->checkPredictions();
    }
}
