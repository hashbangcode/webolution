<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;

use Hashbangcode\Wevolution\Type\Style\Style;

use Hashbangcode\Wevolution\Evolution\Individual\ColorIndividual;

/**
 * Class StyleIndividual
 * @package Hashbangcode\Wevolution\Evolution\Individual
 */
class StyleIndividual extends Individual
{
    /**
     * StyleIndividual constructor.
     *
     * @param string|Style $selector
     *   If string is passed then this is used to create the Style object. If an Element object is passed then this is
     *   used as the object.
     */
    public function __construct($selector)
    {
        if (!($selector instanceof Style)) {
            $this->object = new Style($selector);
        } else {
            $this->object = $selector;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function mutate($mutationFactor = 0, $mutationAmount = 1)
    {
        // Figure out the action we are going to take.
        $action = mt_rand(0, 100);
        $action = $action + $mutationFactor;

        $style = $this->getObject();

        if ($action <= 75) {
            // Add a attribute to the Style.
            $this->addAttribute();
        } elseif (count($style->getAttributes()) > 0) {
            // Select an attribute.
            $attributes = $style->getAttributes();
            $selected = array_rand($attributes);

            // Mutate the attribute.
            $attributes[$selected] = $this->mutateAttribute($selected, $attributes[$selected]);
        }
    }

    /**
     * Add an attribute to the Style object.
     */
    public function addAttribute()
    {
        // Get the style object.
        $style = $this->getObject();

        $attributes = [
            'color',
            'background-color',
        ];
        $attribute = $attributes[array_rand($attributes)];

        switch ($attribute) {
            case 'color':
                if ($style->getAttribute('color') == false) {
                    $style->setAttribute('color', ColorIndividual::generateRandomColor());
                }
                break;
            case 'background-color':
                if ($style->getAttribute('background-color') == false) {
                    $style->setAttribute('background-color', ColorIndividual::generateRandomColor());
                }
                break;
            case 'padding':
                break;
            case 'margin':
                break;
            case 'position':
                break;
            case 'float':
                break;
            case 'border':
                break;
            case '':
                break;
        }
    }

    /**
     * Mutate the selector.
     */
    public function mutateSelector()
    {
        $style = $this->getObject();
        $selector = $style->getSelector();

        $selector = explode(' ', $selector);

        $action = mt_rand(0, 100);

        if ($action < 10 && isset($selector[1])) {
            // Alter the class being selected.
            $selector[1] = '.wibble';
        } elseif ($action < 10 && !isset($selector[1])) {
            // Add a class attribute.
            $selector[1] = '.test';
        } elseif ($action > 10 && $action <= 75) {
            // Alter the type of attribute being selected
            $element = ['body', 'div', 'p', 'ol', 'ul', 'li'];

            $selector[0] = $element[array_rand($element)];
        }

        $this->getObject()->setSelector(implode(' ', $selector));
    }

    /**
     * Mutate an attribute.
     *
     * @param string $attribute
     *   The attribute name.
     * @param mixed $attributeProperty
     *   The property.
     *
     * @return mixed
     *   The mutated attribute.
     */
    public function mutateAttribute($attribute, $attributeProperty)
    {

        switch ($attribute) {
            case 'color':
            case 'background-color':
                $attributeProperty->mutate(0, 1000);
                break;
        }

        return $attributeProperty;
    }

    /**
     * {@inheritdoc}
     */
    public function getFitness($type = '')
    {
        return 1;
    }

    /**
     * {@inheritdoc}
     */
    public function render($renderType = 'cli')
    {
        $output = '';
        switch ($renderType) {
            case 'html':
                $output .= $this->getObject()->render() . '<br>';
                break;
            case 'cli':
            default:
                $output .= $this->getObject()->render() . PHP_EOL;
        }
        return $output;
    }
}
