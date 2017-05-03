<?php

namespace Hashbangcode\Wevolution\Evolution;

use Hashbangcode\Wevolution\Evolution\Population\Population;

/**
 * Class Evolution
 * @package Hashbangcode\Wevolution\Evolution
 */
class Evolution
{

    /**
     * @var mixed|null
     *   The global fitness goal.
     */
    public $globalFitnessGoal = null;

    /**
     * @var int
     *   The current generation.
     */
    protected $generation = 1;

    /**
     * @var int
     *   The global mutation factor.
     */
    protected $globalMutationFactor;

    /**
     * The global mutation amount.
     * @var int
     */
    protected $globalMutationAmount;
    /**
     * @var int
     *   The maximum number of generations to run.
     */
    protected $maxGenerations;
    /**
     * @var int
     *   The minimum number of individuals per generation.
     */
    protected $individualsPerGeneration;
    /**
     * @var int
     *   The allowed fitness value.
     */
    protected $allowedFitness = 8;
    /**
     * @var Population
     *   The current Population object.
     */
    protected $population;
    /**
     * @var array
     *   A store of the previous generations.
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
     * @return int|null
     */
    public function getIndividualsPerGeneration()
    {
        return $this->individualsPerGeneration;
    }

    /**
     * @param int|null $individualsPerGeneration
     */
    public function setIndividualsPerGeneration($individualsPerGeneration)
    {
        $this->individualsPerGeneration = $individualsPerGeneration;
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
     * @return bool
     */
    public function runGeneration($kill = true)
    {
        // Ensure the population has a length.
        if ($this->population->getLength() == 0) {
            // If there is no population left then set the number of generations to max.
            $this->generation = $this->getMaxGenerations();
            return false;
        }

        $this->generation++;

        // Generate statistics before we do anything with the population.
        $this->population->generateStatistics();

        // kill off anything that we don't want

        if ($kill) {
            // Kill off any unfit individuals.
            foreach ($this->population->getIndividuals() as $key => $individual) {
                if (!is_null($this->getGlobalFitnessGoal())) {
                    $individual->setFitnessGoal($this->getGlobalFitnessGoal());
                }

                $fitness = $individual->getFitness();
                $maxFitness = $this->population->getStatistics()['max']->getFitness();

                // Figure out if this individual is close to the top of the list.
                if ($maxFitness != 0) {
                    $fitnessFactor = ($fitness / $maxFitness);
                } else {
                    $fitnessFactor = 0;
                }

                // The higher the allowed fitness then the greater the chance that the individual will survive.

                $rand = (pow(mt_rand(-1, 1), 3) + 1) / 2; //cube function
                $keepAlive = ($fitnessFactor >= $rand);

                if (!$keepAlive) {
                    $this->population->removeIndividual($key);
                }
            }
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

        //print 'PRE TEST: <pre>'.print_r($this->population->getStatistics(), true) . '</pre>';

        // Mutate the population.
        // @todo should this be part of the population class?
        foreach ($this->population->getIndividuals() as $key => $individual) {
            if (!is_null($this->getGlobalMutationFactor())) {
                $individual->setMutationFactor($this->getGlobalMutationFactor());
            }
            if (!is_null($this->getGlobalMutationAmount())) {
                $individual->setMutationAmount($this->getGlobalMutationAmount());
            }
            $individual->mutate($individual->getMutationFactor(), $individual->getMutationAmount());
        }

        // Run the crossover function.
        $this->population->crossover();

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
     * @param $population
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
