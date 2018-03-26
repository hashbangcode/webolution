<?php

namespace Hashbangcode\Wevolution\Evolution\Individual\Decorators;

/**
 * Class ElementIndividualDecoratorCli.
 *
 * @package Hashbangcode\Wevolution\Evolution\Individual\Decorators
 */
class ElementIndividualDecoratorCli extends IndividualDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $object = $this->getIndividual()->getObject();

        if ($object->getType() === false && is_object($object->getObject())) {
            $individualDecorator = IndividualDecoratorFactory::getIndividualDecorator($object, 'cli');
            return $individualDecorator->render();
        }

        $output = '';

        $output .= '<' . $object->getType();

        if ($object->getAttributes() > 0) {
            $attributes = array();
            foreach ($object->getAttributes() as $attribute => $value) {
                $attributes[] = $attribute . '="' . $value . '"';
            }
            $output .= ' ' . implode(' ', $attributes);
        }

        $output .= '>';

        if (count($object->getChildren()) > 0) {
            foreach ($object->getChildren() as $index => $child) {
                $individualDecorator = IndividualDecoratorFactory::getIndividualDecorator($child, 'cli');
                $output .= $individualDecorator->render();
            }
        }

        $output .= $object->getElementText();

        $output .= '</' . $object->getType() . '>';
        return $output;
    }
}
