<?php

namespace Hashbangcode\Wevolution\Evolution;

use Hashbangcode\Wevolution\Evolution\Population\Population;

/**
 * Class Evolution.
 *
 * @package Hashbangcode\Wevolution\Evolution
 */
class Evolution
{
    /**
     * The global fitness goal.
     *
     * @var mixed|null
     */
    public $globalFitnessGoal = null;

    /**
     * The current generation.
     *
     * @var int
     */
    protected $generation = 1;

    /**
     * The global mutation factor.
     *
     * @var int
     */
    protected $globalMutationFactor;

    /**
     * The global mutation amount.
     *
     * @var int
     */
    protected $globalMutationAmount;

    /**
     * The maximum number of generations to run.
     *
     * @var int
     */
    protected $maxGenerations;

    /**
     * The minimum number of individuals per generation.
     *
     * @var int
     */
    protected $individualsPerGeneration;

    /**
     * The allowed fitness value.
     *
     * @var int
     */
    protected $allowedFitness = 8;

    /**
     * The current Population object.
     *
     * @var Population
     */
    protected $population;

    /**
     * A store of the previous generations.
     *
     * @var array
     */
    protected $previousGenerations = array();

    /**
     * Evolution constructor.
     *
     * @param Population|null $population
     *   The Population object to start off things with.
     * @param int|null $maxGenerations
     *   The maximum number of generations to run.
     * @param int|null $individualsPerGeneration
     *   Set how many individuals are allowed per generation.
     * @param bool $autoGeneratePopulation
     *   Whether to auto generate the population. Defaults to false.
     */
    public function __construct(Population $population = null, $maxGenerations = null, $individualsPerGeneration = null, $autoGeneratePopulation = false)
    {
        if (!is_null($maxGenerations)) {
            $this->setMaxGenerations($maxGenerations);
        } else {
            $this->setMaxGenerations(10);
        }

        if (!is_null($individualsPerGeneration)) {
            $this->setIndividualsPerGeneration($individualsPerGeneration);
        } else {
            $this->setMaxGenerations(10);
        }

        if (!is_null($population)) {
            $this->population = $population;
            $this->population->generateStatistics();

            self::storeGeneration($population);

            // Setup initial Population.
            if ($autoGeneratePopulation === true
                && $this->population->getLength() < $this->getIndividualsPerGeneration()
            ) {
                // Get the population object to generate individuals.
                do {
                    // @todo we should be cloning and then mutating these things if there is at least one individual present instead of just creating new ones.
                    $this->population->addIndividual();
                } while ($this->population->getLength() < $this->getIndividualsPerGeneration());
            }
        }
    }

    /**
     * Store the current population in the previous generations array.
     *
     * @param Population $population
     *   The current population.
     */
    public function storeGeneration(Population $population)
    {
        $this->previousGenerations[$this->generation] = clone $population;
    }

    /**
     * Get the number of individuals per generation.
     *
     * @return int
     *   The number of indiviudals per generation.
     */
    public function getIndividualsPerGeneration()
    {
        return $this->individualsPerGeneration;
    }

    /**
     * Set the individuals per generation.
     *
     * @param int $individualsPerGeneration
     *   The number of individuals per generation.
     */
    public function setIndividualsPerGeneration($individualsPerGeneration)
    {
        $this->individualsPerGeneration = $individualsPerGeneration;
    }

    /**
     * Set the Population object.
     *
     * @param Population $population
     *   The Population object.
     */
    public function setPopulation($population)
    {
        $this->population = $population;
    }

    /**
     * Run a generation.
     *
     * @return bool
     *   True if successful. False if everyone dies.
     */
    public function runGeneration($kill = true)
    {
        // Ensure the population has a length.
        if ($this->population->getLength() == 0) {
            // If there is no population left then set the number of generations to max.
            $this->generation = $this->getMaxGenerations();
            return false;
        }

        // Increate the generation number.
        $this->generation++;

        // Generate statistics before we do anything with the population.
        $this->population->generateStatistics();

        // Kill off anything that we don't want.
        if ($kill) {
            $this->population->cullPopulation($this->getGlobalFitnessGoal());
        }

        if ($this->population->getLength() == 0) {
            // If there is no population left then set the number of generations to max.
            $this->generation = $this->getMaxGenerations();
            return false;
        }

        // Ensure the population is at the right level.
        if ($this->population->getLength() < $this->getIndividualsPerGeneration()) {
            do {
                // Clone an individual from the current population to add back in.
                $random_individual = $this->population->getRandomIndividual();
                if (is_object($random_individual)) {
                    $this->population->addIndividual(clone $random_individual);
                } else {
                    // Add a random individual (not cloned from the current population).
                    $this->population->addIndividual();
                }
            } while ($this->population->getLength() < $this->getIndividualsPerGeneration());
        }


        if (!is_null($this->getGlobalMutationFactor())) {
            $this->population->setMutationFactor($this->getGlobalMutationFactor());
        }
        if (!is_null($this->getGlobalMutationAmount())) {
            $this->population->setMutationAmount($this->getGlobalMutationAmount());
        }

        // Mutate the population.
        $this->population->mutatePopulation();

        // Store the current generation.
        $this->addPreviousGeneration(clone $this->getCurrentPopulation());

        return true;
    }

    /**
     * Get the maximum number of generations.
     *
     * @return int|null
     *   The maximum number of generations.
     */
    public function getMaxGenerations()
    {
        return $this->maxGenerations;
    }

    /**
     * Set the maximum number of generations.
     *
     * @param int|null $maxGenerations
     *   The maximum number of generations.
     */
    public function setMaxGenerations($maxGenerations)
    {
        $this->maxGenerations = $maxGenerations;
    }

    /**
     * Get the global fitness goal.
     *
     * @return mixed
     *   The global fitness goal.
     */
    public function getGlobalFitnessGoal()
    {
        return $this->globalFitnessGoal;
    }

    /**
     * Set the global fitness goal.
     *
     * @param mixed $globalFitnessGoal
     *   The global fitness goal.
     */
    public function setGlobalFitnessGoal($globalFitnessGoal)
    {
        $this->globalFitnessGoal = $globalFitnessGoal;
    }

    /**
     * Get the global mutation factor.
     *
     * @return int|null
     *   The global mutation factor.
     */
    public function getGlobalMutationFactor()
    {
        return $this->globalMutationFactor;
    }

    /**
     * @param null $globalMutationFactor
     */
    public function setGlobalMutationFactor($globalMutationFactor)
    {
        $this->globalMutationFactor = $globalMutationFactor;
    }

    /**
     * @return int
     */
    public function getGlobalMutationAmount()
    {
        return $this->globalMutationAmount;
    }

    /**
     * @param int $globalMutationAmount
     */
    public function setGlobalMutationAmount($globalMutationAmount)
    {
        $this->globalMutationAmount = $globalMutationAmount;
    }

    /**
     * Add a population to the previous list of populations.
     *
     * @param Population $population
     *   The population object to add.
     */
    public function addPreviousGeneration($population)
    {
        $this->previousGenerations[$this->generation] = clone $population;
    }

    /**
     * Get the current Population object.
     *
     * @return Population
     *   The current Population object.
     */
    public function getCurrentPopulation()
    {
        return $this->population;
    }

    /**
     * Render the entire thing.
     *
     * @param bool $printStats
     *   Print the stats.
     * @param string $format
     *   What format to print the
     *
     * @return string
     *   The rendered output.
     */
    public function renderGenerations($printStats = false, $format = 'html')
    {
        $output = '';

        /* @var Population $population */
        foreach ($this->previousGenerations as $generation_number => $population) {
            $output .= $generation_number . ':<br>' . $population->render() . PHP_EOL . '<br>';

            if ($printStats === true) {
                $stats = $population->getStatistics();
                $output .= 'MIN: ' . print_r($stats['min']->render(), true) . '<br>';
                $output .= 'MAX: ' . print_r($stats['max']->render(), true) . '<br>';
            }
        }

        if ($format == 'cli') {
            $output = preg_replace('/\<br(\s*)?\/?\>/i', "\n", $output);
        }

        return $output;
    }

    /**
     * Get the current generation.
     *
     * @return int
     *   The current generation.
     */
    public function getGeneration()
    {
        return $this->generation;
    }

    /**
     * Get the allowed fitness value.
     *
     * @return int
     *   The current allowed fitness.
     */
    public function getAllowedFitness()
    {
        return $this->allowedFitness;
    }

    /**
     * Set the allowed fitness.
     *
     * @param int $allowedFitness
     *   The allowed fitness.
     */
    public function setAllowedFitness($allowedFitness)
    {
        $this->allowedFitness = $allowedFitness;
    }
}
