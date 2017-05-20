<?php

namespace Hashbangcode\Wevolution\Evolution;

use Hashbangcode\Wevolution\Evolution\Evolution;

/**
 * Class EvolutionManager.
 *
 * @package Hashbangcode\Wevolution\Evolution
 */
class EvolutionManager
{
    /**
     * The evolution object.
     *
     * @var Evolution
     */
    public $evolutionObject;

    /**
     * EvolutionManager constructor.
     */
    public function __construct()
    {
        $this->setEvolutionObject(new Evolution());
    }

    /**
     * Get the evolution object.
     *
     * @return Evolution
     *   The evolution object.
     */
    public function getEvolutionObject()
    {
        return $this->evolutionObject;
    }

    /**
     * Set the evolution object.
     *
     * @param Evolution $evolutionObject
     *   The evolution object.
     */
    public function setEvolutionObject(Evolution $evolutionObject)
    {
        $this->evolutionObject = $evolutionObject;
    }

    /**
     * Set some options for the Evolution object.
     *
     * @param int $individualsPerGeneration
     *   The number of individuals per generation.
     * @param int $maxGenerations
     *   The maximum number of generations to run.
     * @param int $allowedFitness
     *   The allowed fitness.
     * @param int $globalMutationFactor
     *   The global mutation factor.
     * @param int $globalMutationAmount
     *   The global mutation amount.
     */
    public function setUpEvolution(
        $individualsPerGeneration = 30,
        $maxGenerations = 30,
        $allowedFitness = 1,
        $globalMutationFactor = 1,
        $globalMutationAmount = 1
    ) {
        $this->getEvolutionObject()->setIndividualsPerGeneration($individualsPerGeneration);
        $this->getEvolutionObject()->setMaxGenerations($maxGenerations);
        $this->getEvolutionObject()->setAllowedFitness($allowedFitness);
        $this->getEvolutionObject()->setGlobalMutationFactor($globalMutationFactor);
        $this->getEvolutionObject()->setGlobalMutationAmount($globalMutationAmount);
    }

    /**
     * Run the Evolution process.
     */
    public function runEvolution()
    {
        // Keep running the evolution until the runGeneration() method returns false.
        for ($i = 0; $i < $this->getEvolutionObject()->getMaxGenerations(); ++$i) {
            if ($this->getEvolutionObject()->runGeneration() === false) {
                // If the runGeneration() method is false then we need to stop processing.
                break;
            }
        }
    }
}
