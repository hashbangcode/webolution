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
     * @var int
     */
    protected $mutationFactor = 0.05;

    /**
     * StyleIndividual constructor.
     * @param $element
     */
    public function __construct($element)
    {
        if (!($element instanceof Style)) {
            $this->object = new Style($element);
        } else {
            $this->object = $element;
        }
    }

    /**
     * @return $this
     */
    public function mutateProperties()
    {
        $this->mutateStyle($this->getMutationFactor());
        return $this;
    }

    /**
     * Mutate the element.
     *
     * @param $factor The amount of variance to apply.
     */
    public function mutateStyle($factor)
    {
        $action = mt_rand(0, 100);

        $action = $action + $factor;

        $style = $this->getObject();

        if ($action <= 5) {
            // Mutate selector
            //$selector = $style->getSelector();

            $this->mutateSelector();

            //$selector = $this->mutateSelector();

            //$this->getObject()->setSelector($selector);

        } elseif ($action > 5 && $action <= 50) {
            // Add a attribute to the Style.
            if ($style->getAttribute('color') == false) {
                $style->setAttrbute('color', ColorIndividual::generateRandomColor());
            }

        } elseif (count($style->getAttributes()) > 0) {
            // Select an attribute and mutate it.
            $attributes = $style->getAttributes();
            $selectedAttribute = array_rand($attributes);
            $attributes[$selectedAttribute] = $this->mutateAttribute($selectedAttribute, $attributes[$selectedAttribute]);
        }
    }

    /**
     *
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
     * @param $attribute
     * @param $attributeProperty
     * @return mixed
     */
    public function mutateAttribute($attribute, $attributeProperty)
    {

        switch ($attribute) {
            case 'color':

                $attributeProperty->mutateColor(1000);

                break;
        }

        return $attributeProperty;
    }

    /**
     * @return int
     */
    public function getFitness()
    {
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
                $output .= $this->getObject()->render() . '<br>';
                break;
            case 'cli':
            default:
                $output .= $this->getObject()->render() . PHP_EOL;
        }
        return $output;
    }
}