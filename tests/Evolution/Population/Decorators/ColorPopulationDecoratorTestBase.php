<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Population\Decorators;

use Hashbangcode\Wevolution\Evolution\Population\Decorators\ColorPopulationDecoratorCli;
use Prophecy\Prophet;

class ColorPopulationDecoratorTestBase extends \PHPUnit_Framework_TestCase
{
    protected $prophet;

    protected $colorPopulation;

    public function setup()
    {
        $this->prophet = new Prophet();

        $color1 = $this->prophet->prophesize('Hashbangcode\Wevolution\Type\Color\Color');
        $color1->getHex()->willReturn('000');

        $color2 = $this->prophet->prophesize('Hashbangcode\Wevolution\Type\Color\Color');
        $color2->getHex()->willReturn('555');

        $color3 = $this->prophet->prophesize('Hashbangcode\Wevolution\Type\Color\Color');
        $color3->getHex()->willReturn('fff');

        $colorPopulation = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Population\ColorPopulation');

        $colorIndividual1 = $this->prophet
            ->prophesize('Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual');
        $colorIndividual1->getObject()->willReturn($color1);

        $colorIndividual2 = $this->prophet
            ->prophesize('Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual');
        $colorIndividual2->getObject()->willReturn($color2);

        $colorIndividual3 = $this->prophet
            ->prophesize('Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual');
        $colorIndividual3->getObject()->willReturn($color3);

        $individuals = [
            $colorIndividual1,
            $colorIndividual2,
            $colorIndividual3,
        ];

        $colorPopulation->getIndividuals()->willReturn($individuals);
        $colorPopulation->getLength()->willReturn(3);
        $colorPopulation->sort()->willReturn(null);

        $this->colorPopulation = $colorPopulation;
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
