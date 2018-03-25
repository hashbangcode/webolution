<?php

namespace Hashbangcode\Wevolution\Evolution\Individual\Decorators;

/**
 * Class ElementIndividualDecoratorHtml.
 *
 * @package Hashbangcode\Wevolution\Evolution\Individual\Decorators
 */
class ElementIndividualDecoratorHtml extends IndividualDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        ////return $this->getIndividual()->getObject()->getHex() . PHP_EOL;
        $object = $this->getIndividual()->getObject();

        if ($object->getType() === false && is_object($object->getObject())) {
            IndividualDecoratorFactory::getIndividualDecorator($object);
            return $this->getObject()->render();
        }

    }

    public function oldrender()
    {


        $output = '';

        $output .= '<' . $this->getType();

        if ($this->getAttributes() > 0) {
            $attributes = array();
            foreach ($this->getAttributes() as $attribute => $value) {
                $attributes[] = $attribute . '="' . $value . '"';
            }
            $output .= ' ' . implode(' ', $attributes);
        }

        $output .= '>';

        if (count($this->getChildren()) > 0) {
            foreach ($this->getChildren() as $index => $child) {

                $output .= $child->render();

            }
        }

        $output .= $this->getElementText();

        $output .= '</' . $this->getType() . '>';
        return $output;
    }
}
