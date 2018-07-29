<?php

namespace Hashbangcode\Webolution\Test\Evolution\Population\Decorators;

use Hashbangcode\Webolution\Evolution\Population\Decorators\UnitPopulationDecoratorCli;
use Prophecy\Prophet;

class UnitPopulationDecoratorTestBase extends \PHPUnit_Framework_TestCase
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

        $textPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Evolution\Population\UnitPopulation');

        $textIndividual1 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Evolution\Individual\UnitIndividual');
        $textIndividual1->getObject()->willReturn($text1);

        $textIndividual2 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Evolution\Individual\UnitIndividual');
        $textIndividual2->getObject()->willReturn($text2);

        $textIndividual3 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Evolution\Individual\UnitIndividual');
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
