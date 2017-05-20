<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;

use Hashbangcode\Wevolution\Type\Element\Element;

/**
 * Class ElementIndividual
 * @package Hashbangcode\Wevolution\Evolution\Individual
 */
class ElementIndividual extends Individual
{
    /**
     * ElementIndividual constructor.
     *
     * @param string|Element $element
     *   If string is passed then this is used to create the Element object. If an Element object is passed then this is
     *   used as the object.
     */
    public function __construct($element)
    {
        if (!($element instanceof Element)) {
            $this->object = new Element($element);
        } else {
            $this->object = $element;
        }
    }

    /**
     * {@inheritdoc}
     *
     * Possible actions to take during mutation.
     * - Alter attributes (9/10).
     * - Add additional children (1/10).
     *
     * This should not alter the tag itself. Also, certain elements
     * should only get certain children. For example, a ul
     * or a ol element should only get a li or a.
     */
    public function mutate($mutationFactor = 0, $mutationAmount = 1)
    {
        $action = mt_rand(0, 100);

        // Get the element.
        $element = $this->getObject();

        if ($action <= $mutationFactor && count($element->getAttributes()) > 0) {
            // Mutate an attribute.
            $attributes = $element->getAttributes();

            $random_attribute = array_rand($attributes);
            $letters = range('a', 'z');
            $letter = $letters[array_rand($letters)];

            $attribute_value = $attributes[$random_attribute] . $letter;

            if (strlen($attribute_value) > 10) {
                // Don't let the attribute get longer than 10 characters.
                $attribute_value = substr($attribute_value, -8);
            }

            $attributes[$random_attribute] = $attribute_value;

            $element->setAttributes($attributes);
        } elseif ($action >= $mutationFactor) {
            // Add additional children elements.
            $child_types = $element->getAvailableChildTypes($element->getType());
            $child_type = $child_types[array_rand($child_types)];
            $newElement = new Element($child_type);

            $newElement->setAttribute('class', 'test');

            $element->addChild($newElement);
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFitness($type = '')
    {
        // @todo see how we can get a better fitness for elements.
        // Possible candidates include:
        // - number of children
        // - rendered length
        // - number of tags directly under html>body
        // - length of text attribute.
        return 1;
    }

    /**
     * @param $renderType
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
            default:
                $output .= $this->getObject()->render() . PHP_EOL;
        }
        return $output;
    }
}
