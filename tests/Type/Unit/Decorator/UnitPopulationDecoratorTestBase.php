<?php

namespace Hashbangcode\Webolution\Test\Type\Unit\Decorator;

use Hashbangcode\Webolution\Type\Unit\Decorator\UnitPopulationDecoratorCli;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class UnitPopulationDecoratorTestBase extends TestCase
{
    protected $prophet;

    protected $textPopulation;

    public function setup()
    {
        $this->prophet = new Prophet();

        $text1 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Unit\Unit');
        $text1->getUnit()->willReturn('abc');

        $text2 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Unit\Unit');
        $text2->getUnit()->willReturn('def');

        $text3 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Unit\Unit');
        $text3->getUnit()->willReturn('ghi');

        $textPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Unit\UnitPopulation');

        $textIndividual1 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Type\Unit\UnitIndividual');
        $textIndividual1->getObject()->willReturn($text1);

        $textIndividual2 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Type\Unit\UnitIndividual');
        $textIndividual2->getObject()->willReturn($text2);

        $textIndividual3 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Type\Unit\UnitIndividual');
        $textIndividual3->getObject()->willReturn($text3);

        $individuals = [
            $textIndividual1,
            $textIndividual2,
            $textIndividual3,
        ];

        $textPopulation->getIndividuals()->willReturn($individuals);
        $textPopulation->getLength()->willReturn(3);
        $textPopulation->sort()->willReturn(null);

        $this->textPopulation = $textPopulation;
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
