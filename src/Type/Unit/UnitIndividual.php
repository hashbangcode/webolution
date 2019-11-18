<?php

namespace Hashbangcode\Webolution\Type\Unit;

use Hashbangcode\Webolution\Individual;

/**
 * Class UnitIndividual.
 *
 * @package Hashbangcode\Webolution\Individual
 */
class UnitIndividual extends Individual
{
    /**
     * Generate a random Unit individual.
     *
     * @return \Hashbangcode\Webolution\Type\Unit\UnitIndividual
     *   A new UnitIndividual object.
     *
     * @throws \Hashbangcode\Webolution\Type\Unit\Exception\InvalidNumberException
     * @throws \Hashbangcode\Webolution\Type\Unit\Exception\InvalidUnitException
     */
    public static function generateRandomUnit()
    {
        return new self(Unit::generateRandomUnit());
    }

    /**
     * Generate a UnitIndividual object from Unit object, created using a number and a string.
     *
     * @param int $number
     *   The number.
     * @param string $unit
     *   The unit.
     *
     * @return \Hashbangcode\Webolution\Type\Unit\UnitIndividual
     *   A new UnitIndividual object.
     *
     * @throws \Hashbangcode\Webolution\Type\Unit\Exception\InvalidNumberException
     * @throws \Hashbangcode\Webolution\Type\Unit\Exception\InvalidUnitException
     */
    public static function generateFromUnitArguments($number, $unit)
    {
        $unitObject = new Unit($number, $unit);
        return new self($unitObject);
    }

    /**
     * {@inheritdoc}
     */
    public function mutate($mutationFactor = 0, $mutationAmount = 1)
    {
        $action = mt_rand(0, 100) + $mutationFactor;

        if ($action < 75) {
            // Mutate the number component.
            $operators = array('add', 'subtract');

            switch ($operators[array_rand($operators)]) {
                case 'subtract':
                    $this->mutateUnitSubtract($mutationAmount);
                    break;
                case 'add':
                default:
                    $this->mutateUnitAdd($mutationAmount);
                    break;
            }
        } else {
            // Mutate the unit component.
            $units = ['px', 'em', '%', 'auto'];
            $unit = $units[array_rand($units)];
            $this->getObject()->setUnit($unit);
        }
    }

    /**
     * Add an amount to the unit.
     *
     * @param int|float $mutationAmount
     *   The amount to add.
     */
    public function mutateUnitAdd($mutationAmount)
    {
        $this->getObject()->add($mutationAmount);
    }

    /**
     * Subtract an amount from the unit.
     *
     * @param int|float $mutationAmount
     *   The amount to subtract.
     */
    public function mutateUnitSubtract($mutationAmount)
    {
        $this->getObject()->subtract($mutationAmount);
    }

    /**
     * {@inheritdoc}
     */
    public function getFitness($type = '')
    {
        // The fitness of this UnitIndividual is the value of the number attribute.
        return $this->getObject()->getNumber();
    }
}
