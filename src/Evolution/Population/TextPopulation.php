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
    public function render()
    {
        $output = parent::render();
        switch ($this->getDefaultRenderType()) {
            case 'html':
                $output .= ' (' . $this->getLength() . ' items)<br>';
                break;
            case 'cli':
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

        $text1 = str_split($individuals[0]->getObject()->getText());
        $text2 = str_split($individuals[1]->getObject()->getText());

        $newText = '';

        $text1Count = count($text1);
        $text2Count = count($text2);


        if ($text1Count >= $text2Count) {
            foreach ($text1 as $id => $letter) {
                if ($id % 2 || !isset($text2[$id])) {
                    $newText .= $text1[$id];
                } elseif (isset($text2[$id])) {
                    $newText .= $text2[$id];
                }
            }
        } elseif ($text1Count < $text2Count) {
            foreach ($text2 as $id => $letter) {
                if ($id % 2 || !isset($text1[$id])) {
                    $newText .= $text2[$id];
                } elseif (isset($text1[$id])) {
                    $newText .= $text1[$id];
                }
            }
        }


        // Create a new individual.
        $individualNew = TextIndividual::generateFromString($newText);

        // Add the individual to the population.
        $this->addIndividual($individualNew);
    }
}
