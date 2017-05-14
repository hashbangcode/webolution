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

        // Get the body.
        $body = $this->getObject()->getBody();

        // Get styles.
        $styles = $this->getObject()->getStyles();

        // If the body isn't an individual then wrap it so we can mutate it.
        if (!($body instanceof \Hashbangcode\Wevolution\Evolution\Individual\Individual)) {
            $body = new ElementIndividual($body);
        }

        if ($action <= $mutationFactor) {
            // Mutate styles.
            $randomStyle = $styles[array_rand($styles)];
            if (!($randomStyle instanceof \Hashbangcode\Wevolution\Evolution\Individual\Individual)) {
                $randomStyle = new StyleIndividual($randomStyle);
            }

            $randomStyle->mutate();

        } elseif ($action >= $mutationFactor) {
            // Mutate body.
            $body->mutate();
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
