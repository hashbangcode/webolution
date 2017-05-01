<?php

namespace Hashbangcode\Wevolution\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Individual\Individual;
use Hashbangcode\Wevolution\Evolution\Individual\ImageIndividual;
use Hashbangcode\Wevolution\Type\Image\Image;

/**
 * Class ImagePopulation
 * @package Hashbangcode\Wevolution\Evolution\Population
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
            $individual = new ImageIndividual();
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
    public function sort()
    {
        return $this;
    }

    /**
     * @return string
     */
    public function render()
    {
        $output = parent::render();
        switch ($this->getDefaultRenderType()) {
            case 'html':
                $output .= ' (' . $this->getLength() . ' items)<br>';
                break;
            case 'cli':
                // Intentional fall through.
            default:
                $output .= ' (' . $this->getLength() . ' items)' . PHP_EOL;
                break;
        }
        return $output;
    }

    /**
     * {@inheritdoc}
     */
    public function crossover()
    {
        $individuals = $this->getIndividuals();

        $action = mt_rand(0, 100);

        if ($action <= 1) {
        }
    }

}