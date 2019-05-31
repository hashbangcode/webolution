<?php

namespace Hashbangcode\Webolution\Evolution\Population;

use Hashbangcode\Webolution\Evolution\Individual\Individual;
use Hashbangcode\Webolution\Evolution\Individual\ColorIndividual;

/**
 * Class ColorPopulation.
 *
 * @package Hashbangcode\Webolution\Evolution\Population
 */
class ColorPopulation extends Population
{
    /**
     * Sort the population by a given parameter and in a certain direction.
     *
     * @param string $sortBy
     *   What to sort the population by.
     * @param string $direction
     *   Which direction to sort the population.
     *
     * @return $this
     *   The current object.
     */
    public function sort($sortBy = 'hue', $direction = 'ASC')
    {
        uasort($this->individuals, function ($a, $b) use ($sortBy, $direction) {

            switch ($sortBy) {
                case 'hue':
                    $aValue = $a->getObject()->getHue();
                    $bValue = $b->getObject()->getHue();
                    break;
                case 'hex':
                    $aValue = $a->getObject()->getHex();
                    $bValue = $b->getObject()->getHex();
                    break;
                case 'hsv_saturation':
                    $aValue = $a->getObject()->getHsvSaturation();
                    $bValue = $b->getObject()->getHsvSaturation();
                    break;
                case 'hsl_saturation':
                    $aValue = $a->getObject()->getHslSaturation();
                    $bValue = $b->getObject()->getHslSaturation();
                    break;
                case 'hsi_saturation':
                    $aValue = $a->getObject()->getHsiSaturation();
                    $bValue = $b->getObject()->getHsiSaturation();
                    break;
                case 'value':
                    $aValue = $a->getObject()->getValue();
                    $bValue = $b->getObject()->getValue();
                    break;
                case 'luma':
                    $aValue = $a->getObject()->getLuma();
                    $bValue = $b->getObject()->getLuma();
                    break;
                case 'lightness':
                    $aValue = $a->getObject()->getLightness();
                    $bValue = $b->getObject()->getLightness();
                    break;
                case 'fitness':
                default:
                    $aValue = $a->getFitness();
                    $bValue = $b->getFitness();
                    break;
            }

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
    public function addIndividual(Individual $individual = null)
    {
        if (is_null($individual)) {
            $individual = ColorIndividual::generateRandomColor();
        }
        $this->individuals[] = $individual;
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

        // Get the hex value for the two colors.
        $hex1 = str_split($individuals[0]->getObject()->getHex());
        $hex2 = str_split($individuals[1]->getObject()->getHex());

        // Combine the two colors together.
        $newHex = $hex1[0] . $hex2[1] . $hex1[2] . $hex2[3] . $hex1[4] . $hex2[5];

        // Create a new individual using the new color.
        $individualNew = ColorIndividual::generateFromHex($newHex);

        // Add the individual to the population.
        $this->addIndividual($individualNew);
    }
}
