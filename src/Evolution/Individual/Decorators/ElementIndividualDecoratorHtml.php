<?php

namespace Hashbangcode\Webolution\Evolution\Individual\Decorators;

use Hashbangcode\Webolution\Evolution\Individual\ElementIndividual;
use Hashbangcode\Webolution\Evolution\Individual\IndividualInterface;

/**
 * Class ElementIndividualDecoratorHtml.
 *
 * @package Hashbangcode\Webolution\Evolution\Individual\Decorators
 */
class ElementIndividualDecoratorHtml extends IndividualDecorator
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

        if ($object->getType() === false && is_object($object->getObject())) {
            $individualDecorator = IndividualDecoratorFactory::getIndividualDecorator($object, static::TYPE);
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
                if (($child instanceof IndividualInterface) == false) {
                    $individualChild = new ElementIndividual($child);
                    $individualDecorator = IndividualDecoratorFactory::getIndividualDecorator($individualChild, static::TYPE);
                } else {
                    $individualDecorator = IndividualDecoratorFactory::getIndividualDecorator($child, static::TYPE);
                }
                $output .= $individualDecorator->render();
            }
        }

        $output .= $object->getElementText();

        $output .= '</' . $object->getType() . '>';

        return $output;
    }
}
