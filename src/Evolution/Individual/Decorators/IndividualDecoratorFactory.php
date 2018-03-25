<?php

namespace Hashbangcode\Wevolution\Evolution\Individual\Decorators;

use Hashbangcode\Wevolution\Evolution\Individual\Decorators\Exception\IndividualDecoratorNotFoundException;
use Hashbangcode\Wevolution\Evolution\Individual\IndividualInterface;

/**
 * Class IndividualDecoratorFactory.
 *
 * @package Hashbangcode\Wevolution\Evolution\Individual\Decorators
 */
class IndividualDecoratorFactory
{

    /**
     * Given a population object and a type of render, find and instansiate the object.
     *
     * @param \Hashbangcode\Wevolution\Evolution\Individual\IndividualInterface $individual
     *   The individual.
     * @param string $type
     *   The current render type.
     *
     * @return \Hashbangcode\Wevolution\Evolution\Population\Decorators\PopulationDecoratorInterface
     *   The decorator.
     *
     * @throws IndividualDecoratorNotFoundException
     */
    public static function getIndividualDecorator(IndividualInterface $individual, $type)
    {
        // Ensure that the first letter of the type is capitalised.
        $type = ucfirst($type);

        // Extract the class name.
        $class = get_class($individual);

        // Combine the parts of the class back together again to get the decorator object.
        $decoratorClass = '\\' . implode('\\', array_slice(explode('\\', $class), 0, -1));
        $decoratorClass .= '\Decorators\\';
        $decoratorClass .= join('', array_slice(explode('\\', $class), -1)) . 'Decorator' . $type;

        if (!class_exists($decoratorClass)) {
            throw new IndividualDecoratorNotFoundException('Decorator class ' . $decoratorClass . ' not found.');
        }

        $decorator = new $decoratorClass($individual);
        return $decorator;
    }
}