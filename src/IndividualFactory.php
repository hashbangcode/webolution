<?php

namespace Hashbangcode\Webolution;

use Hashbangcode\Webolution\Exception\IndividualNotFoundException;
use Hashbangcode\Webolution\Type\TypeInterface;

/**
 * Class IndividualFactory.
 *
 * @package Hashbangcode\Webolution\Individual\
 */
class IndividualFactory
{

    /**
     * Given a population object and a type of render, find and instantiate the object.
     *
     * @param \Hashbangcode\Webolution\Type\TypeInterface $type
     *   The individual.
     *
     * @return \Hashbangcode\Webolution\PopulationInterface
     *   The decorator.
     *
     * @throws IndividualNotFoundException
     */
    public static function getIndividual(TypeInterface $type)
    {
        // Extract the class name.
        $class = get_class($type);

        // Grab the parts of the class.
        $class = explode('\\', $class);

        // Reconstruct the class name that we need.
        $individualClass = '\\' . $class[0];
        $individualClass .= '\\' . $class[1];
        $individualClass .= '\\' . 'Type';

        $classType = array_pop($class);
        $individualClass .= '\\' . $classType;
        $individualClass .= '\\' . $classType . 'Individual';

        $decorator = new $individualClass($type);
        return $decorator;
    }
}
