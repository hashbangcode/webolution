<?php

namespace Hashbangcode\Webolution\Test\Type\Color\Decorator;

use Hashbangcode\Webolution\Type\Color\Decorator\ColorPopulationDecoratorCli;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class ColorPopulationDecoratorTestBase extends TestCase
{
    protected $prophet;

    protected $colorPopulation;

    public function setup(): void
    {
        $this->prophet = new Prophet();

        $color1 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Color\Color');
        $color1->getHex()->willReturn('000');

        $color2 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Color\Color');
        $color2->getHex()->willReturn('555');

        $color3 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Color\Color');
        $color3->getHex()->willReturn('fff');

        $colorPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Color\ColorPopulation');

        $colorIndividual1 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Type\Color\ColorIndividual');
        $colorIndividual1->getObject()->willReturn($color1);

        $colorIndividual2 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Type\Color\ColorIndividual');
        $colorIndividual2->getObject()->willReturn($color2);

        $colorIndividual3 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Type\Color\ColorIndividual');
        $colorIndividual3->getObject()->willReturn($color3);

        $individuals = [
            $colorIndividual1,
            $colorIndividual2,
            $colorIndividual3,
        ];

        $colorPopulation->getIndividuals()->willReturn($individuals);
        $colorPopulation->getIndividualCount()->willReturn(3);
        $colorPopulation->sort()->willReturn(null);

        $this->colorPopulation = $colorPopulation;
    }

    protected function tearDown(): void
    {
        $this->prophet->checkPredictions();
    }
}
