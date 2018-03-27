<?php

namespace Hashbangcode\Wevolution\Evolution\Individual\Decorators;

/**
 * Class StyleIndividualDecoratorHtml.
 *
 * @package Hashbangcode\Wevolution\Evolution\Individual\Decorators
 */
class StyleIndividualDecoratorHtml extends IndividualDecorator
{
    /**
     * The type of rendering.
     *
     * @var string
     */
    protected $type = 'html';

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
                $individualDecorator = IndividualDecoratorFactory::getIndividualDecorator($value, $this->type);
                $output .= $individualDecorator->render();

                $output .= ';';
            } elseif (is_array($value)) {
                // Render an array of objects.
                $output .= $attribute . ':';
                $valueArray = [];
                foreach ($value as $val) {
                    $individualDecorator = IndividualDecoratorFactory::getIndividualDecorator($val, $this->type);
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
