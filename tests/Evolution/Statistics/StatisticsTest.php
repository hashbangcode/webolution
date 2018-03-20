<?php

namespace Hashbangcode\Wevolution\Test\Evolution\Statistics;

use Hashbangcode\Wevolution\Evolution\Statistics\Statistics;
use Prophecy\Prophet;

class StatisticsTest extends \PHPUnit_Framework_TestCase
{

    private $prophet;

    public function setup()
    {
        $this->prophet = new Prophet();
    }

    public function testStatisticsObjectCreation()
    {
        $statistics = new Statistics();
        $this->assertInstanceOf('\Hashbangcode\Wevolution\Evolution\Statistics\Statistics', $statistics);
    }

    public function testSetMaxFitness()
    {
        $statistics = new Statistics();
        $statistics->setMaxFitness(10);
        $this->assertEquals(10, $statistics->getMaxFitness());
    }

    public function testSetMinFitness()
    {
        $statistics = new Statistics();
        $statistics->setMinFitness(10);
        $this->assertEquals(10, $statistics->getMinFitness());
    }

    public function testSetMeanFitness()
    {
        $statistics = new Statistics();
        $statistics->setMeanFitness(10);
        $this->assertEquals(10, $statistics->getMeanFitness());
    }

    public function testCalculateMeanFitness()
    {
        $statistics = new Statistics();
        $numberPopulation = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Population\NumberPopulation');

        $numberIndividual1 = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual');
        $numberIndividual1->getFitness()->willReturn(5);

        $numberIndividual2 = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual');
        $numberIndividual2->getFitness()->willReturn(5);

        $individuals = [
            $numberIndividual1,
            $numberIndividual2,
        ];

        $numberPopulation->getIndividuals()->willReturn($individuals);
        $numberPopulation->getLength()->willReturn(2);

        $this->assertEquals(5, $statistics->calculateMeanFitness($numberPopulation->reveal()));
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
