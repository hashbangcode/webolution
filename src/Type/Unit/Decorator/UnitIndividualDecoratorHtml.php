<?php

namespace Hashbangcode\Webolution\Type\Unit\Decorator;

use Hashbangcode\Webolution\IndividualDecorator;

/**
 * Class UnitIndividualDecoratorCli.
 *
 * @package Hashbangcode\Webolution\Type\Unit\Decorator
 */
class UnitIndividualDecoratorHtml extends IndividualDecorator
{
    /**
     * {@inheritdoc}
     */
    public function render()
    {
        $object = $this->getIndividual()->getObject();

        if ($object->getUnit() == 'auto') {
            // If the unit is 'auto' then return just that.
            return 'auto';
        }

        // Return the combination of number and unit.
        return $object->getNumber() . '' . $object->getUnit();
    }
}
