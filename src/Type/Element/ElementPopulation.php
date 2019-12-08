<?php

namespace Hashbangcode\Webolution\Type\Element;

use Hashbangcode\Webolution\Population;
use Hashbangcode\Webolution\Individual;

/**
 * Class ElementPopulation.
 *
 * @package Hashbangcode\Webolution\Population
 */
class ElementPopulation extends Population
{
    /**
     * {@inheritdoc}
     */
    public function sort()
    {
        // Don't sort this type of population.
    }

    /**
     * {@inheritdoc}
     */
    public function addIndividual(Individual $individual = null)
    {
        if (is_null($individual)) {
            $individual = ElementIndividual::generateFromElementType('div');
        }
        $this->individuals[] = $individual;
    }

    /**
     * {@inheritdoc}
     */
    public function crossover()
    {
        if ($this->getIndividualCount() == 0) {
            return;
        }

        if ($this->getIndividualCount() == 1) {
            // Add a clone of a individual individual.
            $randomIndividual = $this->getRandomIndividual();
            $this->addIndividual(clone $randomIndividual);
            return;
        }

        // Get two individuals from the population.
        $individuals = $this->getRandomIndividuals(2);

        $rootElement = $individuals[0]->getObject()->getType();
        $rootAttributes = $individuals[0]->getObject()->getAttributes();

        $newElement = ElementIndividual::generateFromElementType($rootElement);
        $newElement->getObject()->setAttributes($rootAttributes);

        $randomChildElement = $individuals[1]->getObject()->getRandomElement();
        if ($randomChildElement) {
            $newElement->getObject()->addChild($randomChildElement);
        }

        // Create a new individual using the new matrix and add to the population.
        $this->addIndividual($newElement);
    }
}
