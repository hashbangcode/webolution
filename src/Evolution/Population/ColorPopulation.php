<?php

namespace Hashbangcode\Wevolution\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Individual\Individual;
use Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual;

/**
 * Class ColorPopulation
 * @package Hashbangcode\Wevolution\Evolution\Population
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
        usort($this->individuals, function ($a, $b) use ($sortBy, $direction) {

            switch ($sortBy) {
                case 'hue':
                    $aValue = $a->getObject()->getHue();
                    $bValue = $b->getObject()->getHue();
                    break;
                case 'hex':
                    $aValue = $a->getObject()->getHex();
                    $bValue = $b->getObject()->getHex();
                    break;
                case 'intensity':
                    // @todo : not implented.
                    $aValue = $a->getObject()->getIntensity();
                    $bValue = $b->getObject()->getIntensity();
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
        // @todo implement this.
    }
}
