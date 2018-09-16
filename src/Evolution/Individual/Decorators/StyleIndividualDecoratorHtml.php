<?php

namespace Hashbangcode\Webolution\Evolution\Individual\Decorators;

/**
 * Class StyleIndividualDecoratorHtml.
 *
 * @package Hashbangcode\Webolution\Evolution\Individual\Decorators
 */
class StyleIndividualDecoratorHtml extends IndividualDecorator
{
    /**
     * @var string The type of rendering.
     */
    public const TYPE = 'html';

    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $object = $this->getIndividual()->getObject();

        $output = '';

        $output .= $object->getSelector() . '{';

        foreach ($object->getAttributes() as $attribute => $value) {
            // Render the style.
            if (is_object($value)) {
                // Render an object.

                $output .= $attribute . ':';

                // This might be a unit or a color object.
                $individualDecorator = IndividualDecoratorFactory::getIndividualDecorator($value, static::TYPE);
                $output .= $individualDecorator->render();

                $output .= ';';
            } elseif (is_array($value)) {
                // Render an array of objects.
                $output .= $attribute . ':';
                $valueArray = [];
                foreach ($value as $val) {
                    $individualDecorator = IndividualDecoratorFactory::getIndividualDecorator($val, static::TYPE);
                    $valueArray[] = $individualDecorator->render();
                }
                $output .= implode(' ', $valueArray) . ';';
            } else {
                $output .= $attribute . ':' . $value . ';';
            }
        }

        $output .= '}';

        return $output;
    }
}
