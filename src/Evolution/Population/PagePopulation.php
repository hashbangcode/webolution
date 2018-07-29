<?php

namespace Hashbangcode\Webolution\Evolution\Population;

use Hashbangcode\Webolution\Evolution\Individual\Individual;
use Hashbangcode\Webolution\Evolution\Individual\PageIndividual;
use Hashbangcode\Webolution\Type\Element\Element;
use Hashbangcode\Webolution\Type\Page\Page;
use Hashbangcode\Webolution\Type\Style\Style;

/**
 * Class ElementPopulation.
 *
 * @package Hashbangcode\Webolution\Evolution\Population
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
              case self::RENDER_HTML:
                    $output .= '<iframe class="elementframe" height="200" width="200" srcdoc=\'' . $individual->render($renderType) . '\'></iframe>';
                    break;

                case 'htmltextarea':
                    $output .= '<textarea rows="10" cols="25">' . $individual->render($renderType) . '</textarea>';
                    break;

                case 'htmlfull':
                    $output .= '<iframe class="elementframe" height="200" width="200" srcdoc=\'' . $individual->render($renderType) . '\'></iframe>';
                    $output .= '<textarea rows="35" cols="35">' . $individual->render($renderType) . '</textarea>';
                    break;

                case self::RENDER_CLI:
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
     * @param \Hashbangcode\Webolution\Evolution\Individual\Individual|null $individual
     *   Add an individual.
     *
     * @return $this
     *   The current object.
     */
    public function addIndividual(Individual $individual = null)
    {
        if (is_null($individual)) {
            $individual = PageIndividual::generateBlankPage();

            $element = new Element('div');
            $individual->getObject()->setBody($element);

            $style_object = new Style('div');
            $individual->getObject()->setStyle($style_object);
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
