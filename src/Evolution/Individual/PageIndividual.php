<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;

use Hashbangcode\Wevolution\Type\Page\Page;

/**
 * Class PageIndividual
 * @package Hashbangcode\Wevolution\Evolution\Individual
 */
class PageIndividual extends Individual
{

    /**
     * @var int
     */
    protected $mutationFactor = 0.05;

    public function __construct()
    {
        $this->object = new Page();
    }

    /**
     * @return $this
     */
    public function mutateProperties()
    {
        $this->mutateElement($this->getMutationFactor());
        return $this;
    }

    /**
     * Mutate the page.
     *
     * Possible actions to take during mutation.
     * - Chance to mutate body (9/10).
     * - Chance to mutate styles (1/10).
     *
     * @param $factor The amount of variance to apply.
     */
    public function mutateElement($factor)
    {
        $action = mt_rand(0, 100);

        // Get the element.
        $element = $this->getObject();

        if ($action <= $factor && count($element->getAttributes()) > 0) {

            // Mutate styles.
            $element->getStyles()->mutate();

        } elseif ($action >= $factor) {

            // Mutate body.
            $element->getBody()->mutate();
        }
    }

    /**
     * @return int
     */
    public function getFitness()
    {
        // @todo see how we can get a better fitness for elements.
        // Possible candidates include:
        // - number of children
        // - rendered length
        // - number of tags directly under html>body
        return 1;
    }

    /**
     * @param $renderType
     * @return mixed
     */
    public function render($renderType = 'cli')
    {
        $output = '';
        switch ($renderType) {
            case 'html':
                $output .= $this->getObject()->render();
                break;
            case 'cli':
            default:
                $output .= $this->getObject()->render() . PHP_EOL;
        }
        return $output;
    }
}