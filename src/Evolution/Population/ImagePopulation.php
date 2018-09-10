<?php

namespace Hashbangcode\Webolution\Evolution\Population;

use Hashbangcode\Webolution\Evolution\Individual\Individual;
use Hashbangcode\Webolution\Evolution\Individual\ImageIndividual;
use Hashbangcode\Webolution\Type\Image\Image;

/**
 * Class ImagePopulation.
 *
 * @package Hashbangcode\Webolution\Evolution\Population
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
        usort($this->individuals, function ($a, $b) use ($direction) {

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
        // Get two individuals from the population.
        $individuals = $this->getRandomIndividuals(2);

        // Make sure we have Individuals to use.
        if ($individuals == false) {
            // Add a clone of a individual individual.
            $randomIndividual = $this->getRandomIndividual();
            $this->addIndividual(clone $randomIndividual);

            // Don't do anything else.
            return;
        }

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

        // Create a new individual using the new matrix.
        $individualNew = ImageIndividual::generateFromMatrix($newMatrix);

        // Add the individual to the population.
        $this->addIndividual($individualNew);
    }
}
