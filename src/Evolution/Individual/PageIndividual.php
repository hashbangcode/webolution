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

    /**
     * PageIndividual constructor.
     */
    public function __construct()
    {
        $this->object = new Page();
    }

    /**
     * {@inheritdoc}
     *
     * Possible actions to take during mutation.
     * - Chance to mutate body (9/10).
     * - Chance to mutate styles (1/10).
     */
    public function mutate($mutationFactor = 0, $mutationAmount = 1)
    {
        $action = mt_rand(0, 100);

        // Get the element.
        $element = $this->getObject();

        if ($action <= $mutationFactor && count($element->getAttributes()) > 0) {
            // Mutate styles.
            $element->getStyles()->mutate();

        } elseif ($action >= $mutationFactor) {
            // Mutate body.
            $element->getBody()->mutate();

        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFitness($type = '')
    {
        // @todo see how we can get a better fitness for pages.
        // Possible candidates include:
        // - number of elements
        return 1;
    }

    /**
     * @param string $renderType
     *   What type of render to perform.
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
                // Intentional fall through.
            default:
                $output .= $this->getObject()->render() . PHP_EOL;
        }
        return $output;
    }
}
