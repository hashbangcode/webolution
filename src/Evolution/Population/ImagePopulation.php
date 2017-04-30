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
     * @param \Hashbangcode\Wevolution\Evolution\Individual\Individual|null $individual
     */
    public function addIndividual(Individual $individual = null)
    {
        if (is_null($individual)) {
            $image = mt_rand(1, 10);
            $individual = new ImageIndividual($image);
        }
        $this->individuals[] = $individual;
    }

    /**
     *
     */
    public function sort()
    {
        sort($this->individuals);
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
        // @todo implement this.
    }
}