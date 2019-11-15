<?php

namespace Hashbangcode\Webolution\Test\Type\Style\Decorator;

use Hashbangcode\Webolution\Type\Style\Decorator\StylePopulationDecoratorCli;
use Prophecy\Prophet;

class StylePopulationDecoratorTestBase extends \PHPUnit_Framework_TestCase
{
    protected $prophet;

    protected $textPopulation;

    public function setup()
    {
        $this->prophet = new Prophet();

        $text1 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Style\Style');
        $text1->getSelector()->willReturn('div');
        $text1->getAttributes()->willReturn(['color' => 'red']);

        $text2 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Style\Style');
        $text2->getSelector()->willReturn('p');
        $text2->getAttributes()->willReturn(['color' => 'red']);

        $text3 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Style\Style');
        $text3->getSelector()->willReturn('div.test');
        $text3->getAttributes()->willReturn(['color' => 'red']);

        $textPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Style\StylePopulation');

        $textIndividual1 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Type\Style\StyleIndividual');
        $textIndividual1->getObject()->willReturn($text1);

        $textIndividual2 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Type\Style\StyleIndividual');
        $textIndividual2->getObject()->willReturn($text2);

        $textIndividual3 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Type\Style\StyleIndividual');
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
