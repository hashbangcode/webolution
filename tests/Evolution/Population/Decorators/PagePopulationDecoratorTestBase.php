<?php

namespace Hashbangcode\Webolution\Test\Evolution\Population\Decorators;

use Hashbangcode\Webolution\Evolution\Population\Decorators\PagePopulationDecoratorCli;
use Prophecy\Prophet;

class PagePopulationDecoratorTestBase extends \PHPUnit_Framework_TestCase
{
    protected $prophet;

    protected $textPopulation;

    public function setup()
    {
        $this->prophet = new Prophet();

        $text1 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Page\Page');
        $text1->getBody()->willReturn();
        $text1->getStyles()->willReturn();

        $text2 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Page\Page');
        $text2->getBody()->willReturn();
        $text2->getStyles()->willReturn();

        $text3 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Page\Page');
        $text3->getBody()->willReturn();
        $text3->getStyles()->willReturn();

        $textPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Evolution\Population\PagePopulation');

        $textIndividual1 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Evolution\Individual\PageIndividual');
        $textIndividual1->getObject()->willReturn($text1);

        $textIndividual2 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Evolution\Individual\PageIndividual');
        $textIndividual2->getObject()->willReturn($text2);

        $textIndividual3 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Evolution\Individual\PageIndividual');
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
