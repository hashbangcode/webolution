<?php

namespace Hashbangcode\Webolution\Test\Type\Number\Decorator;

use Hashbangcode\Webolution\Type\Number\Decorator\NumberPopulationDecoratorCli;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class NumberPopulationDecoratorTestBase extends TestCase
{

    protected $prophet;

    protected $numberPopulation;

    public function setup()
    {
        $this->prophet = new Prophet();

        $number1 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Number\Number');
        $number1->getNumber()->willReturn(1);

        $number2 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Number\Number');
        $number2->getNumber()->willReturn(2);

        $number3 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Number\Number');
        $number3->getNumber()->willReturn(3);

        $numberPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Number\NumberPopulation');

        $numberIndividual1 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Type\Number\NumberIndividual');
        $numberIndividual1->getObject()->willReturn($number1);

        $numberIndividual2 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Type\Number\NumberIndividual');
        $numberIndividual2->getObject()->willReturn($number2);

        $numberIndividual3 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Type\Number\NumberIndividual');
        $numberIndividual3->getObject()->willReturn($number3);

        $individuals = [
            $numberIndividual1,
            $numberIndividual2,
            $numberIndividual3,
        ];

        $numberPopulation->getIndividuals()->willReturn($individuals);
        $numberPopulation->getIndividualCount()->willReturn(3);
        $numberPopulation->sort()->willReturn(null);

        $this->numberPopulation = $numberPopulation;
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
