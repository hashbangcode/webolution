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

        $numberIndividual1 = $this->prophet
            ->prophesize('Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual');
        $numberIndividual1->getFitness()->willReturn(5);

        $numberIndividual2 = $this->prophet
            ->prophesize('Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual');
        $numberIndividual2->getFitness()->willReturn(5);

        $individuals = [
            $numberIndividual1,
            $numberIndividual2,
        ];

        $numberPopulation->getIndividuals()->willReturn($individuals);
        $numberPopulation->getLength()->willReturn(2);

        $this->assertEquals(5, $statistics->calculateMeanFitness($numberPopulation->reveal()));
        $this->assertEquals(5, $statistics->getMeanFitness());
    }

    public function testSetMaxIndividual()
    {
        $statistics = new Statistics();
        $numberIndividual = $this->prophet
            ->prophesize('Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual');
        $numberIndividual->getFitness()->willReturn(1);

        $statistics->setMaxFitnessIndividual($numberIndividual->reveal());

        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual', $statistics->getMaxFitnessIndividual());
        $this->assertEquals(1, $statistics->getMaxFitness());
    }

    public function testSetMinIndividual()
    {
        $statistics = new Statistics();
        $numberIndividual = $this->prophet
            ->prophesize('Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual');
        $numberIndividual->getFitness()->willReturn(1);

        $statistics->setMinFitnessIndividual($numberIndividual->reveal());

        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual', $statistics->getMinFitnessIndividual());
        $this->assertEquals(1, $statistics->getMinFitness());
    }

    public function testSetMedianIndividual()
    {
        $statistics = new Statistics();
        $numberIndividual2 = $this->prophet
            ->prophesize('Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual');

        $statistics->setMedianFitnessIndividual($numberIndividual2->reveal());
        $this->assertInstanceOf('Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual', $statistics->getMedianFitnessIndividual());
    }

    public function testExtractFitnessIndividuals()
    {
        $statistics = new Statistics();
        $numberPopulation = $this->prophet->prophesize('Hashbangcode\Wevolution\Evolution\Population\NumberPopulation');

        $numberIndividual1 = $this->prophet
            ->prophesize('Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual');
        $numberIndividual1->getFitness()->willReturn(1);

        $numberIndividual2 = $this->prophet
            ->prophesize('Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual');
        $numberIndividual2->getFitness()->willReturn(2);

        $numberIndividual3 = $this->prophet
            ->prophesize('Hashbangcode\Wevolution\Evolution\Individual\NumberIndividual');
        $numberIndividual3->getFitness()->willReturn(3);

        $individuals = [
            $numberIndividual1,
            $numberIndividual2,
            $numberIndividual3,
        ];

        $numberPopulation->getIndividuals()->willReturn($individuals);
        $numberPopulation->getLength()->willReturn(3);
        $numberPopulation->sort()->willReturn(NULL);

        $statistics->extractFitnessIndividuals($numberPopulation->reveal());

        $this->assertEquals(1, $statistics->getMinFitnessIndividual()->getFitness());
        $this->assertEquals(1, $statistics->getMinFitness());

        $this->assertEquals(3, $statistics->getMaxFitnessIndividual()->getFitness());
        $this->assertEquals(3, $statistics->getMaxFitness());

        $this->assertEquals(2, $statistics->getMedianFitnessIndividual()->getFitness());
    }

    protected function tearDown()
    {
        $this->prophet->checkPredictions();
    }
}
