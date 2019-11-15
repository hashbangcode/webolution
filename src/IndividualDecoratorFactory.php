<?php

namespace Hashbangcode\Webolution;

use Hashbangcode\Webolution\Exception\IndividualDecoratorNotFoundException;

/**
 * Class IndividualDecoratorFactory.
 *
 * @package Hashbangcode\Webolution\Evolution\Individual\Decorators
 */
class IndividualDecoratorFactory
{

    /**
     * Given a population object and a type of render, find and instansiate the object.
     *
     * @param \Hashbangcode\Webolution\IndividualInterface $Individual
     *   The individual.
     * @param string $type
     *   The current render type.
     *
     * @return \Hashbangcode\Webolution\PopulationDecoratorInterface
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
        $decoratorClass .= '\Decorator\\';
        $decoratorClass .= join('', array_slice(explode('\\', $class), -1)) . 'Decorator' . $type;

        if (!class_exists($decoratorClass)) {
            $message = 'Decorator class ' . $decoratorClass . ' not found from class ' . $class . '.';
            throw new IndividualDecoratorNotFoundException($message);
        }

        $decorator = new $decoratorClass($individual);
        return $decorator;
    }
}