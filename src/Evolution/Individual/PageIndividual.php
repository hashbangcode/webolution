<?php

namespace Hashbangcode\Webolution\Evolution\Individual;

use Hashbangcode\Webolution\Type\Page\Page;
use Hashbangcode\Webolution\Type\Style\Style;

/**
 * Class PageIndividual
 * @package Hashbangcode\Webolution\Evolution\Individual
 */
class PageIndividual extends Individual
{

    /**
     * Generate a blank page.
     *
     * @return PageIndividual
     *   The new PageIndividual object.
     */
    public static function generateBlankPage()
    {
        return new self(new Page());
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
        $action = mt_rand(0, 100) + $mutationFactor;

        if ($action <= 70) {
            $this->mutateStyle($mutationAmount);
        } elseif ($action > 70) {
            $this->mutateBody($mutationAmount);
        }

        // Ensure that the styles we have in place make sense.
        $this->getObject()->generateStylesFromBody();
        $this->getObject()->purgeStylesWithoutElements();
    }

    /**
     * Mutate the body.
     *
     * @param int $mutationAmount
     *   The amount to mutate.
     */
    public function mutateBody($mutationAmount)
    {
        // Get the body.
        $body = $this->getObject()->getBody();

        // Mutate the body.
        if (!($body instanceof IndividualInterface)) {
            // If the body isn't an individual then wrap it so we can mutate it.
            $body = new ElementIndividual($body);
        }

        // Mutate body.
        $body->mutate($mutationAmount);
    }

    /**
     * Mutate the tyle.
     *
     * @param int $mutationAmount
     *   The amount to mutate.
     */
    public function mutateStyle($mutationAmount)
    {
        // Get styles.
        $styles = $this->getObject()->getStyles();

        // Mutate styles.
        $randomStyle = $styles[array_rand($styles)];
        if (!($randomStyle instanceof IndividualInterface)) {
            // If the style is not an individual then wrap it so we can mutate it.
            $randomStyle = new StyleIndividual($randomStyle);
        }

        // Mutate the random style.
        $randomStyle->mutate($mutationAmount);
    }

    /**
     * {@inheritdoc}
     */
    public function getFitness($type = '')
    {
        $fitness = 0;

        // Get the number of elements contained within the object.
        $elements = $this->getObject()->getBody()->getAllElements();
        $fitness += count($elements);

        // Get the number of classes in the element.
        $classes = $this->getObject()->getBodyClasses();
        $fitness += count($classes);

        // Get the number of types of elements.
        $types = $this->getObject()->getBodyElementTypes();
        $fitness += count($types);

        return $fitness;
    }
}
