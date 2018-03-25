<?php

namespace Hashbangcode\Wevolution\Evolution\Individual;

use Hashbangcode\Wevolution\Type\Unit\Unit;

/**
 * Class UnitIndividual
 * @package Hashbangcode\Wevolution\Evolution\Individual
 */
class UnitIndividual extends Individual
{
    /**
     * Generate a random Unit individual.
     *
     * @return \Hashbangcode\Wevolution\Evolution\Individual\UnitIndividual
     */
    public static function generateRandomUnit()
    {
        $number = mt_rand(1, 100);
        $units = ['px', 'em', '%', 'auto'];
        $unit = $units[array_rand($units)];
        $unitObject = new Unit($number, $unit);
        return new self($unitObject);
    }

    /**
     * @param $number
     * @param $unit
     * @return UnitIndividual
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
