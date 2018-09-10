<?php

namespace Hashbangcode\Webolution\Evolution\Individual;

use Hashbangcode\Webolution\Type\Style\Style;
use Hashbangcode\Webolution\Generators\RandomText;
use Hashbangcode\Webolution\Evolution\Individual\ColorIndividual;

/**
 * Class StyleIndividual.
 *
 * @package Hashbangcode\Webolution\Evolution\Individual
 */
class StyleIndividual extends Individual
{
    use RandomText;

    /**
     * StyleIndividual constructor.
     *
     * @param string $selector
     *   If string is passed then this is used to create the Style object. If an Element object is passed then this is
     *   used as the object.
     *
     * @return StyleIndividual
     *   A StyleIndividual object.
     */
    public static function generateFromSelector($selector)
    {
        $styleObject = new Style($selector);
        return new self($styleObject);
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

        if ($action <= 50) {
            if ($action <= 25) {
                // Add a attribute to the Style.
                $this->addAttribute();
            } else {
                $this->mutateSelector();
            }
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
            'float',
            'position',
            'clear',
            'padding',
            'margin',
            'width',
            'height',
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
            case 'float':
                $floats = [
                    'left',
                    'right',
                    'none',
                ];
                $style->setAttribute('float', $floats[array_rand($floats)]);
                break;
            case 'position':
                $positions = [
                    'static',
                    'relative',
                    'absolute',
                    'sticky',
                    'fixed',
                ];
                $style->setAttribute('position', $positions[array_rand($positions)]);
                break;
            case 'clear':
                $clears = [
                    'none',
                    'left',
                    'right',
                    'both',
                ];
                $style->setAttribute('clear', $clears[array_rand($clears)]);
                break;
            case 'text-align':
                $textAlign = [
                    'start',
                    'end',
                    'left',
                    'right',
                    'center',
                    'justify',
                    'match-parent',
                ];
                $style->setAttribute('text-align', $textAlign[array_rand($textAlign)]);
                break;
            case 'padding':
                $units = [
                    UnitIndividual::generateRandomUnit(),
                    UnitIndividual::generateRandomUnit(),
                    UnitIndividual::generateRandomUnit(),
                    UnitIndividual::generateRandomUnit(),
                ];
                $style->setAttribute('padding', $units);
                break;
            case 'margin':
                $units = [
                    UnitIndividual::generateRandomUnit(),
                    UnitIndividual::generateRandomUnit(),
                    UnitIndividual::generateRandomUnit(),
                    UnitIndividual::generateRandomUnit(),
                ];
                $style->setAttribute('margin', $units);
                break;
            case 'width':
                $style->setAttribute('width', UnitIndividual::generateRandomUnit());
                break;
            case 'height':
                $style->setAttribute('height', UnitIndividual::generateRandomUnit());
                break;
            case 'border':
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
            $selector[1] = '.' . $this->getRandomLetter();
        } elseif ($action < 10 && !isset($selector[1])) {
            // Add a class attribute.
            $selector[1] = '.' . $this->generateRandomText();
        } elseif ($action > 10 && $action <= 75) {
            // Alter the type of attribute being selected
            $element = ['body', 'div', 'span', 'p', 'ol', 'ul', 'li', 'h1', 'h2', 'h3', 'h4', 'h5'];
            $selector[0] = $element[array_rand($element)];
        }

        $this->getObject()->setSelector(implode('', $selector) . ' ');
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
            case 'float':
                $floats = [
                    'left',
                    'right',
                    'none',
                ];
                return $floats[array_rand($floats)];
            case 'position':
                $positions = [
                    'static',
                    'relative',
                    'absolute',
                    'sticky',
                    'fixed',
                ];
                return $positions[array_rand($positions)];
            case 'clear':
                $clears = [
                    'none',
                    'left',
                    'right',
                    'both',
                ];
                return $clears[array_rand($clears)];
            case 'text-align':
                $textAlign = [
                    'start',
                    'end',
                    'left',
                    'right',
                    'center',
                    'justify',
                    'match-parent',
                ];
                return $textAlign[array_rand($textAlign)];
            case 'padding':
                $randomUnit = array_rand($attributeProperty);
                $unit = $attributeProperty[$randomUnit];
                $unit->mutate();
                break;
            case 'margin':
                $randomUnit = array_rand($attributeProperty);
                $unit = $attributeProperty[$randomUnit];
                $unit->mutate();
                break;
            case 'width':
                $attributeProperty->mutate(0, 1000);
                break;
            case 'height':
                $attributeProperty->mutate(0, 1000);
                break;
            case 'border':
                break;
        }
    }

    /**
     * {@inheritdoc}
     */
    public function getFitness($type = '')
    {
        $fitness = 0;
        if ($this->isSelectorId() == false) {
            $fitness++;
        }

        $attributes = $this->getObject()->getAttributes();

        $fitness += count($attributes);
        return $fitness;
    }

    /**
     * Is the selector an ID?
     *
     * @return bool
     *   True if the selector is an ID.
     */
    public function isSelectorId()
    {
        $selector = $this->getObject()->getSelector();

        if (substr($selector, 0, 1) == '#') {
            return true;
        }

        return false;
    }
}
