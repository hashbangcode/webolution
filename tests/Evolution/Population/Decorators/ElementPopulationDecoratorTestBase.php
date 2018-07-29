<?php

namespace Hashbangcode\Webolution\Test\Evolution\Population\Decorators;

use Hashbangcode\Webolution\Evolution\Population\Decorators\ElementPopulationDecoratorCli;
use Prophecy\Prophet;

class ElementPopulationDecoratorTestBase extends \PHPUnit_Framework_TestCase
{
    protected $prophet;

    protected $textPopulation;

    public function setup()
    {
        $this->prophet = new Prophet();

        $text1 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Element\Element');
        $text1->getType()->willReturn('div');
        $text1->getAttributes()->willReturn(['class' => 'testdiv']);
        $text1->getChildren()->willReturn([]);
        $text1->getElementText()->willReturn('');

        $text2 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Element\Element');
        $text2->getType()->willReturn('p');
        $text2->getAttributes()->willReturn(['class' => 'testp']);
        $text2->getChildren()->willReturn([]);
        $text2->getElementText()->willReturn('text');

        $text3 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Element\Element');
        $text3->getType()->willReturn('div');
        $text3->getAttributes()->willReturn(['class' => 'testdiv2']);
        $text3->getChildren()->willReturn([]);
        $text3->getElementText()->willReturn('');

        $textPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Evolution\Population\ElementPopulation');

        $textIndividual1 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Evolution\Individual\ElementIndividual');
        $textIndividual1->getObject()->willReturn($text1);

        $textIndividual2 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Evolution\Individual\ElementIndividual');
        $textIndividual2->getObject()->willReturn($text2);

        $textIndividual3 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Evolution\Individual\ElementIndividual');
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
