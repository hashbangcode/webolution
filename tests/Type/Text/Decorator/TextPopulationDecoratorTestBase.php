<?php

namespace Hashbangcode\Webolution\Test\Type\Text\Decorator;

use Hashbangcode\Webolution\Evolution\Population\Decorators\TextPopulationDecoratorCli;
use Prophecy\Prophet;

class TextPopulationDecoratorTestBase extends \PHPUnit_Framework_TestCase
{
    protected $prophet;

    protected $textPopulation;

    public function setup()
    {
        $this->prophet = new Prophet();

        $text1 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Text\Text');
        $text1->getText()->willReturn('abc');

        $text2 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Text\Text');
        $text2->getText()->willReturn('def');

        $text3 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Text\Text');
        $text3->getText()->willReturn('ghi');

        $textPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Text\TextPopulation');

        $textIndividual1 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Type\Text\TextIndividual');
        $textIndividual1->getObject()->willReturn($text1);

        $textIndividual2 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Type\Text\TextIndividual');
        $textIndividual2->getObject()->willReturn($text2);

        $textIndividual3 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Type\Text\TextIndividual');
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
