<?php

namespace Hashbangcode\Webolution;

use Hashbangcode\Webolution\Individual;
use Hashbangcode\Webolution\Statistics\Statistics;

/**
 * Class Population.
 *
 * @package Hashbangcode\Webolution\Population
 */
abstract class Population implements PopulationInterface
{
    /**
     * The statistics object.
     *
     * @var \Hashbangcode\Webolution\Statistics\Statistics|null
     *   A Statistics object, if created.
     */
    protected $statistics;

    /**
     * The individuals of this population.
     *
     * @var array
     */
    protected $individuals = [];

    /**
     * The default render type.
     *
     * @var string
     */
    protected $defaultRenderType = '';

    /**
     * The population fitness.
     *
     * @var array
     */
    protected $populationFitness = [];

    /**
     * The mean fitness.
     *
     * @var int
     */
    protected $meanFitness;

    /**
     * The median fitness individual object.
     *
     * @var Individual
     */
    protected $medianIndividual;

    /**
     * The minimum fitness individual object.
     *
     * @var Individual
     */
    protected $minIndividual;

    /**
     * The maximum fitness individual object.
     *
     * @var Individual
     */
    protected $maxIndividual;

    /**
     * The mutation factor.
     *
     * @var int
     */
    protected $mutationFactor;

    /**
     * The mutation amount.
     *
     * @var int
     */
    protected $mutationAmount;

    /**
     * The population fitness type.
     *
     * @var string
     */
    protected $populationFitnessType;

    /**
     * Add an individual.
     *
     * @param Individual|null $individual
     *   The individual to add.
     */
    abstract public function addIndividual(Individual $individual = null);

    /**
     * Implementation of the __clone magic method to ensure that all sub-objects of this object also get cloned.
     */
    public function __clone()
    {
        foreach ($this->individuals as $key => $individual) {
            $newIndividual = clone $individual;
            unset($this->individuals[$key]);
            $this->individuals[$key] = $newIndividual;
        }

        if (is_object($this->medianIndividual)) {
            $meanIndividual = clone $this->medianIndividual;
            $this->medianIndividual = $meanIndividual;
        }

        if (is_object($this->minIndividual)) {
            $minIndividual = clone $this->minIndividual;
            $this->minIndividual = $minIndividual;
        }

        if (is_object($this->maxIndividual)) {
            $maxIndividual = clone $this->maxIndividual;
            $this->maxIndividual = $maxIndividual;
        }

        // Remove the statistics object.
        $this->statistics = null;
    }

    /**
     * Make a copy of an individual.
     */
    public function copyIndividual()
    {
        $individual = $this->getRandomIndividual();
        if ($individual !== false) {
            $this->individuals[] = clone $individual;
        }
    }

    /**
     * Get a random individual from the population.
     *
     * @return Individual|bool
     *   An individual from the population. False if failure.
     */
    public function getRandomIndividual()
    {
        if ($this->getIndividualCount() == 0) {
            // No individuals in the array.
            return false;
        }

        // @todo : instead of this being true random it needs to be slanted towards those individuals who are fitter.
        $random_key = array_rand($this->individuals);
        return $this->individuals[$random_key];
    }

    /**
     * Get a number of random individuals.
     *
     * @param int $number
     *
     * @return array|bool
     *   A number of individuals.
     */
    public function getRandomIndividuals($number)
    {
        if ($this->getIndividualCount() == 0) {
            // No individuals in the array.
            return false;
        }

        if ($number > $this->getIndividualCount()) {
            // The number we want is higher than the number of individuals to select from.
            return false;
        }

        // @todo : instead of this being true random it needs to be slanted towards those individuals who are fitter.
        $random_keys = array_rand($this->individuals, $number);
        return [
            0 => $this->individuals[$random_keys[0]],
            1 => $this->individuals[$random_keys[1]],
        ];
    }

    /**
     * Get the length of the population.
     *
     * @return int
     *   Length of population.
     */
    public function getIndividualCount()
    {
        return count($this->individuals);
    }

    /**
     * {@inheritdoc}
     */
    abstract public function sort();

    /**
     * {@inheritdoc}
     */
    public function getIndividuals()
    {
        return $this->individuals;
    }

    /**
     * Set an entire population of individuals.
     *
     * @param array $individuals
     *   An array of individuals.
     */
    public function setIndividuals($individuals)
    {
        $this->individuals = $individuals;
    }

    /**
     * Get the default render type.
     *
     * @return string
     *   The current default render type.
     */
    public function getDefaultRenderType()
    {
        return $this->defaultRenderType;
    }

    /**
     * Set the default render type.
     *
     * @param string $defaultRenderType
     *   What the default render type should be.
     */
    public function setDefaultRenderType($defaultRenderType)
    {
        $this->defaultRenderType = $defaultRenderType;
    }

    /**
     * Mutate the population.
     */
    public function mutatePopulation()
    {
        foreach ($this->getIndividuals() as $key => $individual) {
            $individual->mutate($this->getMutationFactor(), $this->getMutationAmount());
        }
    }

    /**
     * Get the mutation factor.
     *
     * @return int
     *   The mutation factor.
     */
    public function getMutationFactor()
    {
        return $this->mutationFactor;
    }

    /**
     * Set the mutation factor.
     *
     * @param int $mutationFactor
     *   The mutation factor.
     */
    public function setMutationFactor($mutationFactor)
    {
        $this->mutationFactor = $mutationFactor;
    }

    /**
     * Get the mutation amount.
     *
     * @return integer
     *   The mutation amount.
     */
    public function getMutationAmount()
    {
        return $this->mutationAmount;
    }

    /**
     * Set the mutation amount.
     *
     * @param int $mutationAmount
     *   The mutation amount.
     */
    public function setMutationAmount($mutationAmount)
    {
        $this->mutationAmount = $mutationAmount;
    }

    /**
     * Perform a crossover function on certain members of the population.
     */
    abstract public function crossover();

    /**
     * @return bool
     */
    public function generateStatistics()
    {
        if ($this->getIndividualCount() == 0) {
            // No population yet.
            return false;
        }

        $this->setStatistics(new Statistics());
        $this->getStatistics()->extractFitnessIndividuals($this);
        $this->getStatistics()->calculateMeanFitness($this);
    }

    /**
     * Kill any member of the population that is unfit.
     *
     * @param mixed $globalFitnessGoal
     *   The global fitness goal.
     */
    public function cullPopulation($globalFitnessGoal = null)
    {
        // Kill off any unfit individuals.
        foreach ($this->getIndividuals() as $key => $individual) {
            if (!is_null($globalFitnessGoal)) {
                $individual->setFitnessGoal($globalFitnessGoal);
            }

            $fitness = $individual->getFitness($this->getPopulationFitnessType());

            $maxFitness = $this->getStatistics()->getMaxFitness();

            // Figure out if this individual is close to the top of the list.
            if ($maxFitness != 0) {
                $fitnessFactor = ($fitness / $maxFitness);
            } else {
                $fitnessFactor = 0;
            }

            // The higher the allowed fitness then the greater the chance that the individual will survive.
            $rand = (pow(mt_rand(-1, 1), 3) + 1) / 2;
            $keepAlive = ($fitnessFactor >= $rand);

            if (!$keepAlive) {
                $this->removeIndividual($key);
            }
        }
    }

    /**
     * @return string
     */
    public function getPopulationFitnessType()
    {
        return $this->populationFitnessType;
    }

    /**
     * @param string $populationFitnessType
     */
    public function setPopulationFitnessType($populationFitnessType)
    {
        $this->populationFitnessType = $populationFitnessType;
    }

    /**
     * Get the statistics object.
     *
     * @return \Hashbangcode\Webolution\Statistics\Statistics|null
     *   The statistics object.
     */
    public function getStatistics()
    {
        if (is_null($this->statistics)) {
            // If we don't have any statistics yet then generate them.
            $this->generateStatistics();
        }
        return $this->statistics;
    }

    /**
     * Set the statistics object.
     *
     * @param \Hashbangcode\Webolution\Statistics\Statistics $statistics
     *   The statistics object.
     */
    public function setStatistics(Statistics $statistics)
    {
        $this->statistics = $statistics;
    }

    /**
     * Remove an individual from the population.
     *
     * @param int $key
     *   The key of the individual in the individuals array.
     */
    public function removeIndividual($key)
    {
        if (isset($this->individuals[$key])) {
            unset($this->individuals[$key]);
        }
    }
}
