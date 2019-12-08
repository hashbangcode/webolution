<?php

namespace Hashbangcode\Webolution\Type\Image;

use Hashbangcode\Webolution\Population;
use Hashbangcode\Webolution\Individual;

/**
 * Class ImagePopulation.
 *
 * @package Hashbangcode\Webolution\Population
 */
class ImagePopulation extends Population
{
    /**
     * Add an individual.
     *
     * @param Individual|null $individual
     *   The Individual to add (optional).
     *
     * @return $this
     *   The current object.
     */
    public function addIndividual(Individual $individual = null)
    {
        if (is_null($individual)) {
            $individual = ImageIndividual::generateRandomImage();
        }
        $this->individuals[] = $individual;

        return $this;
    }

    /**
     * Sort the population.
     *
     * @return $this
     *   The current object.
     */
    public function sort($direction = 'ASC')
    {
        uasort($this->individuals, function ($a, $b) use ($direction) {

            $aValue = $a->getFitness($this->getPopulationFitnessType());
            $bValue = $b->getFitness($this->getPopulationFitnessType());

            if ($aValue == $bValue) {
                return 0;
            }

            if ($direction == 'ASC') {
                return ($aValue < $bValue) ? -1 : 1;
            } else {
                return ($aValue > $bValue) ? -1 : 1;
            }
        });

        return $this;
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

        // Get the matrix for the two images.
        $matrix1 = $individuals[0]->getObject()->getImageMatrix();
        $matrix2 = $individuals[1]->getObject()->getImageMatrix();

        // Combine the two matrices together by adding alternative rows from each matrix.
        $newMatrix = [];
        foreach ($matrix1 as $xId => $x) {
            foreach ($matrix1[$xId] as $yId => $y) {
                if ($yId % 2) {
                    $newMatrix[$xId][$yId] = $matrix1[$xId][$yId];
                } else {
                    $newMatrix[$xId][$yId] = $matrix2[$xId][$yId];
                }
            }
        }

        // Create a new individual using the new matrix and add to the population.
        $this->addIndividual(ImageIndividual::generateFromMatrix($newMatrix));
    }
}
