<?php

namespace Hashbangcode\Wevolution\Evolution\Population;

use Hashbangcode\Wevolution\Evolution\Individual\Individual;
use Hashbangcode\Wevolution\Evolution\Individual\PageIndividual;
use Hashbangcode\Wevolution\Type\Page\Page;

/**
 * Class ElementPopulation.
 *
 * @package Hashbangcode\Wevolution\Evolution\Population
 */
class PagePopulation extends Population
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $output = '';

        // Ensure that the items are sorted.
        $this->sort();

        foreach ($this->getIndividuals() as $individual) {
            $renderType = $this->getDefaultRenderType();

            switch ($renderType) {
                case 'html':
                    $output .= '<iframe class="elementframe" height="200" width="200" srcdoc=\'' . $individual->render($renderType) . '\'></iframe>';
                    break;

                case 'htmltextarea':
                    $output .= '<textarea rows="10" cols="25">' . $individual->render($renderType) . '</textarea>';
                    break;

                case 'htmlfull':
                    $output .= '<iframe class="elementframe" height="200" width="200" srcdoc=\'' . $individual->render($renderType) . '\'></iframe>';
                    $output .= '<textarea rows="35" cols="35">' . $individual->render($renderType) . '</textarea>';
                    break;

                case 'cli':
                default:
                    $output .= $individual->render($renderType);
            }
        }

        return $output;
    }

    /**
     * {@inheritdoc}
     */
    public function sort()
    {
        // Do not sort pages.
    }

    /**
     * Add an individual.
     *
     * @param \Hashbangcode\Wevolution\Evolution\Individual\Individual|null $individual
     *   Add an individual.
     *
     * @return $this
     *   The current object.
     */
    public function addIndividual(Individual $individual = null)
    {
        if (is_null($individual)) {
            $individual = new PageIndividual();
        }

        $this->individuals[] = $individual;

        return $this;
    }

    /**
     * {@inheritdoc}
     */
    public function crossover()
    {
        // @todo implement this.
    }
}
