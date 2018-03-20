<?php

namespace Hashbangcode\Wevolution\Evolution\Statistics;

use Hashbangcode\Wevolution\Evolution\Population\PopulationInterface;

/**
 * Class Statistics.
 *
 * @package Hashbangcode\Wevolution\Evolution
 */
class Statistics
{
    /**
     * The max fitness.
     *
     * @var int
     */
    protected $maxFitness = 0;

    /**
     * The min fitness.
     *
     * @var int
     */
    protected $minFitness = 0;

    /**
     * The mean fitness.
     *
     * @var int
     */
    protected $meanFitness = 0;

    /**
     * Get min fitness.
     *
     * @return int
     *   The min fitness.
     */
    public function getMinFitness(): int
    {
        return $this->minFitness;
    }

    /**
     * Set the min fitness.
     *
     * @param int $minFitness
     *   The min fitness.
     */
    public function setMinFitness(int $minFitness)
    {
        $this->minFitness = $minFitness;
    }

    /**
     * Get the mean fitness.
     *
     * @return int
     *   The mean fitness.
     */
    public function getMeanFitness(): int
    {
        return $this->meanFitness;
    }

    /**
     * Set the mean fitness.
     *
     * @param int $meanFitness
     *   The mean fitness.
     */
    public function setMeanFitness(int $meanFitness)
    {
        $this->meanFitness = $meanFitness;
    }

    /**
     * Get the max fitness.
     *
     * @return int
     *   The max fitness.
     */
    public function getMaxFitness(): int
    {
        return $this->maxFitness;
    }

    /**
     * Set the max fitness.
     *
     * @param int $maxFitness
     *   The max fitness to set.
     */
    public function setMaxFitness(int $maxFitness)
    {
        $this->maxFitness = $maxFitness;
    }

    public function calculateMeanFitness(PopulationInterface $population) {
        $fitnessSum = 0;
        foreach ($population->getIndividuals() as $individual) {
            $fitnessSum += $individual->getFitness();
        }
        $this->setMeanFitness($fitnessSum / $population->getLength());
        return $this->getMeanFitness();
    }
}
