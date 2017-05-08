<?php

namespace Hashbangcode\Wevolution\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Individual\Individual;

/**
 * Class Population
 * @package Hashbangcode\Wevolution\Evolution\Population
 */
abstract class Population implements PopulationInterface
{
    /**
     * The individuals of this population.
     *
     * @var array
     */
    protected $individuals = array();

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
    protected $populationFitness = array();

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
     * Add an individual.
     *
     * @param Individual|null $individual
     *   The individual to add.
     *
     * @return null
     */
    abstract public function addIndividual(Individual $individual = null);

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

    /**
     *
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
        if ($this->getLength() == 0) {
            return false;
        }

        $random_key = array_rand($this->individuals);
        if (!is_null($random_key)) {
            return $this->individuals[$random_key];
        }

        return false;
    }

    /**
     * Get the length of the population.
     *
     * @return int
     *   Length of population.
     */
    public function getLength()
    {
        return count($this->individuals);
    }

    /**
     * Render the entire population.
     *
     * @return string
     *   The rendered population.
     */
    public function render()
    {
        $output = '';

        // Ensure that the items are sorted before rendering.
        $this->sort();

        /* @var Individual $individual */
        foreach ($this->getIndividuals() as $individual) {
            $output .= $individual->render($this->getDefaultRenderType());
        }

        return $output;
    }

    /**
     * @return mixed
     */
    abstract public function sort();

    /**
     * @return array
     */
    public function getIndividuals()
    {
        return $this->individuals;
    }

    /**
     * @return string
     *   The current default render type.
     */
    public function getDefaultRenderType()
    {
        return $this->defaultRenderType;
    }

    /**
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

        // Run the crossover function.
        $this->crossover();
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

        if ($this->getLength() == 0) {
            // No population yet.
            return false;
        }

        // Sort the current population.
        $this->sort();

        foreach ($this->getIndividuals() as $key => $individual) {
            $fitness = $individual->getFitness();

            // Store Max.
            if (!is_object($this->maxIndividual) || $fitness > $this->maxIndividual->getFitness()) {
                $this->maxIndividual = $individual;
            }

            // Store Min.
            if (!is_object($this->minIndividual) || $fitness < $this->minIndividual->getFitness()) {
                $this->minIndividual = $individual;
            }

            $this->populationFitness[] = $fitness;
        }

        // Calculate mean.
        $this->meanFitness = array_sum($this->populationFitness) / $this->getLength();

        // Get Median.
        // @todo check this.
        //$this->medianIndividual = array_slice($this->getIndividuals(), $this->getIndividuals()[floor(($this->getLength() - 1) / 2)], 1);
    }

    /**
     * @return array
     */
    public function getStatistics()
    {
        return [
            'min' => $this->minIndividual,
            'max' => $this->maxIndividual,
            'median' => $this->medianIndividual,
            'meanFitness' => $this->meanFitness,
        ];
    }

    /**
     * Cull population.
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

            $maxFitness = $this->getStatistics()['max']->getFitness($this->getPopulationFitnessType());

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
}
