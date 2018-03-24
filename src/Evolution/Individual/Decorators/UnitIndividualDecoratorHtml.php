<?php

namespace Hashbangcode\Wevolution\Evolution\Individual\Decorators;

/**
 * Class UnitIndividualDecoratorCli.
 *
 * @package Hashbangcode\Wevolution\Evolution\Individual\Decorators
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
