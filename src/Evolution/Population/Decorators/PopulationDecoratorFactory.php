<?php

namespace Hashbangcode\Wevolution\Evolution\Population\Decorators;

use Hashbangcode\Wevolution\Evolution\Population\Decorators\Exception\DecoratorNotFoundException;
use Hashbangcode\Wevolution\Evolution\Population\PopulationInterface;

/**
 * Class PopulationDecoratorFactory.
 *
 * @package Hashbangcode\Wevolution\Evolution\Population\Decorators
 */
class PopulationDecoratorFactory
{

    /**
     * Given a population object and a type of render, find and instansiate the object.
     *
     * @param \Hashbangcode\Wevolution\Evolution\Population\PopulationInterface $population
     *   The population.
     * @param string $type
     *   The current render type.
     *
     * @return \Hashbangcode\Wevolution\Evolution\Population\Decorators\PopulationDecoratorInterface
     *   The recorator.
     *
     * @throws DecoratorNotFoundException
     */
    public static function getPopulationDecorator(PopulationInterface $population, $type)
    {
        // Extract the class name.
        $class = get_class($population);

        // Combine the parts of the class back together again to get the decorator object.
        $decoratorClass = '\\' . implode('\\', array_slice(explode('\\', $class), 0, -1));
        $decoratorClass .= '\Decorators\\';
        $decoratorClass .= join('', array_slice(explode('\\', $class), -1)) . 'Decorator' . $type;

        if (!class_exists($decoratorClass)) {
            throw new DecoratorNotFoundException('Decorator class ' . $decoratorClass . ' not found.');
        }

        $decorator = new $decoratorClass($population);
        return $decorator;
    }
}