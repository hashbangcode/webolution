<?php

namespace Hashbangcode\Wevolution\Evolution\Individual\Decorators;

/**
 * Class StyleIndividualDecoratorCli.
 *
 * @package Hashbangcode\Wevolution\Evolution\Individual\Decorators
 */
class StyleIndividualDecoratorCli extends IndividualDecorator
{
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
                $object->render('css');

                $output .= ';';
            } elseif (is_array($value)) {
                // Render an array of objects.
                $output .= $attribute . ':';
                foreach ($value as $val) {
                    $output .= $val->render() . ' ';
                }
                $output = trim($output) . ';';
            } else {
                $output .= $attribute . ':' . $value . ';';
            }
        }

        $output .= '}';

        return $output;
    }
}
