<?php

namespace Hashbangcode\Webolution;

use Hashbangcode\Webolution\Exception\PopulationDecoratorNotFoundException;

/**
 * Class PopulationDecoratorFactory.
 *
 * @package Hashbangcode\Webolution
 */
class PopulationDecoratorFactory
{
    /**
     * Given a population object and a type of render, find and instansiate the object.
     *
     * @param \Hashbangcode\Webolution\PopulationInterface $population
     *   The population.
     * @param string $type
     *   The current render type.
     *
     * @return \Hashbangcode\Webolution\PopulationDecoratorInterface
     *   The decorator.
     *
     * @throws PopulationDecoratorNotFoundException
     */
    public static function getPopulationDecorator(PopulationInterface $population, $type)
    {
        // Ensure that the first letter of the type is capitalised.
        $type = ucfirst($type);

        // Extract the class name.
        $class = get_class($population);

        // Combine the parts of the class back together again to get the decorator object.
        $decoratorClass = '\\' . implode('\\', array_slice(explode('\\', $class), 0, -1));
        $decoratorClass .= '\Decorator\\';
        $decoratorClass .= join('', array_slice(explode('\\', $class), -1)) . 'Decorator' . $type;

        if (!class_exists($decoratorClass)) {
            throw new PopulationDecoratorNotFoundException('Decorator class ' . $decoratorClass . ' not found.');
        }

        $decorator = new $decoratorClass($population);
        return $decorator;
    }
}
