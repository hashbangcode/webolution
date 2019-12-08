<?php

namespace Hashbangcode\Webolution\Type\Style;

use Hashbangcode\Webolution\Population;
use Hashbangcode\Webolution\Individual;

/**
 * Class StylePopulation.
 *
 * @package Hashbangcode\Webolution\Population
 */
class StylePopulation extends Population
{
    /**
     * {@inheritdoc}
     */
    public function sort()
    {
        // Don't sort style elements.
    }

    /**
     * {@inheritdoc}
     */
    public function addIndividual(Individual $individual = null)
    {
        if (is_null($individual)) {
            $individual = new StyleIndividual(new Style());
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

        $selector = $individuals[0]->getObject()->getSelector();
        $attributes = $individuals[1]->getObject()->getAttributes();

        $newStyle = StyleIndividual::generateFromSelector($selector);
        $newStyle->getObject()->setAttributes($attributes);

        // Create a new individual using the new matrix and add to the population.
        $this->addIndividual($newStyle);
    }
}
