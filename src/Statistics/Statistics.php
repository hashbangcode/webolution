<?php

namespace Hashbangcode\Webolution\Statistics;

use Hashbangcode\Webolution\PopulationInterface;

/**
 * Class Statistics.
 *
 * @package Hashbangcode\Webolution
 */
class Statistics implements StatisticsInterface
{
    /**
     * @var int The max fitness.
     */
    protected $maxFitness = 0;

    /**
     * @var int The min fitness.
     */
    protected $minFitness = 0;

    /**
     * @var int The median fitness.
     */
    protected $medianFitness = 0;

    /**
     * @var int The mean fitness.
     */
    protected $meanFitness = 0;

    /**
     * @var \Hashbangcode\Webolution\Individual|null Max fitness Individual.
     */
    protected $maxFitnessIndividual;

    /**
     * @var \Hashbangcode\Webolution\Individual|null Min fitness Individual.
     */
    protected $minFitnessIndividual;

    /**
     * @var \Hashbangcode\Webolution\Individual|null Median fitness Individual.
     */
    protected $medianFitnessIndividual;

    /**
     * {@inheritdoc}
     */
    public function getMedianFitness(): float
    {
        return $this->medianFitness;
    }

    /**
     * {@inheritdoc}
     */
    public function setMedianFitness(float $medianFitness)
    {
        $this->medianFitness = $medianFitness;
    }

    /**
     * {@inheritdoc}
     */
    public function getMedianFitnessIndividual()
    {
        return $this->medianFitnessIndividual;
    }

    /**
     * {@inheritdoc}
     */
    public function setMedianFitnessIndividual($medianFitnessIndividual)
    {
        $this->medianFitnessIndividual = $medianFitnessIndividual;
        $this->setMedianFitness($medianFitnessIndividual->getFitness());
    }

    /**
     * {@inheritdoc}
     */
    public function getMinFitness(): float
    {
        return $this->minFitness;
    }

    /**
     * {@inheritdoc}
     */
    public function setMinFitness(float $minFitness)
    {
        $this->minFitness = $minFitness;
    }

    /**
     * {@inheritdoc}
     */
    public function getMaxFitness(): float
    {
        return $this->maxFitness;
    }

    /**
     * {@inheritdoc}
     */
    public function setMaxFitness(float $maxFitness)
    {
        $this->maxFitness = $maxFitness;
    }

    /**
     * {@inheritdoc}
     */
    public function calculateMeanFitness(PopulationInterface $population)
    {
        $fitnessSum = 0;
        foreach ($population->getIndividuals() as $individual) {
            $fitnessSum += $individual->getFitness();
        }
        $this->setMeanFitness($fitnessSum / $population->getIndividualCount());
        return $this->getMeanFitness();
    }

    /**
     * {@inheritdoc}
     */
    public function getMeanFitness(): float
    {
        return $this->meanFitness;
    }

    /**
     * {@inheritdoc}
     */
    public function setMeanFitness(float $meanFitness)
    {
        $this->meanFitness = $meanFitness;
    }

    /**
     * {@inheritdoc}
     */
    public function extractFitnessIndividuals(PopulationInterface $population)
    {
        // Sort the current population.
        $population->sort();

        foreach ($population->getIndividuals() as $key => $individual) {
            $fitness = $individual->getFitness();

            // Store Max.
            if (!is_object($this->getMaxFitnessIndividual())
                || $fitness > $this->getMaxFitnessIndividual()->getFitness()
            ) {
                $this->setMaxFitnessIndividual($individual);
            }

            // Store Min.
            if (!is_object($this->getMinFitnessIndividual())
                || $fitness < $this->getMinFitnessIndividual()->getFitness()
            ) {
                $this->setMinFitnessIndividual($individual);
            }
        }

        // Get Median.
        $individuals = $population->getIndividuals();
        $slicedArray = array_slice($individuals, (int) floor(count($individuals) / 2), 1);
        $this->setMedianFitnessIndividual(array_pop($slicedArray));

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function getMaxFitnessIndividual()
    {
        return $this->maxFitnessIndividual;
    }

    /**
     * {@inheritdoc}
     */
    public function setMaxFitnessIndividual($maxFitnessIndividual)
    {
        $this->maxFitnessIndividual = $maxFitnessIndividual;
        $this->setMaxFitness($maxFitnessIndividual->getFitness());
    }

    /**
     * {@inheritdoc}
     */
    public function getMinFitnessIndividual()
    {
        return $this->minFitnessIndividual;
    }

    /**
     * {@inheritdoc}
     */
    public function setMinFitnessIndividual($minFitnessIndividual)
    {
        $this->minFitnessIndividual = $minFitnessIndividual;
        $this->setMinFitness($minFitnessIndividual->getFitness());
    }
}
