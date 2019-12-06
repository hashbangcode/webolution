<?php

namespace Hashbangcode\Webolution\Test\Type\Unit\Decorator;

use Hashbangcode\Webolution\Type\Unit\Decorator\UnitPopulationDecoratorCli;
use Prophecy\Prophet;
use PHPUnit\Framework\TestCase;

class UnitPopulationDecoratorTestBase extends TestCase
{
    protected $prophet;

    protected $unitPopulation;

    public function setup()
    {
        $this->prophet = new Prophet();

        $unit1 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Unit\Unit');
        $unit1->getUnit()->willReturn('em');
        $unit1->getNumber()->willReturn(1);

        $unit2 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Unit\Unit');
        $unit2->getUnit()->willReturn('px');
        $unit2->getNumber()->willReturn(1);
        
        $unit3 = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Unit\Unit');
        $unit3->getUnit()->willReturn('%');
        $unit3->getNumber()->willReturn(1);

        $unitPopulation = $this->prophet->prophesize('Hashbangcode\Webolution\Type\Unit\UnitPopulation');

        $unitIndividual1 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Type\Unit\UnitIndividual');
        $unitIndividual1->getObject()->willReturn($unit1);

        $unitIndividual2 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Type\Unit\UnitIndividual');
        $unitIndividual2->getObject()->willReturn($unit2);

        $unitIndividual3 = $this->prophet
            ->prophesize('Hashbangcode\Webolution\Type\Unit\UnitIndividual');
        $unitIndividual3->getObject()->willReturn($unit3);

        $individuals = [
            $unitIndividual1,
            $unitIndividual2,
            $unitIndividual3,
        ];

        $unitPopulation->getIndividuals()->willReturn($individuals);
        $unitPopulation->getIndividualCount()->willReturn(3);
        $unitPopulation->sort()->willReturn(null);

        $this->unitPopulation = $unitPopulation;
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
