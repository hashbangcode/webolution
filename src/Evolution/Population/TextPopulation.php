<?php

namespace Hashbangcode\Wevolution\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Individual\Individual;
use Hashbangcode\Wevolution\Evolution\Individual\TextIndividual;
use Hashbangcode\Wevolution\Type\Text\Text;

/**
 * Class TextPopulation.
 *
 * @package Hashbangcode\Wevolution\Evolution\Population
 */
class TextPopulation extends Population
{
    /**
     * @param mixed $text
     */
    public function setText($text)
    {
        $this->text = $text;
    }

    /**
     * {@inheritdoc}
     */
    public function addIndividual(Individual $individual = null)
    {
        if (is_null($individual)) {
            $individual = TextIndividual::generateRandomTextIndividual();
        }
        $this->individuals[] = $individual;
    }

    /**
     * {@inheritdoc}
     */
    public function sort()
    {
        sort($this->individuals);
    }

    /**
     * {@inheritdoc}
     */
    public function crossover()
    {
        // @todo implement this.
    }
}
