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

        if ($action <= 5) {
            // Mutate selector.
            $this->mutateSelector();
        } elseif ($action > 5 && $action <= 50) {
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

        if ($style->getAttribute('color') == false) {
            $style->setAttrbute('color', ColorIndividual::generateRandomColor());
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
