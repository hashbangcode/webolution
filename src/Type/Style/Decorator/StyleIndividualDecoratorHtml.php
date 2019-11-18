<?php

namespace Hashbangcode\Webolution\Type\Style\Decorator;

use Hashbangcode\Webolution\IndividualDecorator;
use Hashbangcode\Webolution\IndividualDecoratorFactory;
use Hashbangcode\Webolution\Type\Color\ColorIndividual;
use Hashbangcode\Webolution\Type\Style\StyleIndividual;
use Hashbangcode\Webolution\Type\Color\Color;

/**
 * Class StyleIndividualDecoratorHtml.
 *
 * @package Hashbangcode\Webolution\Type\Style\Decorators
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
                if ($value instanceof ColorIndividual) {
                  // Printing colors in CSS needs a special situation.
                  $type = 'css';
                }
                else {
                  // Otherwise we just use the default.
                  $type = static::TYPE;
                }

                $individualDecorator = IndividualDecoratorFactory::getIndividualDecorator($value, $type);

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
